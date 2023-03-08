<?php


class AccountGateay
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->$conn = $database->get_connection();
    }
}
