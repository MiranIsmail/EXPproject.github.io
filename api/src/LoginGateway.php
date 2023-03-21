<?php
#this gets data and return data
class LoginGateway extends Gateway
{

    public function get_auth_token($email, $password): string | false
    {
        $sql = "SELECT token,password FROM  Users WHERE email LIKE :email ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }
        if (!password_verify($password, $data["password"])) {
            return false;
        }
        if (parent::verify_token($data["token"])){
            return $data["token"];
        }

        $sql = "UPDATE `Users` SET `token` = :token, `token_date` = CURRENT_TIMESTAMP WHERE `email` = :email";
        $stmt = $this->conn->prepare($sql);
        $token = parent::create_token($email, $password);

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":token", $token, PDO::PARAM_STR);
        $stmt->execute();


        return $token;
    }
}
