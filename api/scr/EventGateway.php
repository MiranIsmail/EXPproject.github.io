<?php
class EventGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    
    }
    public function create_event(array $data)
    {
        $sql = "INSERT INTO Competition(event_name, track_id, host_email, host_organisation, start_date, end_date, module_id, open_for_entry, public_view)
        VALUES ('$data["event_name"]', '$data["track_id"]', '$data["host_email"]', '$data["start_date"]', '$data["end_date]', '$data["module_id"]', '$data["open_for_entry"]', '$data["public_view"]')" 


    }
}