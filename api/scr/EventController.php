<?php


class EventController
{
    public function __construct(private EventGateway $gateway)
    {
    }

    public function process_request(string $method)
    {
        switch ($method) {

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                /*$errors = $this->get_validation_errors($method, $data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }*/
                break;

            case "GET":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $res = $this->gateway->get_event($data);
                echo json_encode($res);
        }
    }
}
