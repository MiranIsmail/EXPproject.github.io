<?php
#this gets data and retursn data
class LoginGateway extends Gateway
{

    public function get_auth_token($email, $password): string | false
    {
        $sql = "SELECT token FROM  Users WHERE email LIKE :email AND `password` LIKE  :password";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (! $data){
            return false;
        }

 
        return $data['token'];
    }
}
