<?php
class EventGateway extends Gateway
{
    public function create_event(array $data): string
    {
        $sql = "INSERT INTO event (name, discription, start_time, end_time)
                VALUES (:name, :discription, :start_time, :end_time)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":discription", $data["discription"], PDO::PARAM_STR);
        $stmt->bindValue(":start_time", $data["start_time"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":end_time", $data["end_time"] ?? 0, PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }
}
