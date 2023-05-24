//import * as endpoint from "endpoint_functions.js";
window.onload = function () {};

// Utility functions for demo purpose

async function createAccount() {
  let is_allowed = document.getElementById("gdprCheckbox").checked;
  let xemail = document.getElementById("email").value;
  let xfirst_name = document.getElementById("fname").value;
  let xlast_name = document.getElementById("lname").value;
  let xpassword = document.getElementById("pword").value;
  let xusername = document.getElementById("fuser").value;

  if (is_allowed) {
    const response = await create_account_endpoint(
      xemail,
      xfirst_name,
      xlast_name,
      xpassword,
      xusername
    );
    if (response.status < 300) {
      location.href = "../pages/confirmation_account.php";
    } else {
      alert("Something went wrong with our account creation");
    }
  } else {
    alert("Please accept the terms and conditions");
  }
}

function fill_org_form() {
  // Get all required input fields
  const requiredFields = document.querySelectorAll("input[required]");

  // Check if all required fields are filled in and valid
  const allFieldsValid = Array.from(requiredFields).every((field) =>
    field.checkValidity()
  );

  if (allFieldsValid) {
    // get references to form elements
    const orgNameInput = document.getElementById("org_name");
    const orgCountryInput = document.getElementById("org_country");
    const orgEmailInput = document.getElementById("org_email");
    const userEmailInput = document.getElementById("user_email");

    // extract values from form elements
    const orgName = orgNameInput.value;
    const orgCountry = orgCountryInput.value;
    const orgEmail = orgEmailInput.value;
    const userEmail = userEmailInput.value;

    console.log(`Organisation name: ${orgName}`);
    console.log(`Country: ${orgCountry}`);
    console.log(`Email Address for organisation: ${orgEmail}`);
    console.log(`Private Email Address: ${userEmail}`);
  }
}

async function log_in() {
  let femail = document.getElementById("fetchEmail").value;
  let fpword = document.getElementById("fetchPword").value;
  const response = await get_token_endpoint(femail, fpword);

  if (response.status >= 300) {
    alert("Invalid credentials\n Make sure your credentials are valid and your email is confirmed!");
  } else {
    const data = await response.json();
    document.cookie = `auth_token=${await data["auth_token"]}`;
    location.href = "../pages/profile.php";
  }
}

async function log_in_org() {
  let femail = document.getElementById("fetchEmailOrg").value;
  let fpword = document.getElementById("fetchPwordOrg").value;
  const response = await get_token_endpoint(femail, fpword, "Organization");

  if (response.status >= 300) {
    alert("Invalid credentials");
  } else {
    const data = await response.json();
    document.cookie = `auth_token=${await data["auth_token"]}`;
    location.href = "../pages/profile.php";
  }
}

async function log_out() {
  const response = await delete_token_endpoint(get_cookie("auth_token"),get_cookie("user_type"));
  if (response.status < 300) {
    console.log("Logged out");
    location.href = "../pages/";
  } else {
    console.log("Something went wrong with our logout");
  }
}

async function edit_user_info() {
  var parameters = {};
  parameters["first_name"] = document.getElementById("send_f_name").value;
  parameters["last_name"] = document.getElementById("send_l_name").value;
  parameters["birthdate"] = document.getElementById("send_bday").value;
  parameters["height"] = document.getElementById("send_height").value;
  parameters["weight"] = document.getElementById("send_weight").value;
  parameters["chip_id"] = document.getElementById("send_chip").value;

  if (document.getElementById("send_image").files.length != 0) {
    parameters["pimage"] = await image_compress_64(
      document.getElementById("send_image")
    );
  }

  for (const [key, value] of Object.entries(parameters)) {
    console.log(key, value);
    if (!value) {
      delete parameters[key];
    }
  }
  const response = edit_user_details_endpoint(parameters);
  if (response.status < 300) {
    location.href = "../pages/profile.php";
  } else {
    alert("Something went wrong in edit user details");
  }
}

async function get_checkpoints(event_id) {
  const marker_dict = {};

  const event_response = await get_event_endpoint(event_id);
  const event_data = await event_response.json();
  const track_name = await event_data["track_name"];

  let response = await fetch(
    BASE_ULR + "Checkpoint?track_name=" + track_name,
    {
      method: "GET",
    }
  );

  if (response.status >= 300) {
    alert("Something went wrong. Please try again later");
   }
   
  const data = await response.json();

  const start_placement = {
    lat: parseFloat(data[0].latitude),
    lng: parseFloat(data[0].longitude),
  };

  init_map(start_placement);

  for (let i = 0; i < data.length; i++) {
    let checkpoint = data[i];
    let position = {
      lat: parseFloat(checkpoint.latitude),
      lng: parseFloat(checkpoint.longitude),
    };

    new google.maps.Marker({
      position: position,
      map: map,
      label: checkpoint.checkpoint_number,
    });
    marker_dict[checkpoint.checkpoint_number] = position;
  }
  console.log(marker_dict);

  const lineSymbol = {
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
  };

  for (let i = 1; i < Object.keys(marker_dict).length; i++) {
    let start = marker_dict[i];
    let end = marker_dict[i + 1];
    console.log("start", start);
    console.log("end", end);

    new google.maps.Polyline({
      path: [start, end],
      icons: [
        {
          icon: lineSymbol,
          offset: "100%",
        },
      ],
      map: map,
    });
  }
}

function init_map(placement) {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 14,
    center: placement,
    mapTypeId: "terrain",
  });
  console.log(map);
}

function CreateTrack(track_input, start_station, end_station) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", BASE_ULR + "Track", false); // false makes the request synchronous
  xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  // Add the auth_token header
  xhr.setRequestHeader("Authorization", get_cookie("auth_token"));

  xhr.send(
    JSON.stringify({
      track_name: track_input,
      start_station: start_station,
      end_station: end_station
    })
  );
  console.log("Track created");

}

async function create_event() {
  const response_incoming = await get_user_details_endpoint(get_cookie("auth_token"));
  if (response_incoming.status >= 300) {
    alert("You are not user");
  }
  else {
    const data_incoming = await response_incoming.json();

    var parameters = {};
    parameters["event_name"] = document.getElementById("send_event_name").value;
    parameters["track_name"] = document.getElementById("dropdown_track").value;
    parameters["username"] = await data_incoming["username"];
    parameters["startdate"] = document.getElementById("send_start_date").value;
    parameters["enddate"] = document.getElementById("send_end_date").value;
    parameters["eimage"] = document.getElementById("send_image").value;
    parameters["description"] = document.getElementById("send_description").value;
    parameters["sport"] = document.getElementById("send_sport").value;

    var entry = document.getElementById("send_open").checked;
    var view = document.getElementById("send_public").checked;

    if (entry == true) {
      parameters["open_for_entry"] = "1";
    } else {
      parameters["open_for_entry"] = "0";
    }

    if (view == true) {
      parameters["public_view"] = "1";
    } else {
      parameters["public_view"] = "0";
    }

    if (document.getElementById("send_image").files.length != 0) {
      parameters["eimage"] = await image_compress_64_large(
        document.getElementById("send_image")
      );
    }

    for (const [key, value] of Object.entries(parameters)) {
      console.log(key, value);
      if (!value) {
        delete parameters[key];
      }
    }

    const response = await create_event_endpoint(parameters);
    if (response.status < 300) {
      location.href = "../pages/confirmation_event.php";
    } else {
      console.log("Something went wrong in create event");
    }
  }
}

async function TrackDropdown() {
  const response = await get_all_tracks_endpoint();
  let dropdown = document.getElementById("dropdown_track");
  data = await response.json();
  for (let i = 0; i < data.length; i++) {
    dropdown.add(new Option(data[i].track_name));
  }
}

async function email_confirmed(event) {
  event.preventDefault();
  var responde = document.getElementById("responde");
  const url = new URL(window.location.href);
  const response = await fetch(BASE_ULR + "Account", {
    method: "PATCH",
    body: JSON.stringify({
      url: url,
    }),
    headers: { "Content-Type": "application/json" },
  });
  if (response.status > 300) {
    responde.innerHTML = "an error occured. Email not verified!";
  } else {
    responde.innerHTML = "Email is verified, Feel free to log in!";
  }
}

async function email_to_forgot_password(event) {
  event.preventDefault();
  var email = document.getElementById("email").value;
  var responde = document.getElementById("responde");
  if (!email) {
    responde.innerHTML = "Please enter a valid Email!";
  } else {
    const response = await fetch(BASE_ULR + "Token", {
      method: "PATCH",
      body: JSON.stringify({ email: email }),
      headers: { "Content-Type": "application/json" },
    });

    if (response.status > 300) {
      responde.innerHTML = "Email dosn't exict!";
    } else {
      responde.innerHTML =
        "Email was sent successfully, it might take couple of minutes to receive the email!";
    }
    console.log(response);
  }
}

async function update_user_password(event) {
  event.preventDefault();
  var responde = document.getElementById("responde");
  const url = new URL(window.location.href);
  // const token = url.searchParams.get("token");
  var pass = document.getElementById("password_reseted").value;
  if (!pass) {
    responde.innerHTML = "Please enter a valid password!";
  } else {
    var pass_confirm = document.getElementById(
      "confirm_password_reseted"
    ).value;
    if (pass == pass_confirm) {
      const response = await fetch(BASE_ULR + "Account", {
        method: "PATCH",
        body: JSON.stringify({
          url: url,
          password: pass,
        }),
        headers: { "Content-Type": "application/json" },
      });
      if (response.status > 300) {
        responde.innerHTML =
          "an error occured when reseting the password, try clicking on the link again and resetting!";
      } else {
        responde.innerHTML =
          "Password is reseted, you can log in with your new password";
      }
    } else {
      responde.innerHTML = "Passwords don't match!";
    }
  }
}

async function GetChecks(result_id, event_id, speed_unit, distance_unit) {
  //calls the api and fills the html table with data
  check_time = await get_result_endpoint(result_id)
  check_time = await check_time.json()

  event_info = await get_event_endpoint(event_id);
  event_info = await event_info.json()

  check_terrain = await get_track_checkpoints_endpoint(event_info.track_name);
  check_terrain = await check_terrain.json()
  
  document.getElementById('event_title').innerHTML = "Event: " + event_info.event_name
  document.getElementById('track_title').innerHTML = "Track: " + check_terrain[0].track_name
  document.getElementById('date').innerHTML = "Date: From " + event_info.startdate + " to " + event_info.enddate
  FillTable(check_time, check_terrain, speed_unit, distance_unit)
}

function FillTable(check_time, check_terrain, speed_unit, distance_unit) {
  //check_terrain = Checkpoint data, check_time = checkpoint_time data
  //#############################################################################
  check_terrain.sort((a, b) =>
    a.checkpoint_number > b.checkpoint_number ? 1 : -1
  ); //sorts the api/Checkpoint objects positions from smallest to largest by checkpoint_number

  const dict = {}; //this dictionary will first be fille up with the Checkpoint data in order as the keys, then the corresponding object in checkpoint_time with the same station_name will have its index used as a value

  check_terrain.forEach((item) => {
    const station_id = item.station_id;
    if (!dict[station_id]) {
      dict[station_id] = [];
    }
  });

  check_time.result.forEach((item, index) => {
    const station_name = item.station_name;
    if (dict[station_name]) {
      dict[station_name].push(index);
    }
  });
  //#############################################################################
  let total_time = 0
  let total_dist = 0
  for (let i = 0; i < check_terrain.length; i++) {
    let row = timetable.insertRow(i + 1);
    let cell1 = row.insertCell(0); //station name
    let cell2 = row.insertCell(1); //time in seconds
    let cell3 = row.insertCell(2); //terrain
    let cell4 = row.insertCell(3); //distance
    let cell5 = row.insertCell(4); //average velocity
    if (check_terrain[i + 1]) {
      if (i == 0) {
        cell1.innerHTML =
          check_time.result[dict[check_terrain[i].station_id][0]].station_name +
          " (Start) to " +
          check_time.result[dict[check_terrain[i + 1].station_id][0]]
            .station_name;
            if(speed_unit=='kmh'){
        cell5.innerHTML =
         convert_kmh(AverageVel(
            parseInt(
              check_terrain[dict[check_terrain[i].station_id][0]].next_distance
            ),
            parseInt(
              check_time.result[dict[check_terrain[i + 1].station_id][0]]
                .diff_sec
            )
          )).toFixed(1) + " km/h";}
          else if(speed_unit=='mph'){
            cell5.innerHTML =
             convert_mph(AverageVel(
                parseInt(
                  check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                ),
                parseInt(
                  check_time.result[dict[check_terrain[i + 1].station_id][0]]
                    .diff_sec
                )
              )).toFixed(1) + " mph";}
              else if(speed_unit=='kn'){
                cell5.innerHTML =
                 convert_knots(AverageVel(
                    parseInt(
                      check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                    ),
                    parseInt(
                      check_time.result[dict[check_terrain[i + 1].station_id][0]]
                        .diff_sec
                    )
                  )).toFixed(1) + " knots";}
                  else if(speed_unit=='kpm'){
                    cell5.innerHTML =
                     convert_kpm(AverageVel(
                        parseInt(
                          check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                        ),
                        parseInt(
                          check_time.result[dict[check_terrain[i + 1].station_id][0]]
                            .diff_sec
                        )
                      )).toFixed(1) + " kpm";
                  }
              else{
                cell5.innerHTML =
                 (AverageVel(
                    parseInt(
                      check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                    ),
                    parseInt(
                      check_time.result[dict[check_terrain[i + 1].station_id][0]]
                        .diff_sec
                    )
                  )).toFixed(1) + " m/s";
              } 
      } else if (i == check_terrain.length - 2) {
        cell1.innerHTML =
          check_time.result[dict[check_terrain[i].station_id][0]].station_name +
          " to " +
          check_time.result[dict[check_terrain[i + 1].station_id][0]]
            .station_name +
          " (End)";
      } else {
        cell1.innerHTML =
          check_time.result[dict[check_terrain[i].station_id][0]].station_name +
          " to " +
          check_time.result[dict[check_terrain[i + 1].station_id][0]]
            .station_name;
      }
      cell2.innerHTML = pretty_print_time(
        check_time.result[dict[check_terrain[i + 1].station_id][0]].time_stamp
      );
      cell3.innerHTML = check_terrain[i].terrain;
      if(distance_unit == 'km')
      cell4.innerHTML = convert_kilo(check_terrain[i].next_distance) + " km";
      else if(distance_unit == 'miles'){
        cell4.innerHTML = convert_mile(check_terrain[i].next_distance) + " miles";
      }
      else if(distance_unit == 'naut_miles'){
        cell4.innerHTML = convert_naut(check_terrain[i].next_distance) + " nm";
      }
      else{
        cell4.innerHTML = check_terrain[i].next_distance + " m";
      }
      if (i != 0) {
        if(speed_unit=='kmh'){
          cell5.innerHTML =
           convert_kmh(AverageVel(
              parseInt(
                check_terrain[dict[check_terrain[i].station_id][0]].next_distance
              ),
              parseInt(
                check_time.result[dict[check_terrain[i + 1].station_id][0]]
                  .diff_sec
              )
            )).toFixed(1) + " km/h";}
            else if(speed_unit=='mph'){
              cell5.innerHTML =
               convert_mph(AverageVel(
                  parseInt(
                    check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                  ),
                  parseInt(
                    check_time.result[dict[check_terrain[i + 1].station_id][0]]
                      .diff_sec
                  )
                )).toFixed(1) + " mph";}
                else if(speed_unit=='kn'){
                  cell5.innerHTML =
                   convert_knots(AverageVel(
                      parseInt(
                        check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                      ),
                      parseInt(
                        check_time.result[dict[check_terrain[i + 1].station_id][0]]
                          .diff_sec
                      )
                    )).toFixed(1) + " knots";}
                else{
                  cell5.innerHTML =
                   (AverageVel(
                      parseInt(
                        check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                      ),
                      parseInt(
                        check_time.result[dict[check_terrain[i + 1].station_id][0]]
                          .diff_sec
                      )
                    )).toFixed(1) + " m/s";
                }
      }
    cell2.innerHTML = pretty_print_time(check_time.result[dict[check_terrain[i+1].station_id][0]].diff_time_stamp)
    total_time += ConvertTime(check_time.result[dict[check_terrain[i+1].station_id][0]].diff_time_stamp)
    cell3.innerHTML = check_terrain[i].terrain
    if(distance_unit == 'km'){
      cell4.innerHTML = convert_kilo(check_terrain[i].next_distance) + " km";
    }
    else if(distance_unit == 'miles'){
      cell4.innerHTML = convert_mile(check_terrain[i].next_distance) + " miles";
    }
    else if(distance_unit == 'naut_miles'){
      cell4.innerHTML = convert_naut(check_terrain[i].next_distance) + " nm";
    }
    else{
      cell4.innerHTML = check_terrain[i].next_distance + " m"
    }
    total_dist += parseInt(check_terrain[i].next_distance)
    if(i!= 0){
      if(speed_unit=='kmh'){
        cell5.innerHTML =
         convert_kmh(AverageVel(
            parseInt(
              check_terrain[dict[check_terrain[i].station_id][0]].next_distance
            ),
            parseInt(
              check_time.result[dict[check_terrain[i + 1].station_id][0]]
                .diff_sec
            )
          )).toFixed(1) + " km/h";}
          else if(speed_unit=='mph'){
            cell5.innerHTML =
             convert_mph(AverageVel(
                parseInt(
                  check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                ),
                parseInt(
                  check_time.result[dict[check_terrain[i + 1].station_id][0]]
                    .diff_sec
                )
              )).toFixed(1) + " mph";}
              else if(speed_unit=='kn'){
                cell5.innerHTML =
                 convert_knots(AverageVel(
                    parseInt(
                      check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                    ),
                    parseInt(
                      check_time.result[dict[check_terrain[i + 1].station_id][0]]
                        .diff_sec
                    )
                  )).toFixed(1) + " knots";}
              else if(speed_unit=='kpm'){
                cell5.innerHTML =
                 convert_kpm(AverageVel(
                    parseInt(
                      check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                    ),
                    parseInt(
                      check_time.result[dict[check_terrain[i + 1].station_id][0]]
                        .diff_sec
                    )
                  )).toFixed(1) + " kpm";
              }
              else{
                cell5.innerHTML =
                 (AverageVel(
                    parseInt(
                      check_terrain[dict[check_terrain[i].station_id][0]].next_distance
                    ),
                    parseInt(
                      check_time.result[dict[check_terrain[i + 1].station_id][0]]
                        .diff_sec
                    )
                  )).toFixed(1) + " m/s";
              }
    }
    }
    if(i == check_terrain.length - 1){
      cell1.innerHTML = "Total:"
      cell2.innerHTML = format_time(total_time)
      if(distance_unit == 'km')
      {
        cell4.innerHTML = convert_kilo(total_dist) + " km"
      }
      else if(distance_unit == 'miles')
      {
        cell4.innerHTML = convert_mile(total_dist) + " miles"
      }
      else if(distance_unit == 'naut_miles')
      {
        cell4.innerHTML = convert_naut(total_dist) + " nm"
      }
      else{
        cell4.innerHTML = total_dist + "m";
      }
      

    }
  }
}
function TimeDiff(time1, time2) {
  //difference between two times in seconds
  time1 = ConvertTime(time1);
  time2 = ConvertTime(time2);
  return time2 - time1;
}
function AverageVel(distance, time_diff) {
  //average velocity
  return distance / time_diff;
}
function ConvertTime(time_string) {
  h1 = time_string[0]; //super advanced constant runtime hours/minute/seconds to seconds convertation algorithm
  h2 = time_string[1];
  m1 = time_string[3];
  m2 = time_string[4];
  s1 = time_string[6];
  s2 = time_string[7];
  seconds = s1 + s2;
  minutes = m1 + m2;
  hours = h1 + h2;
  seconds = parseInt(seconds);
  minutes = parseInt(minutes) * 60;
  hours = parseInt(hours) * 60 * 60;
  return hours + minutes + seconds;
}

function format_time(s){
  var hours = Math.floor(s / 3600);
  var minutes = Math.floor((s % 3600) / 60);
  var remainingSeconds = s % 60;
  
  var formattedTime = hours.toString().padStart(2, '0') + 'h ' +
  minutes.toString().padStart(2, '0') + 'm ' +
  remainingSeconds.toString().padStart(2, '0') + 's';
  
  return formattedTime;
}

function pretty_print_time(ts) {
  return ts[0] + ts[1] + "h " + ts[3] + ts[4] + "m " + ts[6] + ts[7] + "s";
}

async function timetable_link_func(speed_unit, distance_unit) {
  const urlParams = new URLSearchParams(window.location.search);
  event_id = urlParams.get("event_id");
  result_id = urlParams.get("result_id");
  GetChecks(result_id, event_id, speed_unit, distance_unit);
}

function convert_kmh(ms){
  return (ms * 3600) / 1000
}

function convert_mph(ms){
  return (ms * 3600) / 1609.3
}

function convert_knots(ms){
  return (ms * 3600) / 1852
}

function convert_kpm(ms){
  return (ms / 16.667)
}

function convert_kilo(m){
  return (m / 1000).toFixed(2)
}

function convert_mile(m){
  return (m / 1609.34).toFixed(2)
}

function convert_naut(m){
  return (m / 1852).toFixed(2)
}

function convert_feet(m){
  return (m * 3.28084).toFixed(2)
}
