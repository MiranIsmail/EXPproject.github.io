<?php
#this gets data and retursn data
class AccountGateway extends Gateway
{

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
                case "age" or "height":
                    $stmt->bindValue(":" . $key, $value, PDO::PARAM_INT);
                    break;
                default:
                    $stmt->bindValue(":" . $key, strval($value), PDO::PARAM_STR);
            }
        }
        $stmt->execute();
    }
    public function edit_account(array $data)
    {
        $sql = "UPDATE Users SET password = '$data[password]' WHERE email = '$data[email]'";
        $stmt = $this->conn->query($sql);
    }
}
