<?php
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
function get_user_info():stdClass
{
  if (!isset($_COOKIE["auth_token"])) {
    return false;
  }
  $url = 'https://rasts.se/api/Account';
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(

      "Authorization: $_COOKIE[auth_token]",
    ),
    CURLOPT_RETURNTRANSFER => true,
  ));

  $response = json_decode(curl_exec($curl));
  curl_close($curl);
  return $response;
}

function get_organization_info(string $organization_name):stdClass
{
  $url = 'https://rasts.se/api/Organization/'.$organization_name;
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_RETURNTRANSFER => true,
  ));

  $response = json_decode(curl_exec($curl));
  curl_close($curl);
  return $response;
}