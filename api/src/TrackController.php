<?php


class TrackController
{
    public function __construct(private TrackGateway $gateway)
    {
    }

    public function process_request(string $method)
    {
        switch($method){
            case "GET":

                echo json_encode($this->gateway->GetAll()); //GetAll() can be found in the TrackGateway file 
                                                          //along with all subsequent functions used in like Update() and Delete()

                break;

            case "POST":

                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $id = $this->gateway->Create($data);

                echo json_encode([
                    "message" => "Track successfully created",
                    "id" => $id
                ])

                break;

            case "PATCH":

                $data = (array) json_decode(file_get_contents("php://input"),true);

                $rows = $this->gateway->Update($Track, $data);
                
                echo json_encode([
                    "message" => "Track $track_id has been updated",
                    "rows" => $rows
                ]);

                break;

            case "DELETE":
                $rows = $this->gateway->Delete($id);
                echo json_encode([
                    "message"=>"Track $track_id has been deleted",
                    "rows" => $rows
                ]);
                break;
        }
    }
}