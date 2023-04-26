<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>

  <script>
    async function GetChecks(result_id, event_id, token, track_name){
      //calls the api and fills the html table with data

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
      data3 = await checkpoint_data.json()
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

          for (let i = 0; i < data.length; i++) {
            let row = timetable.insertRow(i + 1)
            let cell1 = row.insertCell(0) //station name
            let cell2 = row.insertCell(1) //time in seconds
            let cell3 = row.insertCell(2) //start time
            let cell4 = row.insertCell(3) //end time
            let cell5 = row.insertCell(4) //terrain
            let cell6 = row.insertCell(5) //distance
            let cell7 = row.insertCell(6) //average time
            if (i == 0) {
              cell1.innerHTML = data[i].station_name + " (Start)"
              if(data[i+1]){
                cell4.innerHTML = data[i+1].time_stamp
                cell2.innerHTML = TimeDiff(data[i].time_stamp, data[i+1].time_stamp)
              }
            } else if (i == data.length - 1) {
              cell1.innerHTML = data[i].station_name + " (Finish)"
              cell2.innerHTML = ConvertTime(data[i].time_stamp)
              cell4.innerHTML = "--||--"
            } else {
              cell1.innerHTML = data[i].station_name
              cell2.innerHTML = TimeDiff(data[i].time_stamp, data[i+1].time_stamp)
              cell4.innerHTML = data[i+1].time_stamp
            }
            cell3.innerHTML = data[i].time_stamp
            if(data1[i]){
            cell5.innerHTML = data1[i].terrain
            }
            if(data1[i]){
            cell6.innerHTML = data1[i].next_distance
              if(data[i+1]){
              cell7.innerHTML = AverageVel(data1[i].next_distance, TimeDiff(data[i].time_stamp, data[i+1].time_stamp))
              }
            }
          }
        }
        function TimeDiff(time1, time2){//difference between two times in seconds
            time1 = ConvertTime(time1)
            time2 = ConvertTime(time2)
            return time2 - time1
        }
        function AverageVel(distance, time_diff){//average velocity
          return (distance/time_diff)
        }
        function ConvertTime(time_string){
          h1 = time_string[0]//super advanced constant runtime hours/minute/seconds to seconds convertation algorithm
          h2 = time_string[1]
          m1 = time_string[3]
          m2 = time_string[4]
          s1 = time_string[6]
          s2 = time_string[7]
          seconds = s1 + s2
          minutes = m1 + m2
          hours = h1 + h2
          seconds = parseInt(seconds)
          minutes = parseInt(minutes) * 60
          hours = parseInt(hours) * 60 * 60
          return hours + minutes + seconds
        }
        </script>
      </tbody>
    </table>
  </div>
  <?php include '../assets/footer.php'; ?>

</body>
