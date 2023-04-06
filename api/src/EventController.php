<?php


class EventController
{
    public function __construct(private EventGateway $gateway)
    {
    }

    public function process_request(string $method, ?string $id = null)
    {
        switch ($method) {

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                // Check if data is set.
                if (!isset($data['event_name']) || !isset($data['track_id']) || !isset($data['startdate']) || !isset($data['enddate']) || !isset($data['host_email']) || !isset($data['eimage']) || !isset($data['open_for_entry']) || !isset($data['public_view']) || !isset($data['description'])) {
                    http_response_code(422);
                    echo json_encode(["error" => "Missing required data"]);
                    break;
                }

                $event = $this->gateway->create_event(
                    $data['event_name'],
                    $data['track_id'],
                    $data['startdate'],
                    $data['enddate'],
                    $data['host_email'],
                    $data['eimage'],
                    $data['open_for_entry'],
                    $data['public_view'],
                    $data['description']
                );


                http_response_code(201);
                echo json_encode([
                    "Message" => "Event Created Successfully",
                    "error" => $event
                ]);
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
                $data = $_GET;
                if ($id != null) {
                    $event = $this->gateway->get_event($id);

                    // Check if event is not found
                    if (!$event) {
                        http_response_code(404);
                        echo json_encode(["error" => "Event not found"]);
                        break;
                    }

                    http_response_code(200);
                    echo json_encode($event);
                } else if (isset($data["participant1"])) {
                    $events = $this->gateway->get_user_events($data["participant1"]);

                    // Check if participant1 is missing
                    if (!$events) {
                        http_response_code(404);
                        echo json_encode(["error" => "Missing participant1 parameter"]);
                        break;
                    }

                    http_response_code(200);
                    echo json_encode(["events" => $events]);
                } else {
                    $events = $this->gateway->get_all_events();
                    http_response_code(200);
                    echo json_encode($events);
                }
                break;

            case "DELETE":
                $data = $this->gateway->get_event_p($id);

                // Check if data is not found
                if (!$data) {
                    http_response_code(404);
                    echo json_encode(["error" => "Event dosn't exict"]);
                    break;
                }

                $rows = $this->gateway->delete_event($data['event_id']);

                http_response_code(200);
                echo json_encode(["message" => "Event deleted"]);

                break;


            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $event = $this->gateway->get_event_p($id);

                // Check if event is not found
                if (!$event) {
                    http_response_code(404);
                    echo json_encode(["error" => "Event not found"]);
                    break;
                }

                $result = $this->gateway->update_event($event, $data);

                http_response_code(201);
                echo json_encode([
                    "error" => $result,
                    "Message" => "Event Updated Successfully"
            ]);

                break;


                default:
                    http_response_code(405);
                    header("Allow: POST, DELETE, PATCH, GET");
        }
    }
}
