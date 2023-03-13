<?php
#this gets data and returns data
class AccountGateway
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
    public function edit_account(array $data) 
    {
        $sql = "UPDATE Users 
                SET password = $data[1] 
                WHERE mail = $data[0]";

        $stmt = $this->conn->query($sql)
    }
}
