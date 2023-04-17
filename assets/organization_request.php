<?php
var_dump($_POST);
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);

// send email
mail("aminafzali0209@gmail.com", $_POST["contact_email"], $msg);
//header('Location: ' . "https://www.rasts.se/");
