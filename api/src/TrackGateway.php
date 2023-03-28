<?php
class TrackGateway extends Gateway
{

    private PDO $conn;

    public function __construct(Database $database){
        $this->conn = $database->get_connection();
    }

    public function GetAll(): array{ // Prints out all of the existing tracks for a GET request
        
        $sql = "SELECT * FROM `Track` WHERE 1";//test
        $stmt = $this->conn->query($sql);
        $data = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        
        return $data;
    }

    public function Create(array $data): string{ //creates a new track with the given variables

        $sql = "INSERT INTO `Track`(`track_id`, `track_name`, `start_station`, `end_station`) 
        VALUES (:track_id,:track_name,:start_station,:end_station)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":track_id", $data["track_id"], PDO::PARAM_INT);
        $stmt->bindValue(":track_name", $data["track_name"], PDO::PARAM_STR);
        $stmt->bindValue(":start_station", $data["start_station"], PDO::PARAM_INT);
        $stmt->bindValue(":end_station", $data["end_station"], PDO::PARAM_INT);

        $stmt->execute();
        return $this->conn->lastInsertID();
    }

    public function Update(array $current, array $new): int{ //changes all the elements given new id's, returns how many were affected

        $sql = "UPDATE `Track` SET `track_id`=:track_id,`track_name`=:track_name,`start_station`=
        :start_station,`end_station`=:end_station WHERE 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":track_id", $new["track_id"] ?? $current["track_id"], PDO::PARAM_INT);
        $stmt->bindValue(":track_name", $new["track_name"] ?? $current["track_name"], PDO::PARAM_STR);
        $stmt->bindValue(":start_station", $new["start_station"] ?? $current["start_station"], PDO::PARAM_INT);
        $stmt->bindValue(":end_station", $new["end_station"] ?? $current["end_station"], PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();

    }

    public function Delete(string $track_id): int{//drops a track from the table, returns how many rows were affected

        $sql = "DELETE FROM `Track` WHERE track_id = :track_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":track_id", $track_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

}