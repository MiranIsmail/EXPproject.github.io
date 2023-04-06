<?php
#this gets data and retursn data
class AccountGateway extends Gateway
{
    public function get_account_data_by_id(?string $id)
    {
    }

    public function get_account_data(String $auth_token)
    {
        if (!parent::verify_token($auth_token)) {
            return false;
        }
        $sql = "SELECT first_name, last_name, height, weight, birthdate, pimage FROM `Users` WHERE token LIKE :auth_token";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":auth_token", $auth_token, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn(1, $first_name);
        $stmt->bindColumn(2, $last_name);
        $stmt->bindColumn(3, $height, PDO::PARAM_INT);
        $stmt->bindColumn(4, $weight);
        $stmt->bindColumn(5, $birthdate, PDO::PARAM_INT);
        $stmt->bindColumn(6, $pimage, PDO::PARAM_LOB);


        $stmt->fetch(PDO::FETCH_BOUND);

        if (!$first_name) {
            return false;
        }


        return ["first_name" => $first_name, "last_name" => $last_name, "height" => $height, "weight" => $weight, "birthdate" => $birthdate, "pimage" => $pimage];
    }


    public function create_account(string $email, string $first_name, string $last_name, string $password, array $additional_parameters)
    {
        $value_name = "";
        $column_name = "";
        if ($additional_parameters) {
            $column_name = ", `" . implode("`, `", array_keys($additional_parameters)) . "`";
            $value_name = ", :" . implode(", :", array_keys($additional_parameters));
        }
        $sql = "INSERT INTO `Users` (`email`, `token`, `first_name`, `last_name`$column_name, `password`) VALUES (:email, :token, :first_name, :last_name$value_name, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindValue(":token", parent::create_token(), PDO::PARAM_STR);
        $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
        $stmt->bindValue(":last_name", $last_name, PDO::PARAM_STR);


        foreach ($additional_parameters as $key => $value) {
            switch ($key) {
                case "height":
                    $stmt->bindValue(":" . $key, $value, PDO::PARAM_INT);
                    break;
                default:
                    $stmt->bindValue(":" . $key, strval($value), PDO::PARAM_STR);
            }
        }
        $stmt->execute();
    }


    public function edit_account_info(array $data, String $auth_token)
    {

        if (!parent::verify_token($auth_token)) {
            return false;
        }
        $set_string = '';
        foreach ($data as $key => $value) {
            $set_string .= "`$key`=:$key, ";
        }
        $set_string = substr($set_string, 0, -2);



        $sql = "UPDATE Users SET $set_string WHERE token LIKE :auth_token";

        $stmt = $this->conn->query($sql);

        $stmt->bindValue(":auth_token", $auth_token, PDO::PARAM_STR);

        foreach ($data as $key => $value) {
            switch ($key) {
                case "height":
                    $stmt->bindValue(":" . $key, $value, PDO::PARAM_INT);
                    break;
                case "pimage":
                    $stmt->bindValue(":" . $key, $value, PDO::PARAM_LOB);
                default:
                    $stmt->bindValue(":" . $key, strval($value), PDO::PARAM_STR);
            }
        }
        $stmt->execute();
    }
    public function edit_account_password(array $data)
    {
    }
}
