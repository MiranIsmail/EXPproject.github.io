<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>

  <script>
    class dummydata {
      constructor(starttime, endtime, totaltime, terrain, distance, velocity) {
        this.starttime = starttime
        this.endtime = endtime
        this.totaltime = totaltime
        this.terrain = terrain
        this.distance = distance
        this.velocity = velocity
      };
    };
    var check1 = new dummydata(1, 2, 2, "land", 45, 300);
    var check2 = new dummydata(1, 2, 2, "land", 45, 300);
    var check3 = new dummydata(1, 2, 2, "land", 45, 300);
    var data = [check1, check2, check3];
  </script>


  <div class="mb-3 mx-auto w-50">
    <h1>Timetable</h1>
    <table style="border-color: black;" class="table table-bordered" id="timetable">
      <thead>
        <tr>
          <th scope="col">Checkpoint</th>
          <th scope="col">Starttime</th>
          <th scope="col">Endtime</th>
          <th scope="col">Total time</th>
          <th scope="col">Terrain</th>
          <th scope="col">Distance</th>
          <th scope="col">Velocity</th>

        </tr>
      </thead>
      <tbody>
        <script>
          for (let i = 0; i < data.length; i++) {
            let row = timetable.insertRow(i + 1)
            let cell1 = row.insertCell(0)
            let cell2 = row.insertCell(1)
            let cell3 = row.insertCell(2)
            let cell4 = row.insertCell(3)
            let cell5 = row.insertCell(4)
            let cell6 = row.insertCell(5)
            let cell7 = row.insertCell(6)
            if (i == 0) {
              cell1.innerHTML = "Start"
            } else if (i == data.length - 1) {
              cell1.innerHTML = "Finish"
            } else {
              cell1.innerHTML = i
            }
            cell2.innerHTML = data[i].starttime
            cell3.innerHTML = data[i].endtime
            cell4.innerHTML = data[i].totaltime
            cell5.innerHTML = data[i].terrain
            cell6.innerHTML = data[i].distance
            cell7.innerHTML = data[i].velocity
          }
        </script>
      </tbody>
    </table>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script type="text/javascript" src="../scripts/timetable.js"></script>

</body>