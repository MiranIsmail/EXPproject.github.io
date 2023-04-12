<!DOCTYPE html>
<html lang="en">

<head>
  <title>Homepage - Rasts</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Swimrun, Endurance, Challenge, Triathlon, Trail running, Open water swimming, Adventure, Racing, Fitness, Competition, Multisport, Athletic, Stamina, Intensity, Training, Performance, Running, Swimming, Outdoors, Nature, Extreme, Tough, Grit, Strength, Teamwork, Navigation, Fast-paced, Exciting, Ambitious, Adventure racing, Pushing limits, Athlete, Intense, Stamina building, Cardio, Mental toughness, Endurance sports, Water sports, Extreme sports, Trail racing, Open water, Ocean swimming, Swim training, Run training, Performance training, Challenging, Personal achievement, Fun, Motivation, Persistence,Competition, Timing, Sports events, Finish line, Results, Athletes, Race, Stopwatch, Clock, Podium, Medals, Champion, Records, Split times, Personal best, Spectators, Fans, Official, Timing system, Start line, Finisher, Winning, Losing, Scoreboard, Trophy, Prize money, Ranking, Registration, Warm-up, Cool down, Award ceremony, National team, International competition, Track and field, Speed, Endurance, Training plan, Performance analysis, Personal record, Event management, Participant, Timing accuracy, Event planning, Race course, Event marketing, Sports technology, Timing equipment, Photo finish, Judging, Race day, Starting gun, Finish chute">
  <meta name="description" content="Swimrunn Timing and competition">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css">
  <link rel="stylesheet" href="../styles/login_style.css">
  <link rel="stylesheet" href="../styles/SignUp_LogIn_style.css">
  <script src="../scripts/js_scripts.js"></script>
  <script src="../scripts/index_load.js"></script>
</head>

<body>
  <?php include '../assets/navbar.php'; ?>
  <!--run bar-->
  <img class="mx-auto d-block bg-logo" alt="Logo" src="../images/RASTS.svg" id="logo">
  <div>
    <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="running figures" id="image_run">
    <div style="padding-bottom: 2rem;" id="searchFade">
      <div class="wrapper drop_shadow">
        <div class="searchBar">
          <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search" value="" onkeyup="search_event()">
          <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>


  <!--Temporary events-->
  <div class="events section w-100" style="padding-bottom: 4rem;">
    <div id="event_cards_dynamic"></div>
  </div>

  <!--Footer-->
  <!--<div include-html='../assets/footer.html'></div>-->
  <?php include '../assets/footer.php'; ?>
</body>
<script>
  data_load_index()
</script>

</html>