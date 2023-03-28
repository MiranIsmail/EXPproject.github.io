<?php
class ResultsController
{
    public function __construct(private ResultsGateway $gateway)
    {
    }

    public function process_request(string $method)
    {
        switch ($method) {
            case "GET":
                $data = $_GET
                if isset($data["participant1"]) {
                    if ($data["participant1"]) {
                        $event_results = $this->gateway->get_user_results($data["participant1"]);
                        http_response_code(200);
                        echo json_encode(["results" => $event_results]);
                    }
                }
                
                else if isset($data["event_id"]) {
                    if ($data["event_id"]) {
                        $event_results = $this->gateway->get_event_results($data["event_id"]);
                        http_response_code(200);
                        echo json_encode(["results" => $event_results]);
                    }
                }
            
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($data);
                $this->gateway->add_result($data["event_id"], $data["track_time"], $data["participant1"], $data["participant2"], $data["track_time"]);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
            case "DELETE":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->get_validation_errors($data);
                $this->gateway->delete_result($data["event_id"], $data["participant1"]);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

            default:
                http_response_code(405);
                header("Allow: POST, DELETE, GET ");
    }
}
    private function get_validation_errors(array $data): array
    {
        $errors = [];

        if (empty($data["event_id"])) {
            $errors[] = "event_id is required";
        }
        if (empty($data["track_time"])) {
            $errors[] = "track_time is required";
        }
        if (empty($data["participant1"])) {
            $errors[] = "participant1 is required";
        }
        if (empty($data["participant2"])) {
            $errors[] = "participant2 is required";
        }
        return $errors;
    }
}