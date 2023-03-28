<?php

declare(strict_types=1);


require __DIR__ . "/src/functions.php";
spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

require __DIR__ . "/include/settings.php";

set_error_handler("ErrorHandler::handle_error");
set_exception_handler("ErrorHandler::handle_exception");

header("Content-type: application/json; charset:UTF-8");
header("Access-Control-Allow-Origin: *");


//header("Access-Control-Allow-Origin : *");
//header("Access-Control-Allow-Credentials : true");

if (array_key_exists("Authorization",apache_request_headers())){
    define('AUTH_TOKEN', apache_request_headers()["Authorization"]);
}

$parts = explode("/", $_SERVER['REDIRECT_URL']);
$endpoints = glob(__DIR__ . '/src/*');
$check_file_exists = in_array(__DIR__ . "/src/$parts[2]" . "Controller.php", $endpoints);

if (!$check_file_exists) {
    http_response_code(404);
    exit;
}



$database = new Database($host, $db, $login, $passwd);

$conn = $database->get_connection();



$ClassController = "$parts[2]" . "Controller";
$ClassGateway = "$parts[2]" . "Gateway";

$gateway = new $ClassGateway($conn);
$controller = new $ClassController($gateway);

$controller->process_request($_SERVER['REQUEST_METHOD']);
exit;