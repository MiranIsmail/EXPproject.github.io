<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/scr/$class.php";
});

set_error_handler("ErrorHandler::handle_error");
set_exception_handler("ErrorHandler::handle_exception");

header("Content-type: application/json; charset:UTF-8");


$parts = explode("/", $_SERVER['REDIRECT_URL']);
$endpoints = glob(__DIR__ . '/scr/*');

#var_dump(in_array(__DIR__."/scr/$parts[1]"."Controller.php",$endpoints));

$database = new Database("localhost", "systemteknik", "root", "Faiz1234");

$ClassController = "$parts[1]"."Controller";
$ClassGateway= "$parts[1]"."Gateway";


$gateway = new $ClassGateway($database);
$controller = new $ClassController($gateway);




$controller->process_request($_SERVER['REQUEST_METHOD']);

