<?php
if (empty($_GET)) {
    header('Location: ' . "https://www.rasts.se/");
}
function is_logged_in(): bool
{
  if (!isset($_COOKIE["auth_token"])) {
    return false;
  }
  $url = 'https://rasts.se/api/Token';
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(

      "Authorization: $_COOKIE[auth_token]",
    ),
    CURLOPT_RETURNTRANSFER => true,
  ));

  curl_exec($curl);
  $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);


  if ($status_code == 200) {
    return true;
  } else {
    return false;
  }
}
$msg_rast = "Organization name: " . $_GET["org_name"] . "\n Adress: " . $_GET["address"] . "\n email: " . $_GET["org_email"] . "\n Organization number: " . $_GET["org_number"] . "\n Contact email: " . $_GET["contact_email"] . "\n Contact number" . $_GET["number"] . "\n $_GET[org_name], $_GET[address], $_GET[org_email], $_GET[org_number]";

$msg = "Thank you for your request to register your organization. We will get back to you as soon as possible with more information on how to set up your organizational account. We will be in touch!";



mail("info@rasts.se", "Organization request", $msg_rast);
mail($_GET["contact_email"], "Organization request", $msg);
header('Location: ' . "https://www.rasts.se/");
