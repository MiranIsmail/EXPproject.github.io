<?php
if (empty($_GET)) {
  header('Location: ' . "https://www.rasts.se/");
}
var_dump($user_data);
$msg_rast = "Organization name: " . $_GET["org_name"] . "\n Adress: " . $_GET["address"] . "\n email: " . $_GET["org_email"] . "\n Organization number: " . $_GET["org_number"] . "\n Contact email: " . $_GET["contact_email"] . "\n Contact number" . $_GET["number"] . "\n $_GET[org_name], $_GET[address], $_GET[org_email], $_GET[org_number], $_GET[contact_email], $_GET[user_name], $_GET[number]]";

$msg = "Thank you for your request to register your organization. We will get back to you as soon as possible with more information on how to set up your organizational account. We will be in touch!";



mail("info@rasts.se", "Organization request", $msg_rast);
mail($_GET["contact_email"], "Organization request", $msg);
//header('Location: ' . "https://www.rasts.se/");
