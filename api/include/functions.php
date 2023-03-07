<?php


function query($query) {
  global $_link;
  if ($result = mysqli_query($_link, $query)) {
    return $result;
  }
  elseif (DEBUG_STATUS) {
    ob_start();
    debug_print_backtrace();
    $trace = ob_get_contents();
    ob_end_clean();
    $data = [
      'status_code' => 400,
      'backtrace' => $trace,
      'error' => mysqli_error($_link),
      'query' => $query,
    ];
    api_response($data);
  }
  else {
    $data = [
      'status_code' => 400,
    ];
    api_response($data);
  }
}


function my_filter($value, $type = 'post') {
  global $_link;
  $value = trim($value);
  if ($type == 'endpoint') {
    $search = ['.', '-'];
    $replace = ['', '_'];
    $value = str_replace($search, $replace, $value);
  }
  if ($type == 'post') {
    $value = htmlspecialchars($value);
  }
  //return mysqli_real_escape_string($_link, $value);
  return $value;
}


function authorize() {
  return 0;
}


function api_response(array $data = []) {
  if (empty($data['status_code'])) {
    $data = [
      'status_code' => 404,
      'status_message' => 'Not Found',
    ];
  }
  header_status($data['status_code']);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}


function header_status($status_code) {
  static $status_codes = NULL;

  if ($status_codes === NULL) {
    $status_codes = [
      100 => 'Continue',
      101 => 'Switching Protocols',
      102 => 'Processing',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      207 => 'Multi-Status',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      307 => 'Temporary Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Timeout',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested Range Not Satisfiable',
      417 => 'Expectation Failed',
      418 => 'Im a teapot',
      422 => 'Unprocessable Entity',
      423 => 'Locked',
      424 => 'Failed Dependency',
      425 => 'Too Early',
      426 => 'Upgrade Required',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      505 => 'HTTP Version Not Supported',
      506 => 'Variant Also Negotiates',
      507 => 'Insufficient Storage',
      509 => 'Bandwidth Limit Exceeded',
      510 => 'Not Extended',
    ];
  }

  if (!empty($status_codes[$status_code])) {
    $status_string = $status_code . ' ' . $status_codes[$status_code];
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, TRUE, $status_code);
    // om vi vill testa header($_SERVER['SERVER_PROTOCOL'], TRUE, 200);
  }
}
