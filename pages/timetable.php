<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>

  <script>

    class checkpoint {
      constructor(station_name, time_stamp, diff_time_stamp, diff_sec,
      checkpoint_result_id, result_id){
        this.station_name = station_name
        this.time_stamp = time_stamp 
        this.diff_time_stamp = diff_time_stamp
        this.diff_sec = diff_sec
        this.checkpoint_result_id = checkpoint_result_id
        this.result_id = result_id
        }
      };
    
    async function GetChecks(result_id){
      response = await fetch("https://rasts.se/api/Results/" + result_id, {method:'GET',
      headers: {'Accept': 'Application/json'}})
      data = await response.json();
      checkpts_obj = []
      for(let i = 0; i < data.length; i++){
        if (data[i].result_id === result_id){
          checkpts_obj[i] = new checkpoint(data[i].station_name, data[i].time_stamp,
          data[i].diff_time_stamp, data[i].diff_sec, data[i].checkpoint_result_id, data[i].result_id)
        }
      }
      console.log(checkpts_obj)
      FillTable(checkpts_obj)
      //async returns promise, fix later
      //may have to put all code in async as jank solution
      //need to make sure it only grabs specific user data, not all to avoid potential privacy problems
    }
  </script>


  <div class="mb-3 mx-auto w-50">
    <h1>Event:</h1>
    <table style="border-color: black;" class="table table-bordered" id="timetable">
      <thead>
        <tr>
          <th scope="col">Checkpoint nr:</th>
          <th scope="col">Starttime:</th>
          <th scope="col">Endtime:</th>
          <th scope="col">Total time:</th>
          <th scope="col">Terrain:</th>
          <th scope="col">Distance:</th>
          <th scope="col">Velocity:</th>

        </tr>
      </thead>
      <tbody>
        <script>
          function FillTable(data){
          for (let i = 0; i < data.length; i++) {
            let row = timetable.insertRow(i + 1)
            let cell1 = row.insertCell(0)
            let cell2 = row.insertCell(1)
            let cell3 = row.insertCell(2)
            let cell4 = row.insertCell(3)
            let cell5 = row.insertCell(4)
            let cell6 = row.insertCell(5)
            if (i == 0) {
              cell1.innerHTML = data[i].station_name + "(Start)"
            } else if (i == data.length - 1) {
              cell1.innerHTML = data[i].station_name + "(Finish)"
            } else {
              cell1.innerHTML = data[i].station_name
            }
            cell2.innerHTML = data[i].time_stamp
            cell3.innerHTML = data[i].diff_time_stamp
            cell4.innerHTML = data[i].diff_sec
            cell5.innerHTML = data[i].checkpoint_result_id
            cell6.innerHTML = data[i].result_id
          }
        }
          GetChecks("89")
        </script>
      </tbody>
    </table>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script type="text/javascript" src="../scripts/timetable.js"></script>

</body>
