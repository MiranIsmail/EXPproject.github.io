<?php
#Validation of data happens here

class AccountController
{
    public function __construct(private AccountGateway $gateway)
    {
    }

    public function process_request(string $method)
    {

        switch ($method) {
            case "GET":
                if (defined("AUTH_TOKEN")) {
                    $data = $this->gateway->get_account_data(AUTH_TOKEN);
                    http_response_code(201);
                    echo json_encode($data);
                }

                break;
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($method, $data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }


                $additional_parameters = array_diff_key($data, ["email" => 1, "first_name" => 1, "last_name" => 1, "password" => 1]);
                $this->gateway->create_account($data["email"], $data["first_name"], $data["last_name"], $data["password"], $additional_parameters);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                break;



            case "DELETE":
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($method, $data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $data = $this->gateway->edit_account_info($data, AUTH_TOKEN);
                http_response_code(201);
                echo json_encode($data);

                break;

            default:
                http_response_code(405);
                header("Allow: POST, DELETE, PATCH, GET");
        }
    }
    private function get_validation_errors(string $method, array $data): array
    {
        $errors = [];
        $requirements = ["first_name", "last_name", "email", "password"];
        $additional_parameters = ["organization", "height", "weight", "birthdate", "equipment"];
        switch ($method) {
            case "PATCH":
                $requirements = [];
                $additional_parameters = ["organization", "height", "weight", "birthdate", "equipment", "first_name", "last_name", "pimage"];
            case "POST":

                foreach ($requirements as $attribut) {
                    if (empty($data[$attribut])) {
                        $errors[] = "$attribut is required";
                    }
                }

                foreach ($data as $key => $_) {
                    if (!(in_array($key, $requirements) or in_array($key, $additional_parameters))) {
                        $errors[] = "$key is not valid parameter name";
                    }
                }

                if (array_key_exists("height", $data)) {
                    if (filter_var($data["height"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 50, "max_range" => 281]]) == false) {
                        $errors[] = "Height must be integer and between 50-280cm";
                    }
                }

                if (array_key_exists("weight", $data)) {
                    if (filter_var($data["weight"], FILTER_VALIDATE_FLOAT, ["options" => ["min_rage" => 0.0, "max_range" => 700.1]]) == false) {
                        $errors[] = "Weight must be a float between 0.0-700.0 kg";
                    }
                }
        }
        return $errors;
    }
}
