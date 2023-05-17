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
    <div>

      <label for="speed">Choose speed unit:</label>
      <select name="s_unit" id="s_unit">
      <option value="ms">m/s</option>
      <option value="kmh">km/h</option>
      <option value="mph">mph</option>
      <option value="kn">knots</option>
      <option value="kpm">kpm</option>
      </select>

      <label for="dist">Choose distance measurement unit:</label>
      <select name="d_unit" id="d_unit">
      <option value="m">m</option>
      <option value="km">km</option>
      <option value="miles">miles</option>
      <option value="naut_miles">nautical miles</option>
      </select>

      <button onclick=user_prefs_update()>Update</button>
    </div>
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
    <script>
      function user_prefs_update(){
        let s_unit = document.getElementById('s_unit').value
        let d_unit = document.getElementById('d_unit').value
        var table = document.getElementById('timetable')
        var rows_len = table.rows.length
        var row_cells = table.rows
        for(i = rows_len-1; i > 0; i--){
            table.deleteRow(i)
        }
        timetable_link_func(s_unit, d_unit)
      }
    </script>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script src="../scripts/endpoint_functions.js"></script>
  <script src="../scripts/js_scripts.js"></script>
  <script>timetable_link_func()</script>
</body>
