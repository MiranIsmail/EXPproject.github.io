<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>

  <script>

    // class checkpoint { //Not a necessary class right now but might be useful for manipulating data later on
    //   constructor(station_name, time_stamp, diff_time_stamp, diff_sec,
    //   checkpoint_result_id, result_id){
    //     this.station_name = station_name
    //     this.time_stamp = time_stamp 
    //     this.diff_time_stamp = diff_time_stamp
    //     this.diff_sec = diff_sec
    //     this.checkpoint_result_id = checkpoint_result_id
    //     this.result_id = result_id
    //     }
    //   };
    
    async function GetChecks(result_id, event_id, token, track_name){
      //don't judge anything you read in this file, thank you

      checkpoint_time = await fetch("https://rasts.se/api/Results/" + result_id.toString(), {method:'GET',
      headers: {'Accept': 'Application/json'}})
      result_data = await fetch("https://rasts.se/api/Results?token=" + token.toString(), {method:'GET',
      headers: {'Accept': 'Application/json'}})
      event_data = await fetch("https://rasts.se/api/Results?event_id=" + event_id.toString(), {method:'GET',
      headers: {'Accept': 'Application/json'}})
      checkpoint_data = await fetch("https://rasts.se/api/Checkpoint?track_name=" + track_name.toString())
      data = await checkpoint_time.json();
      data1 = await result_data.json()
      data2 = await event_data.json()
      //console.log(data2)
      data3 = await checkpoint_data.json()
      //for(let i = 0; i < data2.length; i++){
        //if(data2[i].event_ids == event_id){
        //document.getElementById('event_title').innerHTML = "Event: " + data2.event_name
        document.getElementById('track_title').innerHTML = "Track: " + track_name
        document.getElementById('date').innerHTML = "Date: " + data2.results[0].DATE
      
      FillTable(data.result, data3, data2.event_name)
      console.log(data.result)
      console.log(data1)
      console.log(data2)
      console.log(data3)
      console.log(event)
    }
  </script>


  <div class="mb-3 mx-auto w-50">
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
        <script>
          function FillTable(data, data1, data2, data3){
            
            //  
            // 
          for (let i = 0; i < data.length; i++) {
            let row = timetable.insertRow(i + 1)
            let cell1 = row.insertCell(0)
            let cell2 = row.insertCell(1)
            let cell3 = row.insertCell(2)
            let cell4 = row.insertCell(3)
            let cell5 = row.insertCell(4)
            let cell6 = row.insertCell(5)
            if (i == 0) {
              cell1.innerHTML = data[i].station_name + " (Start)"
              if(data[i+1]){
                cell4.innerHTML = data[i+1].time_stamp
              }
            } else if (i == data.length - 1) {
              cell1.innerHTML = data[i].station_name + " (Finish)"
              cell2.innerHTML = "--||--"
              cell4.innerHTML = "--||--"
            } else {
              cell1.innerHTML = data[i].station_name
              cell4.innerHTML = data[i+1].time_stamp
            }
            // cell2.innerHTML = data[i].time_stamp
            cell3.innerHTML = data[i].time_stamp
            // cell4.innerHTML = data[i].diff_sec
            if(data1[i]){
            cell5.innerHTML = data1[i].terrain
            }
            if(data1[i]){
            cell6.innerHTML = data1[i].next_distance
            }
          }
        }
        function AverageVel(distance, time){
          return (distance/time)
        }
        function ConvertTime(time_string){
          h1 = time_string[0]
          h2 = time_string[1]
          m1 = time_string[3]
          m2 = time_string[4]
          s1 = time_string[6]
          s2 = time_string[7]
          s3 = time_string[8]
          s4 = time_string[9]
          return h1+h2+"h"+m1+m2+"m"+s1+s2+s3+s4+"s"
        }
          //console.log(ConvertTime("23:35:52.3275"))
          GetChecks(95, 12, "c5bd7dec836ce331ce40a875a5406d3fa1f5942fd9e38d21a5ec2dbee7163d43", "Adams femte bana")
        </script>
      </tbody>
    </table>
  </div>
  <?php include '../assets/footer.php'; ?>
  <!-- <script type="text/javascript" src="../scripts/timetable.js"></script> -->

</body>
