<!DOCTYPE html>
<html lang="en">

<head>
  <title>EXP Initiative</title>
  <meta charset="utf-8" />
  <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css" />
  <link rel="stylesheet" href="../styles/login_style.css" />
  <link rel="stylesheet" href="../styles/SignUp_LogIn_style.css" />
  <script type="text/javascript" src="../scripts/js_scripts.js"></script>
  <script type="text/javascript" src="../scripts/event_page_load.js"></script>
</head>

<body>
  <?php include '../assets/navbar.php'; ?>
    <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run">
    <div style="padding-bottom: 4rem;" id="searchFade"></div>




    
    <div class="events section w-100" style="padding-bottom: 4rem;">
      <div id="event_cards_dynamic"></div>
    </div>

    <?php include '../assets/footer.php'; ?>
</body>

<script>
  data_load_index()
</script>

</html>