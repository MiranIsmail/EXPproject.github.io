<!DOCTYPE html>
<html lang="en">

<head>
  <title>Confirmation - Rasts</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="../images/s_black.svg">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css">
  <link rel="stylesheet" href="../styles/login_style.css">
  <link rel="stylesheet" href="../styles/SignUp_LogIn_style.css">
  <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</head>
<body>
</head>
<body>
<div class="container">
  <h1 class="mx-auto" style="text-align: center; padding-top: 20rem;">Event created successfully!</h1>
  <p class="mx-auto" style="text-align: center;">You will be redirected in <span id="countdown">3</span> seconds.</p>
</div>
</body>
</html>

<script>
    window.onload = function() {
      var count = 3;
      var countdown = setInterval(function() {
        document.getElementById("countdown").innerHTML = count;
        count--;
        if (count < 0) {
          clearInterval(countdown);
          window.location.href = "event.php"; // Change this URL to the desired redirect URL
        }
      }, 1000);
    }
  </script>
