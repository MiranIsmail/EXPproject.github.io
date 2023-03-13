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

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($method, $data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                break;



            case "DELETE":
            case "PATCH":
            default:
                http_response_code(405);
                header("Allow: POST, DELETE, PATCH, GET");
        }
    }
    private function get_validation_errors(string $method, array $data): array
    {
        $errors = [];
        switch ($method) {
            case "POST":
                $requirements = ["first_name", "last_name", "email", "password"];

                foreach ($requirements as $attribut) {
                    if (empty($data[$attribut])) {
                        $errors[] = "$attribut is required";
                    }
                }

                if (array_key_exists("height", $data)) {
                    if (filter_var($data["height"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 50, "max_range" => 281]]) == false) {
                        $errors[] = "Height must be integer and between 50-280cm";
                    }
                }

                if (array_key_exists("age", $data)) {
                    if (filter_var($data["age"], FILTER_VALIDATE_INT, ["options" => ["min_rage" => 0, "max_range" => 190]])) {
                        $errors[] = "Age must be an integer between 0-190 year";
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
