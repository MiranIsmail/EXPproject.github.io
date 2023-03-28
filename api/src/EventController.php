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
                
                ###
                $event = new Event($data['name'], $data['description'], $data['start_time'], $data['end_time']);

                try {
                    $id = $this->gateway->create_event($event);
                    http_response_code(201);
                    echo json_encode([
                        "message" => "Event created successfully"
                        "id" => $id
                    ]);
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(["error" => "Failed to create event"]);
                }
    
                break;
                ###

                /*$errors = $this->get_validation_errors($method, $data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }*/
                /*break;*/

            case "GET":
                $data = (array) json_decode(file_get_contents("php://input"), true);
            default:
                http_response_code(405);
                header("Allow: POST, DELETE, PATCH, GET");
        }
    }
}
