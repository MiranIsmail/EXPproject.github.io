
//import * as endpoint from "endpoint_functions.js";
window.onload = function () { };


// Utility functions for demo purpose

function createAccount() {
  let xemail = document.getElementById("email").value;
  let xfirst_name = document.getElementById("fname").value;
  let xlast_name = document.getElementById("lname").value;
  let xpassword = document.getElementById("pword").value;
  let xusername = document.getElementById("fuser").value;

  fetch(BASE_ULR + "Account", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      email: xemail,
      first_name: xfirst_name,
      last_name: xlast_name,
      password: xpassword,
      username: xusername,
    }),
  })
    .then((response) => {
      var test = response.json();
      console.log(test);
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => console.error(error));
  location.href = "../pages/confirmation_account.php";
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
  const response = await fetch(BASE_ULR + "Token", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email: femail, password: fpword }),
  });
  const data = await response.json();
  document.cookie = `auth_token=${await data["auth_token"]}`;
  location.href = "../pages/profile.php";
}

async function log_out() {
  const response = await fetch(BASE_ULR + "Token", {
    method: "DELETE",
    headers: { Authorization: get_cookie("auth_token") },
  });
  const data = await response.json();
  console.log(await data);
  location.href = "../pages/";
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
  console.log(parameters);

  await fetch(BASE_ULR + "Account", {
    method: "PATCH",
    headers: {
      "Content-Type": "application/json",
      Authorization: get_cookie("auth_token"),
    },
    body: JSON.stringify(parameters),
  });

  location.href = "../pages/profile.php";
}

function include_HTML() {
  var z, i, element, file, xhttp;
  /* Loop through a collection of all HTML elements: */
  z = document.getElementsByTagName("div");

  for (i = 0; i < z.length; i++) {
    element = z[i];
    /*search for elements with a certain atrribute:*/
    file = element.getAttribute("include-html");

    if (file) {
      /* Make an HTTP request using the attribute value as the file name: */
      xhttp = new XMLHttpRequest();
      console.log(file);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            element.innerHTML = this.responseText;
          }
          if (this.status == 404) {
            element.innerHTML = "Page not found.";
          }
          /* Remove the attribute, and call this function once more: */
          element.removeAttribute("include-html");
          include_HTML();
        }
      };
      xhttp.open("GET", file, true);
      xhttp.send();
      /* Exit the function: */
      return;
    }
  }
}

async function update_navbar() {
  status_code = 401;
  if (get_cookie("auth_token")) {
    const response = await fetch(BASE_ULR + "Token", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: get_cookie("auth_token"),
      },
    });
    status_code = await response.status;
  }

  if (status_code == 200) {
    document.getElementById("navbar-log-out").classList.remove("d-none");
    document.getElementById("navbar-profile").classList.remove("d-none");
  } else {
    document.getElementById("navbar-log-in").classList.remove("d-none");
  }
}


async function get_checkpoints(event_id) {
  const response = await fetch(BASE_ULR + "Event/" + event_id, {
    method: "GET",
  });
  const data_event = await response.json();
  const track = data_event["track_name"];

  response = await fetch(BASE_URL + "Track/" + track, {
    method: "GET",
  });
  data_track = await response.json();
  const start_startion = data_track["start_station"];
  const end_station = data_track["end_station"];
}

function CreateTrack(track_input, start_station, end_station) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", BASE_ULR + "Track", false); // false makes the request synchronous
  xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhr.send(
    JSON.stringify({
      track_name: track_input,
      start_station: start_station,
      end_station: end_station,
    })
  );
  console.log("Track created");
}

async function CreateCheckpoint(
  trackname,
  startid,
  endid,
  dist,
  terrain,
  longitude,
  latitude,
  number
) {
  await fetch(BASE_ULR + "Checkpoint", {
    method: "POST",
    body: JSON.stringify({
      track_name: trackname,
      station_id: startid,
      next_id: endid,
      next_distance: dist,
      terrain: terrain,
      longitude: longitude,
      latitude: latitude,
      checkpoint_number: number,
    }),
    headers: { "Content-Type": "application/json; charset=UTF-8" },
  });
  console.log("Checkpoint created");
}

async function create_event() {
  const response_incoming = await fetch(BASE_ULR + "Account", {
    method: "GET",
    headers: { Authorization: get_cookie("auth_token") },
  });
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

  const response = await fetch(BASE_ULR + "Event", {
    method: "POST",
    body: JSON.stringify(parameters),
  });
  console.log(JSON.stringify(parameters));
  location.href = "../pages/confirmation_event.php";
}

async function TrackDropdown() {
  response = await fetch("https://rasts.se/api/Track", {
    method: "GET",
    headers: { Accept: "Application/json" },
  });
  let dropdown = document.getElementById("dropdown_track");
  data = await response.json();
  for (let i = 0; i < data.length; i++) {
    dropdown.add(new Option(data[i].track_name));
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
      body: JSON.stringify({ "email": email }),
      headers: { "Content-Type": "application/json" },
    });
  
    if (response.status > 300) {
      responde.innerHTML = "Email dosn't exict!";
    } else {
      responde.innerHTML = "Email was sent successfully, it may take a couple minute to receive the email!";
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
    var pass_confirm = document.getElementById("confirm_password_reseted").value;
    if (pass == pass_confirm) {
      const response = await fetch(BASE_ULR + "Account", {
        method: "PATCH",
        body: JSON.stringify({ "url": url,
                              "password": pass }),
        headers: { "Content-Type": "application/json" },

      });
      if (response.status > 300) {
        responde.innerHTML = "an error occured when reseting the password, try clicking on the link again and resetting!";
      } else {
        responde.innerHTML = "Password is reseted, you can log in with your new password";
      }
    } else {
      responde.innerHTML = "Passwords don't match!";
    }
  }

}

async function GetChecks(result_id, event_id) {
    //calls the api and fills the html table with data

    check_time = await fetch(
      "https://rasts.se/api/Results/" + result_id.toString(),
      { method: "GET", headers: { Accept: "Application/json" } }
    );

    check_time = await check_time.json()

    check_terrain = await fetch(
      "https://rasts.se/api/Checkpoint?event_id=" + event_id.toString(),
      { method: "GET", headers: { Accept: "Application/json" } }
    );

    check_terrain = await check_terrain.json()

    event_info = await fetch(
      "https://rasts.se/api/Event/" + event_id.toString(),
      { method: "GET", headers: { Accept: "Application/json" } }
    );
    event_info = await event_info.json()

    document.getElementById('event_title').innerHTML = "Event: " + event_info.event_name
    document.getElementById('track_title').innerHTML = "Track: " + check_terrain[0].track_name
    document.getElementById('date').innerHTML = "Date: From " + event_info.startdate + " to " + event_info.enddate
    FillTable(check_time, check_terrain)
  }

function FillTable(check_time, check_terrain) {

  check_terrain.sort((a,b)=>(a.checkpoint_number > b.checkpoint_number) ? 1 : -1)//sorts the api/Checkpoint objects positions from smallest to largest

  for (let i = 0; i < check_terrain.length; i++) {
    corresponding_index = 0
    successing_index = 0
    for(let p = 0; p < check_time.result.length; p++){
      if(check_time.result[p].station_name == check_terrain[i].station_id){ //finds the checkpoint_time with the same name, janky but it works for now
        corresponding_index = p
    }
    for(let o = 0; o < check_time.result.length; o++){
      if(check_terrain[i+1]){
      if(check_time.result[o].station_name == check_terrain[i+1].station_id){ //here so that we can grab the next objects start time without going stray
        successing_index = o
      }
    }}
  }
    console.log(check_time.result[corresponding_index].station_name, check_terrain[i].station_id)
    let row = timetable.insertRow(i + 1);
    let cell1 = row.insertCell(0); //station name
    let cell2 = row.insertCell(1); //time in seconds
    let cell3 = row.insertCell(2); //start time
    let cell4 = row.insertCell(3); //end time
    let cell5 = row.insertCell(4); //terrain
    let cell6 = row.insertCell(5); //distance
    let cell7 = row.insertCell(6); //average velocity

    cell1.innerHTML = check_time.result[corresponding_index].station_name
    cell2.innerHTML = check_time.result[corresponding_index].diff_sec + "(s)"
    cell3.innerHTML = check_time.result[corresponding_index].time_stamp
    if(check_time.result[i+1]){
      cell4.innerHTML = check_time.result[successing_index].time_stamp
    }
    cell5.innerHTML = check_terrain[i].terrain
    cell6.innerHTML = check_terrain[i].next_distance
    cell7.innerHTML = AverageVel(parseInt(check_terrain[corresponding_index].next_distance), parseInt(check_time.result[i].diff_sec)).toFixed(2) + "m/s"
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

async function timetable_link_func(){
  const urlParams = new URLSearchParams(window.location.search);
  event_id = urlParams.get("event_id");
  result_id = urlParams.get("result_id")
  GetChecks(result_id, event_id)
}
