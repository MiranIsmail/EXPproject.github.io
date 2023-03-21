<?php
class Gateway
{
    protected PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }
    public function create_token(?string $email = null, ?string $password = null): string
    {
        if (!($email and $password)) {

            $random_string = bin2hex(random_bytes(16) . mt_rand());
        } else {
            $random_string = bin2hex(random_bytes(16)) . SALT . $email . $password . microtime();
        }
        return hash("sha256", $random_string);
    }
    public function verify_token(string $token):bool
    {
        $sql = "SELECT * FROM `Users` WHERE token LIKE :token and date_add(`token_date`,INTERVAL :token_life Hour) >CURRENT_TIMESTAMP";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":token", $token, PDO::PARAM_STR);
        $stmt->bindValue(":token_life", TOKEN_LIFE, PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (! $data){
            return false;
        }
        return true;
    }
}
