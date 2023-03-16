<?php

declare(strict_types=1);


require __DIR__ . "/scr/functions.php";
spl_autoload_register(function ($class) {
    require __DIR__ . "/scr/$class.php";
});

set_error_handler("ErrorHandler::handle_error");
set_exception_handler("ErrorHandler::handle_exception");

header("Content-type: application/json; charset:UTF-8");
header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Origin : *");
//header("Access-Control-Allow-Credentials : true");

#$auth_token = apache_request_headers()["Authorization"];

$parts = explode("/", $_SERVER['REDIRECT_URL']);
$endpoints = glob(__DIR__ . '/scr/*');
$check_file_exists = in_array(__DIR__ . "/scr/$parts[2]" . "Controller.php", $endpoints);

if (!$check_file_exists) {
    http_response_code(404);
    exit;
}



$database = new Database("localhost", "lommdjkz_testdata", "lommdjkz", "PL18E*xtDf)0d7");

$conn = $database->get_connection();



$ClassController = "$parts[2]" . "Controller";
$ClassGateway = "$parts[2]" . "Gateway";

$gateway = new $ClassGateway($conn);
$controller = new $ClassController($gateway);

$controller->process_request($_SERVER['REQUEST_METHOD']);
