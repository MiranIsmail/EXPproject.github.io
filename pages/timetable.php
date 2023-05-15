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
        //if appended without the other things being appended like result_id and event_id the url will not work
        //because of the lack of a ?name=name
        let s_unit = document.getElementById('s_unit').value
        let d_unit = document.getElementById('d_unit').value
        var url = window.location.href
        new_url = url
        const urlParams = new URLSearchParams(window.location.search);
        su = urlParams.get("su");
        du = urlParams.get("du");
        if(su == null){
          new_url += '&' + 'su=' + s_unit
        }
        if(su != null && su.value != s_unit)
        {
          new_url = new_url.replace('su=' + su, 'su=' + s_unit)
        }
        if(du == null){
        new_url += '&' + 'du=' + d_unit
        }
        if(du != null && du.value != d_unit)
        {
          new_url = new_url.replace('du=' + du, 'du=' + d_unit)
        }
        window.location.href = new_url
        timetable_link_func()
      }
    </script>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script src="../scripts/endpoint_functions.js"></script>
  <script src="../scripts/js_scripts.js"></script>
  <script>timetable_link_func()</script>
</body>
