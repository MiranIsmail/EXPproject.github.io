<?php
if (empty($_GET)) {
  header('Location: ' . "https://www.rasts.se/");
}
$msg_rast = "Organization name: " . $_GET["org_name"] . "\n Adress: " . $_GET["address"] . "\n email: " . $_GET["org_email"] . "\n Organization number: " . $_GET["org_number"] . "\n Contact email: " . $_GET["contact_email"] . "\n Contact number" . $_GET["number"] . "\n $_GET[org_name], $_GET[address], $_GET[org_email], $_GET[org_number], $_GET[contact_email], $_GET[user_name]";


$subject = "Organization request";
$body = "Hello,\n\nThank you for your request to register your organization. We will get back to you as soon as possible with more information on how to set up your organizational account. We will be in touch!\n\nThanks,\n info@rasts.se";
$headers = "From: Rasts <info@rasts.se>\r\n" .
  "Reply-To: info@rasts.se\r\n" .
  "X-Mailer: PHP/" . phpversion();

mail("info@rasts.se", "Organization request", $msg_rast, $headers);
mail($_GET["contact_email"], $subject, $body, $headers);
header('Location: ' . "https://www.rasts.se/");
