<?php

function authorization(PDO $conn,string $auth_token):bool
{
    $sql = "SELECT * FROM  Users WHERE auth_token LIKE :auth_token";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(":auth_token", $auth_token, PDO::PARAM_STR);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (! $data){
        return false;
    }


    return true;
}