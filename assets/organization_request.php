<?php
if (empty($_GET)) {
    header('Location: ' . "https://www.rasts.se/");
}
$msg = "Organisation name: " . $_GET["org_name"] . "\n Adress: " . $_GET["address"] . "\n email: " . $_GET["org_email"] . "\n Organisation number: " . $_GET["org_number"] . "\n Contact email: " . $_GET["contact_email"] . "\n Contact number" . $_GET["number"];

"First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);

// send email
// org nummber

mail($_GET["contact_email"], $_GET["org_name"] . "wants a account", $msg);
header('Location: ' . "https://www.rasts.se/");
