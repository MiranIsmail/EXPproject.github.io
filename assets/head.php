<?php
include '../functions.php';

$page_name_tile = ["resource" => "Resources", "index" => "Rasts", "" => "Rasts", "event_display" => "Rasts - Event", "event" => "Rasts - Events", "profile" => "Profile", "Login" => "Login", "SignUp" => "Register", "eventcreate" => "Create Event", "track" => "Track", "terms_of_service" => "terms of service", "privacy_policy" => "privacy policy"];

$blocked_site_logged_out = ["profile", "eventcreate", "track"];
$blocked_site_logged_in = ["Login", "SignUp"];
$blocked_site_logged_in_user = ["track"];
$tmp = explode("?", $_SERVER['REQUEST_URI'])[0];
$title = $page_name_tile[explode(".", explode("/", $tmp)[2])[0]];

$is_logged_in_user = is_logged_in();
$is_logged_in_org = is_logged_in("Organization");
$is_logged_in = $is_logged_in_user || $is_logged_in_org;
if ($is_logged_in_user) {
  $user_data = get_user_info();
  $user_type = "Users";
  $username = $user_data->username;
}
if ($is_logged_in_org) {
  $org_data = get_org_info();
  $user_type = "Organization";
  $username = $org_data->username;
}


if ($is_logged_in) {

  if (in_array(explode(".", explode("/", $_SERVER['REQUEST_URI'])[2])[0], $blocked_site_logged_in)) {
    header("Location: ../pages/index.php");
  }
  if (!$is_logged_in_org) {
    if (in_array(explode(".", explode("/", $_SERVER['REQUEST_URI'])[2])[0], $blocked_site_logged_in_user)) {
      header("Location: ../pages/index.php");
    }
  }

  if (in_array(explode(".", explode("/", $_SERVER['REQUEST_URI'])[2])[0], $blocked_site_logged_in)) {
    header("Location: ../pages/index.php");
  }
} else {
  if (in_array(explode(".", explode("/", $_SERVER['REQUEST_URI'])[2])[0], $blocked_site_logged_out)) {
    header("Location: ../pages/index.php");
  }
}
if (isset($user_type)) {
  if (isset($_COOKIE["user_type"])) {
    unset($_COOKIE["user_type"]);
    setcookie("user_type", null, -1, '/');
  }
  setcookie("user_type", $user_type, time() + 3600, "/");
}
if (isset($username)) {
  if (isset($_COOKIE["username"])) {
    unset($_COOKIE["username"]);
    setcookie("username", null, -1, '/');
  }
  setcookie("username", $username, time() + 3600, "/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title ?></title>
  <meta charset="utf-8">
  <!--<link rel="icon" type="image/x-icon" href="../images/s_black.svg">-->
  <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Swimrun, Endurance, Challenge, Triathlon, Trail running, Open water swimming, Adventure, Racing, Fitness, Competition, Multisport, Athletic, Stamina, Intensity, Training, Performance, Running, Swimming, Outdoors, Nature, Extreme, Tough, Grit, Strength, Teamwork, Navigation, Fast-paced, Exciting, Ambitious, Adventure racing, Pushing limits, Athlete, Intense, Stamina building, Cardio, Mental toughness, Endurance sports, Water sports, Extreme sports, Trail racing, Open water, Ocean swimming, Swim training, Run training, Performance training, Challenging, Personal achievement, Fun, Motivation, Persistence,Competition, Timing, Sports events, Finish line, Results, Athletes, Race, Stopwatch, Clock, Podium, Medals, Champion, Records, Split times, Personal best, Spectators, Fans, Official, Timing system, Start line, Finisher, Winning, Losing, Scoreboard, Trophy, Prize money, Ranking, Registration, Warm-up, Cool down, Award ceremony, National team, International competition, Track and field, Speed, Endurance, Training plan, Performance analysis, Personal record, Event management, Participant, Timing accuracy, Event planning, Race course, Event marketing, Sports technology, Timing equipment, Photo finish, Judging, Race day, Starting gun, Finish chute">
  <meta name="description" content="Swimrunn Timing and competition">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css">
  <link rel="stylesheet" href="../styles/login_and_signup.css">
  <link rel="stylesheet" href="../styles/event_display_style.css">
  <link rel="stylesheet" href="../styles/google_maps_api.css">
  <script src="https://kit.fontawesome.com/dbe6ff92a1.js" crossorigin="anonymous"></script>
</head>