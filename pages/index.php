<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>
  <!--run bar-->
  <img class="mx-auto d-block bg-logo" alt="Logo" src="../images/RASTS.svg" id="logo">
  <div>
    <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="Running figures" id="image_run">
    <div style="padding-bottom: 2rem;" id="searchFade" class="mx-auto">
      <h1 id="underline_text">Popular events</h1>
    </div>
  </div>


  <!--Temporary events-->
  <div class="events section w-100" style="padding-bottom: 4rem;">
    <div id="event_cards_dynamic"></div>
  </div>

  <!--Footer-->
  <!--<div include-html='../assets/footer.html'></div>-->
  <?php include '../assets/footer.php'; ?>
  <script src="../scripts/js_scripts.js"></script>
  <script src="../scripts/index_load.js"></script>
</body>
<script>
  data_load_index_topten()
</script>

</html>