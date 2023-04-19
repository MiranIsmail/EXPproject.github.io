<?php
var_dump($_POST);
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);

// send email

mail($_GET["contact_email"], "teste", $msg);
header('Location: ' . "https://www.rasts.se/");
