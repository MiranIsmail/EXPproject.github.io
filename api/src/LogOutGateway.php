<?php
class MallGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    }
    public function create_account(array $data)
    {
        # code...
    }
}
