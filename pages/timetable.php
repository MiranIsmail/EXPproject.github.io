<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>
  <div class="padding_all" style="text-align:center; padding-top:3rem;">
      <h1 id="event_title">Event:</h1>
      <h2 id="track_title">Track:</h2>
      <h2 id="date">Date:</h2>
    </div>
  <div>
    <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="Running figures" id="image_run">
  <div class="mx-auto">
    <table class="table table-bordered result_table" id="timetable" style="margin-bottom:0px;">
      <thead>
        <tr>
          <th scope="col">Station:</th>
          <th scope="col">Time:</th>
          <th scope="col">Terrain:</th>
          <th scope="col">Distance:</th>
          <th scope="col">Avg. Velocity:</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script src="../scripts/endpoint_functions.js"></script>
  <script src="../scripts/js_scripts.js"></script>
  <script>timetable_link_func()</script>
</body>
