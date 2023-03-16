<?php
#this gets data and retursn data
class AccountGateway extends Gateway
{

    public function create_account(array $data)
    {
        # code...
    }
    public function edit_account(array $data)
    {
        $sql = "UPDATE Users SET password = '$data[password]' WHERE email = '$data[email]'";
        $stmt = $this->conn->query($sql);
    }
}
