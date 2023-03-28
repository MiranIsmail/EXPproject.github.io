<?php
class ResultsGateway extends Gateway
{
    public function add_result(string $event_id, string $track_time, string $participant1, string $participant2, string $result)
    {
        // if (count($participants) == 2) {
        // $participant2 = $participants[1];
        $sql = "INSERT INTO `Result` (`track_time`, `participant1`, `participant2`, `event_id`) VALUES (:track_time, :participant1, :participant2, :event_id)";
        $stmt = $this->conn->prepare($sql);
        // }
        // else {
        //     $sql = "INSERT INTO `Result` (`track_time`, `participant1`, `event_id`) VALUES (:track_time, :participant1, :event_id)";
        // }
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->bindValue(":track_time", $track_time, PDO::PARAM_STR);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->bindValue(":participant2", $participant2, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function get_event_results(string $event_id)
    {
        $sql = "SELECT * FROM ´Result´ WHERE ´event_id´ = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete_result(string $event_id, string $participant1) {
        $sql = "DELETE FROM `Result` WHERE `event_id` = :event_id AND `participant1` = :participant1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get_user_results(string $participant1)
    {
        $sql = "SELECT * FROM `Result` WHERE `participant1` = :participant1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}