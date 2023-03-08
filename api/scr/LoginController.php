<?php
#Validation of data happens here

class LoginController
{
    public function __construct(private LoginGateway $gateway)
    {
    }

    public function process_request(string $method)
    {
        switch($method){
        
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($data);
                if ( ! empty($errors)) {
                http_response_code(422);
                echo json_encode(["errors" => $errors]);
                break;
                }

            
                $token = $this->gateway->get_auth_token($data['email'], $data['password']);
                if ($token){

                    http_response_code(201);
                
                    echo json_encode(["auth_token"=>$token]);
                    break;
                }
                http_response_code(401);
                echo json_encode(["message"=>"wrong email or password"]);

                break;
                
        
            default:
                http_response_code(405);
                header("Allow: POST");
        }
    
    }

    private function get_validation_errors(array $data): array
    {
        $errors = [];

        if (empty($data["email"])){
            $errors[] = "email is required";

        }
        if (empty($data["password"])){
            $errors[] = "password is required";
        }
        return $errors;
    }
}
