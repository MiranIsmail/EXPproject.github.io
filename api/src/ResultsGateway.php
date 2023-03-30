<?php

class ResultsGateway extends Gateway
{
    public function add_result(string $chip_id, array $track_time, string $total_time)
    {
        $sql = "SELECT email1, email2 FROM Chip WHERE chip_id = :chip_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":chip_id", $chip_id, PDO::PARAM_STR);
        $stmt->execute();
        $participants = $stmt->fetch(PDO::FETCH_ASSOC);
        $participant1 = $participants["email1"];
        $participant2 = $participants["email2"];

        $sql = "SELECT event_id FROM Registration WHERE chip_id = :chip_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":chip_id", $chip_id, PDO::PARAM_STR);
        $stmt->execute();
        $event_id = $stmt->fetch(PDO::FETCH_ASSOC)["event_id"];


        // CREATE CHECK IF CHECKPOINT EXISTS
        $date_time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `Result` (`participant1`, `participant2`, `event_id`, `date_time`, `total_time`) VALUES (:participant1, :participant2, :event_id, :date_time, :total_time)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->bindValue(":participant2", $participant2, PDO::PARAM_STR);
        $stmt->bindValue(":date_time", $date_time, PDO::PARAM_STR);
        $stmt->bindValue(":total_time", $total_time, PDO::PARAM_STR);
        $stmt->execute();

        $sql = "SELECT Result_id FROM Result WHERE participant1 = :participant1 AND date_time = :date_time";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":date_time", $date_time, PDO::PARAM_STR);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->execute();
        $result_id = $stmt->fetch(PDO::FETCH_ASSOC);

        foreach($track_time as $checkpoint_time) {
            $station_name = $checkpoint_time[0];
            $time_stamp = $checkpoint_time[1];
            $diff_time_stamp = $checkpoint_time[2];
            $diff_sec = $checkpoint_time[3];
            $checkpointresult_id = $checkpoint_time[4];

            $sql = "INSERT INTO checkpoint_time (station_name, time_stamp, diff_time_stamp, diff_sec, result_id, checkpointresult_id) VALUES (:station_name, :time_stamp, :diff_time_stamp, :diff_sec, :result_id, :checkpointresult_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":station_name", $station_name, PDO::PARAM_STR);
            $stmt->bindValue(":time_stamp", $time_stamp, PDO::PARAM_STR);
            $stmt->bindValue(":diff_time_stamp", $diff_time_stamp, PDO::PARAM_STR);
            $stmt->bindValue(":diff_sec", $diff_sec, PDO::PARAM_STR);
            $stmt->bindValue(":result_id", $result_id["Result_id"], PDO::PARAM_STR);
            $stmt->bindValue(":checkpointresult_id", $checkpointresult_id, PDO::PARAM_STR);
            
            $stmt->execute();
        }
    }
        
    public function get_event_results(string $event_id)
    {
        $sql = "SELECT * FROM Result WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function delete_result(string $event_id, string $participant1, string $result_id) {
        $sql = "DELETE FROM `Result` WHERE `event_id` = :event_id AND `participant1` = :participant1 AND `result_id` = :result_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->bindValue(":result_id", $result_id, PDO::PARAM_STR);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->execute();

        $sql = "DELETE FROM `checkpoint_time` WHERE `result_id` = :result_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":result_id", $result_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get_user_results(string $participant1, string $event_id)
    {
        $sql = "SELECT Result_id FROM Result WHERE participant1 = :participant1 AND event_id = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->execute();
        $result_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($result_id)) {
            $sql = "SELECT Result_id FROM Result WHERE participant2 = :participant1 AND event_id = :event_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
            $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
            $stmt->execute();
            $result_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        foreach($result_id as $result) {
            $sql = "SELECT * from checkpoint_time WHERE result_id = :result_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":result_id", $result["Result_id"], PDO::PARAM_STR);
            $stmt->execute();
            $checkpoint_time[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $checkpoint_time;
}
}