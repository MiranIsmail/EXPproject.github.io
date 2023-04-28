<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>

  <div class="mx-auto">
    <h1 id="event_title">Event:</h1>
    <h2 id="track_title">Track:</h2>
    <h2 id="date">Date:</h2>
    <table style="border-color: black;" class="table table-bordered" id="timetable">
      <thead>
        <tr>
          <th scope="col">Station Name:</th>
          <th scope="col">Time:</th>
          <th scope="col">Start Time:</th>
          <th scope="col">End Time:</th>
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
  <script src="../scripts/js_scripts.js"></script>
  <script>timetable_link_func()</script>
</body>
