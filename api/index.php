<?php



include 'include/setup.php';

if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
  $request_array = explode('/', $_SERVER['REDIRECT_QUERY_STRING']);
  if (is_array($request_array)) {
    $request_array = array_map('my_filter', $request_array, array_pad([], count($request_array), 'endpoint'));
  }
}


if (empty($request_array[0])) {

  api_response();
}
$endpoint_name = $request_array[0];

if (is_array($_POST)) {
  $_POST = array_map('my_filter', $_POST);
}

$endpoint = __DIR__ . '/endpoints/' . $endpoint_name . '.php';
$endpoints = glob(__DIR__ . '/endpoints/*.php');
$_user_id = FALSE;
if (in_array($endpoint, $endpoints)) {
  $_user_id = authorize();
}
else {
  $endpoint = __DIR__ . '/public_endpoints/' . $endpoint_name . '.php';
  $endpoints = glob(__DIR__ . '/public_endpoints/*.php');
}

if (file_exists($endpoint) && in_array($endpoint, $endpoints)) {
  include $endpoint;
}
api_response();
