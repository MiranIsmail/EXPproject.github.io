<?php
class EventGateway extends Gateway
{
    public function create_event(array $data)
    {

        /*$sql = "INSERT INTO Competition(event_name, track_id, host_email, host_organisation, start_date, end_date, module_id, open_for_entry, public_view)
        VALUES ('$data["event_name"]', '$data["track_id"]', '$data["host_email"]', '$data["start_date"]', '$data["end_date]', '$data["module_id"]', '$data["open_for_entry"]', '$data["public_view"]')" */
    }
    public function get_event(array $data)
    {

        $url = 'https://lm577pnuni.execute-api.eu-north-1.amazonaws.com/prod/events/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        $new_events = array();
        foreach ($response as $event) {
            if ($event['Organizer'] != 'Amin') {
                continue;
            }
            $new_events[] = $event;
        }

        return $new_events;
    }
}
