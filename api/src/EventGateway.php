<?php
class EventGateway extends Gateway
{
    public function create_event(string $name, string $track_id, string $startdate, string $enddate, string $host_email, string $eimage, string $open_for_entry, string $public_view, string $description)
    {
        $sql = "INSERT INTO Competition (event_name, track_id, startdate, enddate, open_for_entry, public_view, host_email, eimage, description)
                VALUES (:event_name, :track_id, :startdate, :enddate, :open_for_entry, :public_view, :host_email, :eimage, :description)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":event_name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":startdate", $startdate, PDO::PARAM_STR);
        $stmt->bindValue(":enddate", $enddate, PDO::PARAM_STR);
        $stmt->bindValue(":track_id", $track_id, PDO::PARAM_INT);
        $stmt->bindValue(":open_for_entry", $open_for_entry, PDO::PARAM_INT);
        $stmt->bindValue(":public_view", $public_view, PDO::PARAM_INT);
        $stmt->bindValue(":host_email", $host_email, PDO::PARAM_STR);
        $stmt->bindValue(":eimage", $eimage, PDO::PARAM_LOB);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);


        $stmt->execute();
    }

    public function get_user_events(string $participant1)
    {
        $sql = "SELECT distinct event_id FROM Result WHERE participant1 = :participant1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
        $stmt->execute();
        $event_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($event_ids)) {
            $sql = "SELECT distinct event_id FROM Result WHERE participant2 = :participant1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":participant1", $participant1, PDO::PARAM_STR);
            $stmt->execute();
            $event_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        foreach ($event_ids as $event_id) {
            $sql = "SELECT * FROM Competition WHERE event_id = :event_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":event_id", $event_id["event_id"], PDO::PARAM_INT);
            $stmt->execute();
            $data[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function get_event($event_id)
    {
        $sql = "SELECT * FROM Competition where event_id = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->bindColumn("event_name", $event_name);
        $stmt->bindColumn("track_id", $track_id);
        $stmt->bindColumn("host_email", $host_email);
        $stmt->bindColumn("host_organization", $host_organization);
        $stmt->bindColumn("sport", $sport);
        $stmt->bindColumn("startdate", $startdate);
        $stmt->bindColumn("enddate", $enddate);
        $stmt->bindColumn("module_id", $module_id);
        $stmt->bindColumn("open_for_entry", $open_for_entry);
        $stmt->bindColumn("public_view", $public_view);
        $stmt->bindColumn("eimage", $eimage, PDO::PARAM_LOB);


        $stmt->fetch(PDO::FETCH_BOUND);
        
        if (!$track_id) {
            return false;
        }
        


        return [
            "event_name" => $event_name,
            "track_id" => $track_id,
            "host_email" => $host_email,
            "host_organization" => $host_organization,
            "sport" => $sport,
            "startdate" => $startdate,
            "enddate" => $enddate,
            "module_id" => $module_id,
            "open_for_entry" => $open_for_entry,
            "public_view" => $public_view,
            "eimage" => $eimage
        ];
    }

    public function get_all_events(): array
    {
        $sql = "SELECT * FROM Competition where public_view = 1";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_event(array $current, array $new)
    {
        $sql = "UPDATE Competition
                SET event_name = :event_name, track_id = :track_id, startdate = :startdate, enddate = :enddate, open_for_entry = :open_for_entry, public_view = :public_view, host_email = :host_email, eimage = :eimage, description = :description
                WHERE event_id = :event_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":event_name", $new["event_name"] ?? $current["event_name"], PDO::PARAM_STR);
        $stmt->bindValue(":track_id", $new["track_id"] ?? $current["track_id"], PDO::PARAM_INT);
        $stmt->bindValue(":startdate", $new["startdate"] ?? $current["startdate"], PDO::PARAM_STR);
        $stmt->bindValue(":enddate", $new["enddate"] ?? $current["enddate"], PDO::PARAM_STR);
        $stmt->bindValue(":open_for_entry", $new["open_for_entry"] ?? $current["open_for_entry"], PDO::PARAM_INT);
        $stmt->bindValue(":public_view", $new["public_view"] ?? $current["public_view"], PDO::PARAM_INT);
        $stmt->bindValue(":host_email", $new["host_email"] ?? $current["host_email"], PDO::PARAM_STR);
        $stmt->bindValue(":eimage", $new["eimage"] ?? $current["eimage"], PDO::PARAM_LOB);
        $stmt->bindValue(":description", $new["description"] ?? $current["description"], PDO::PARAM_STR);

        $stmt->bindValue(":event_id", $current["event_id"], PDO::PARAM_INT);

        $stmt->execute();
    }

    public function delete_event(string $event_id)
    {
        $sql = "DELETE FROM Competition WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function get_event_p($event_id)
    {
        $sql = "SELECT * FROM Competition where event_id = :event_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->bindColumn("event_name", $event_name);
        $stmt->bindColumn("track_id", $track_id);
        $stmt->bindColumn("host_email", $host_email);
        $stmt->bindColumn("startdate", $startdate);
        $stmt->bindColumn("enddate", $enddate);
        $stmt->bindColumn("open_for_entry", $open_for_entry);
        $stmt->bindColumn("public_view", $public_view);
        $stmt->bindColumn("eimage", $eimage, PDO::PARAM_LOB);
        $stmt->bindColumn("description", $description);


        $stmt->fetch(PDO::FETCH_BOUND);
        
        if (!$track_id) {
            return false;
        }
        


        return [
            "event_id" => $event_id,
            "event_name" => $event_name,
            "track_id" => $track_id,
            "host_email" => $host_email,
            "startdate" => $startdate,
            "enddate" => $enddate,
            "open_for_entry" => $open_for_entry,
            "public_view" => $public_view,
            "eimage" => $eimage,
            "description" => $description
        ];
    }
}
