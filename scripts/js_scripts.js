var BASE_ULR = "https://rasts.se/api/";
//import * as endpoint from "endpoint_functions.js";
window.onload = function () { };


function image_compress_64(inputfile) {
  return new Promise((resolve, reject) => {
    var return_variable = ""
    const MAX_WIDTH = 320;
    const MAX_HEIGHT = 180;
    const MIME_TYPE = "image/jpeg";
    const QUALITY = 0.7;

    const file = inputfile.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    img.src = blobURL;
    img.onerror = function () {
      URL.revokeObjectURL(this.src);
      // Handle the failure properly
      console.log("Cannot load image");
    };
    img.onload = function () {
      URL.revokeObjectURL(this.src);
      const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
      const canvas = document.createElement("canvas");
      canvas.width = newWidth;
      canvas.height = newHeight;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, newWidth, newHeight);
      canvas.toBlob(
        (blob) => {
          // Handle the compressed image. es. upload or save in local state

          blobToBase64(blob).then(function (result) {
            resolve(result)
            // return_variable = result // "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gHYSUNDX"
          }).catch(function (error) {
            console.log(error);
          });
        },
        MIME_TYPE,
        QUALITY
      );
      document.getElementById("root").append(canvas);
    };

    // return return_variable
  });
}

function image_compress_64_large(inputfile) {
  return new Promise((resolve, reject) => {
    var return_variable = ""
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1080;
    const MIME_TYPE = "image/jpeg";
    const QUALITY = 0.7;

    const file = inputfile.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    img.src = blobURL;
    img.onerror = function () {
      URL.revokeObjectURL(this.src);
      // Handle the failure properly
      console.log("Cannot load image");
    };
    img.onload = function () {
      URL.revokeObjectURL(this.src);
      const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
      const canvas = document.createElement("canvas");
      canvas.width = newWidth;
      canvas.height = newHeight;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, newWidth, newHeight);
      canvas.toBlob(
        (blob) => {
          // Handle the compressed image. es. upload or save in local state

          blobToBase64(blob).then(function (result) {
            resolve(result)
            // return_variable = result // "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gHYSUNDX"
          }).catch(function (error) {
            console.log(error);
          });
        },
        MIME_TYPE,
        QUALITY
      );
      document.getElementById("root").append(canvas);
    };

    // return return_variable
  });
}

function calculateSize(img, maxWidth, maxHeight) {
  let width = img.width;
  let height = img.height;

  // calculate the width and height, constraining the proportions
  if (width > height) {
    if (width > maxWidth) {
      height = Math.round((height * maxWidth) / width);
      width = maxWidth;
    }
  } else {
    if (height > maxHeight) {
      width = Math.round((width * maxHeight) / height);
      height = maxHeight;
    }
  }
  return [width, height];
}

// Utility functions for demo purpose

function displayInfo(label, file) {
  const p = document.createElement("p");
  p.innerText = `${label} - ${readableBytes(file.size)}`;
  document.getElementById("root").append(p);
}

function readableBytes(bytes) {
  const i = Math.floor(Math.log(bytes) / Math.log(1024)),
    sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

  return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
}

const get_cookie = (name) =>
  document.cookie.match("(^|;)\\s*" + name + "\\s*=\\s*([^;]+)")?.pop() || "";

function blobToBase64(blob) {
  return new Promise((resolve, _) => {
    const reader = new FileReader();
    reader.onloadend = () => resolve(reader.result);
    reader.readAsDataURL(blob);
  });
}

async function calculate_age(date) {
  if (date != null) {
    var today = new Date();
    var birthDate = new Date(await date);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    return age;
  }

  return "missing";
}

function image_to_blob(inputElement) {
  const file = inputElement.files[0];
  if (!file) {
    return Promise.reject(new Error("No file selected"));
  }
  const reader = new FileReader();
  reader.readAsArrayBuffer(file);
  return new Promise((resolve, reject) => {
    reader.onload = () => {
      const blob = new Blob([reader.result], { type: file.type });
      resolve(blob);
    };
    reader.onerror = () => {
      reject(new Error("Error reading file"));
    };
  });
}

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

function load_image(indata) {
  var img = document.createElement("img");
  img.setAttribute("id", "profile_image");
  img.setAttribute("class", "img-fluid d-block");
  img.alt = "Profile Image";
  img.src = indata;
  var src = document.getElementById("profile_box");
  src.appendChild(img);
}

async function get_user_info() {
  const response = await fetch(BASE_ULR + "Account", {
    method: "GET",
    headers: { Authorization: get_cookie("auth_token") },
  });
  const data = await response.json();

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("profileName").innerHTML =
    (await data["first_name"]) + " " + (await data["last_name"]);
  document.getElementById("profile_age").innerHTML = await calculate_age(
    await data["birthdate"]
  );
  document.getElementById("profile_length").innerHTML = await data["height"];
  document.getElementById("profile_weight").innerHTML = await data["weight"];
  document.getElementById("profile_chip_id").innerHTML = await data["chip_id"];
  document.getElementById("profile_username").innerHTML = await data[
    "username"
  ];
  load_image(data["pimage"]);
  generate_user_results()
  // let container = document.getElementById("myTableContainerResults");
  // let myTable = await generate_user_results();
  // container.appendChild(myTable);
}
// async function get_user_results() {
//   let container = document.getElementById("myTableContainerResults");
//   let myTable = await generate_user_results();
//   container.appendChild(myTable);
// }

async function get_friend_info() {
  const urlParams = new URLSearchParams(window.location.search);
  g_username = urlParams.get("username");
  const response = await fetch(BASE_ULR + "Account/" + g_username, {
    method: "GET",
  });
  const data = await response.json();

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("profileName").innerHTML =
    (await data["first_name"]) + " " + (await data["last_name"]);
  document.getElementById("profile_age").innerHTML = await calculate_age(
    await data["birthdate"]
  );
  document.getElementById("profile_length").innerHTML = await data["height"];
  document.getElementById("profile_weight").innerHTML = await data["weight"];
  document.getElementById("profile_username").innerHTML = await data[
    "username"
  ];
  load_image(data["pimage"]);
  generate_friend_results()
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
    // var blob = await image_to_blob(document.getElementById("send_image"));
    // parameters["pimage"] = await blobToBase64(blob);
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




async function generate_event_results(){
  const urlParams = new URLSearchParams(window.location.search);
  event_id = urlParams.get("event_id");

  const response = await fetch(BASE_ULR + "Results/?event_id=" + event_id, {
    method: "GET",
  });
  const data = await response.json();
  console.log(data)

  if (data.results){
  for (let i = 0; i < data.results.results.length; i++) {
    let row = event_user_results.insertRow(i + 1)
    let cell1 = row.insertCell(0) //user1
    let cell2 = row.insertCell(1) //user2
    let cell3 = row.insertCell(2) //date
    let cell4 = row.insertCell(3) //time
    let cell5 = row.insertCell(4) //button
    cell1.innerHTML = data.results.results[i].user1
    cell2.innerHTML = data.results.results[i].user2
    cell3.innerHTML = data.results.results[i].DATE
    cell4.innerHTML = data.results.results[i].Time

    const link_button = document.createElement('button')
    link_button.innerText = 'More Info →'
    link_button.setAttribute("class", "more_info_button");
    link_button.onclick = function() {
    window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
  }
  cell1.setAttribute("class", "no_padding_vert")
  cell2.setAttribute("class", "no_padding_vert")
  cell3.setAttribute("class", "no_padding_vert")
  cell4.setAttribute("class", "no_padding_vert")
  cell5.setAttribute("class", "no_padding");
  cell5.appendChild(link_button)

  }}
}

async function generate_user_results() {
  const response = await fetch(
        BASE_ULR + "Results/?token=" + get_cookie("auth_token"),
        {
          method: "GET",
        }
      );
      const data = await response.json();
        console.log(data)
      if (data.results){
        for (let i = 0; i < data.results.results.length; i++) {
          let row = event_user_results.insertRow(i + 1)
          let cell1 = row.insertCell(0) //user1
          let cell2 = row.insertCell(1) //user2
          let cell3 = row.insertCell(2) //date
          let cell4 = row.insertCell(3) //time
          let cell5 = row.insertCell(4) //button
          cell1.innerHTML = data.results.results[i]["Competitor 1"]
          cell2.innerHTML = data.results.results[i]["Competitor 2"]
          cell3.innerHTML = data.results.results[i]["Total time"]
          cell4.innerHTML = data.results.results[i]["Event"]
          console.log("1"+data.results.results[i]["Competitor 1"])
          console.log("2"+data.results.results[i]["Competitor 2"])
          console.log("3"+data.results.results[i]["Total time"])
          console.log("4"+data.results.results[i]["Event"])
          const link_button = document.createElement('button')
          link_button.innerText = 'More Info →'
          link_button.setAttribute("class", "more_info_button");
          link_button.onclick = function() {
          window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
        }
        cell1.setAttribute("class", "no_padding_vert")
        cell2.setAttribute("class", "no_padding_vert")
        cell3.setAttribute("class", "no_padding_vert")
        cell4.setAttribute("class", "no_padding_vert")
        cell5.setAttribute("class", "no_padding");
        cell5.appendChild(link_button)
      
        }}


}
// async function generate_user_results() {
//   const response = await fetch(
//     BASE_ULR + "Results/?token=" + get_cookie("auth_token"),
//     {
//       method: "GET",
//     }
//   );
//   const data = await response.json();

//   let table = document.createElement("table");
//   table.setAttribute("class", "table");

//   // create table header row
//   let headerRow = document.createElement("tr");
//   for (let key in await data.results.results[0]) {
//     let headerCell = document.createElement("th");
//     headerCell.textContent = key;
//     headerRow.appendChild(headerCell);
//   }
//   table.appendChild(headerRow);

//   // create table rows
//   for (let i = 0; i < (await data.results.results.length); i++) {
//     let row = document.createElement("tr");

//     // create a link for the row
//     row.setAttribute(
//       "onclick",
//       `window.location.href="../pages/timetable?event_id=${data.results.event_ids[i]["event_id"]}&result_id=${data.results.event_ids[i]["result_id"]}"`
//     );

//     for (let key in await data.results.results[i]) {
//       let cell = document.createElement("td");
//       cell.textContent = await data.results.results[i][key];
//       row.appendChild(cell);
//     }
//     table.appendChild(row);
//   }

//   return table;
// }

async function generate_friend_results() {
  const urlParams = new URLSearchParams(window.location.search);
  g_username = urlParams.get("username");
  const response = await fetch(BASE_ULR + "Results/?username=" + g_username, {
    method: "GET",
  });
  const data = await response.json();

  if (data.results){
    for (let i = 0; i < data.results.results.length; i++) {
      let row = event_user_results.insertRow(i + 1)
      let cell1 = row.insertCell(0) //user1
      let cell2 = row.insertCell(1) //user2
      let cell3 = row.insertCell(2) //date
      let cell4 = row.insertCell(3) //time
      let cell5 = row.insertCell(4) //button
      cell1.innerHTML = data.results.results[i]["Competitor 1"]
      cell2.innerHTML = data.results.results[i]["Competitor 2"]
      cell3.innerHTML = data.results.results[i]["Total time"]
      cell4.innerHTML = data.results.results[i]["Event"]
      console.log("1"+data.results.results[i]["Competitor 1"])
      console.log("2"+data.results.results[i]["Competitor 2"])
      console.log("3"+data.results.results[i]["Total time"])
      console.log("4"+data.results.results[i]["Event"])
      const link_button = document.createElement('button')
      link_button.innerText = 'More Info →'
      link_button.setAttribute("class", "more_info_button");
      link_button.onclick = function() {
      window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
    }
    cell1.setAttribute("class", "no_padding_vert")
    cell2.setAttribute("class", "no_padding_vert")
    cell3.setAttribute("class", "no_padding_vert")
    cell4.setAttribute("class", "no_padding_vert")
    cell5.setAttribute("class", "no_padding");
    cell5.appendChild(link_button)
  
    }}
}

function search_account() {
  // Retrieve all cards
  let input = document.getElementById("search_profile").value;
  location.href = `../pages/profile_display?username=${input}`;
}
// async function generate_user_results() {
//   const response = await fetch(
//     BASE_ULR + "Results/?token=" + get_cookie("auth_token"),
//     {
//       method: "GET",
//     }
//   );
//   const data = await response.json();

//   let table = document.createElement("table");
//   table.setAttribute("class", "table");

//   // create table header row
//   let headerRow = document.createElement("tr");
//   for (let key in await data.results.results[0]) {
//     let headerCell = document.createElement("th");
//     headerCell.textContent = key;
//     headerRow.appendChild(headerCell);
//   }
//   table.appendChild(headerRow);

//   // create table rows
//   for (let i = 0; i < (await data.results.results.length); i++) {
//     let row = document.createElement("tr");

//     // create a link for the row
//     let link = document.createElement("a");
//     console.log(`../pages/timetable?event_id=${data.results.event_ids[i]["event_id"]}&result_id=${data.results.event_ids[i]["result_id"]}`)
//     row.setAttribute("href", `../pages/timetable?event_id=${data.results.event_ids[i]["event_id"]}&result_id=${data.results.event_ids[i]["result_id"]}`);

//     for (let key in await data.results.results[i]) {
//       let cell = document.createElement("td");
//       cell.textContent = await data.results.results[i][key];
//       console.log(await data.results.results[i][key]);
//       row.appendChild(cell);
//     }
//     table.appendChild(row);
//   }

//   return table;
// }

function search_event() {
  // Retrieve all cards
  let input = document.getElementById("searchQueryInput").value;

  const cards = document.querySelectorAll(".card");
  console.log(input);
  const searchQuery = input.toLowerCase();
  console.log(searchQuery);
  // Loop through cards and show/hide based on search query
  cards.forEach((card) => {
    const title = card.querySelector(".card-title").textContent.toLowerCase();
    if (title.indexOf(searchQuery) > -1) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
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

/* EVENT PAGE*/
async function get_event_info(event_id) {
  const response = await fetch(BASE_ULR + "Event/" + event_id, {
    method: "GET",
  });
  const data = await response.json();
  console.log(data);
  //Just getting the source from the span. It was messy in JS.
  document.getElementById("event_name_colapse").innerHTML = await data[
    "event_name"
  ];

  document.getElementById("event_name").innerHTML = await data["event_name"];
  document.getElementById("event_track").innerHTML = await data["track_name"];
  document.getElementById("event_sport").innerHTML = await data["sport"];
  document.getElementById("event_sdate").innerHTML = await data["startdate"];
  document.getElementById("event_edate").innerHTML = await data["enddate"];

  document.getElementById("username_link").setAttribute("onclick", `location.href="../pages/profile_display?username=${data["username"]}"`);
  document.getElementById("event_org").innerHTML = await data["username"];
  document.getElementById("event_desc").innerHTML = await data["description"];
  document.getElementById("event_track").innerHTML = await data["track_name"];
  console.log(await data["description"]);
  load_image_event(data["eimage"]);

  generate_event_results()
  // let container = document.getElementById("myTableContainer");
  // let myTable = await generate_event_results(event_id);
  // container.appendChild(myTable);
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

function load_image_event(indata) {
  var img = document.createElement("img");
  img.setAttribute("id", "event_image_display");
  img.setAttribute("class", "img-fluid d-block");
  img.src = indata;
  img.alt = "Event image";
  var src = document.getElementById("image_box");
  src.appendChild(img);
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
    // var blob = await image_to_blob(document.getElementById("send_image"));
    // parameters["eimage"] = await blobToBase64(blob);
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

function preview_event() {
  let event_name = document.getElementById("send_event_name").value;
  let host_name = document.getElementById("send_description").value;
  let start_date = document.getElementById("send_start_date").value;
  let end_date = document.getElementById("send_end_date").value;
  let imageInput = document.getElementById("send_image");
  let image = "";

  // check if an image was selected
  if (imageInput.files && imageInput.files[0]) {
    let reader = new FileReader(); // create a FileReader object
    reader.onload = function () {
      image = reader.result; // set image to the result of the FileReader
      generate_card_wide(
        event_name,
        "Date: " + start_date + "\n - " + end_date,
        host_name,
        image
      );
    };
    reader.readAsDataURL(imageInput.files[0]); // read the selected file as a data URL
  } else {
    generate_card_wide(
      event_name,
      "Date: " + start_date + "\n - " + end_date,
      host_name,
      image
    );
  }
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

// // Function to generate table
// async function generate_event_results(event_id) {
//   const response = await fetch(BASE_ULR + "Results/?event_id=" + event_id, {
//     method: "GET",
//   });
//   const data = await response.json();

//   let table = document.createElement("table");
//   table.setAttribute("class", "table");

//   // create table header row
//   let headerRow = document.createElement("tr");
//   for (let key in await data.results[0]) {
//     let headerCell = document.createElement("th");
//     headerCell.textContent = key;
//     headerRow.appendChild(headerCell);
//   }
//   table.appendChild(headerRow);

//   // create table rows
//   for (let i = 0; i < (await data.results.length); i++) {
//     let row = document.createElement("tr");
//     for (let key in await data.results[i]) {
//       let cell = document.createElement("td");
//       cell.textContent = await data.results[i][key];
//       console.log(await data.results[i][key]);
//       row.appendChild(cell);
//     }
//     table.appendChild(row);
//   }

//   return table;
// }

function register_on_event(event_id) {
  var parameters = {};
  parameters["event_id"] = event_id;
  parameters["token"] = get_cookie("auth_token");
  parameters["user2"] = document.getElementById("send_team8").value;
  parameters["chip_id"] = document.getElementById("send_chip").value;

  const response = fetch(BASE_ULR + "Registration", {
    method: "POST",
    body: JSON.stringify(parameters),
  });

  alert("You have been Registerd");
}

function register_on_event_my(event_id) {
  var parameters = {};
  parameters["event_id"] = event_id;
  parameters["token"] = get_cookie("auth_token");
  parameters["user2"] = document.getElementById("send_team8").value;
  parameters["chip_id"] = document.getElementById("chip_id_display").value;

  const response = fetch(BASE_ULR + "Registration", {
    method: "POST",
    body: JSON.stringify(parameters),
  });

  alert("You have been Registerd");
}

async function get_chip() {
  const response = await fetch(BASE_ULR + "Account", {
    method: "GET",
    headers: { Authorization: get_cookie("auth_token") },
  });
  const data = await response.json();
  console.log(data["chip_id"])
  document.getElementById("chip_id_display").value = await data["chip_id"];
}

async function email_to_forgot_password() {
  var email = document.getElementById("email").value;
  if (!email) {
    alert('Please enter a value for all fields!');
  const response = await fetch(BASE_ULR + "Token", {
    method: "PATCH",
    body: JSON.stringify({ "email": email }),
    headers: { "Content-Type": "application/json" },
  });

  if (response.status > 300) {
    window.alert("Email was not sent, try again!");
  }

  if (response.status < 300){
    window.alert("Email was sent successfully!");
  }

}
}
// .then((response) => {
//   if (!response.ok) {
//     throw new Error("Network response was not ok");
//   }
//   return response.json();
// })
// .catch((error) => {
//   console.error("There was an error sending the email:", error);
// });

async function update_user_password() {
  const url = new URL(window.location.href);
  const token = url.searchParams.get("token");
  var pass = document.getElementById("password_reseted").value;
  var pass_confirm = document.getElementById("confirm_password_reseted").value;
  if (pass == pass_confirm) {
    const response = await fetch(BASE_ULR + "Account", {
      method: "PATCH",
      body: JSON.stringify({ "url": url,
                             "password": pass }),
      headers: { "Content-Type": "application/json" },
      
    });
    window.alert("Done");
  } else {
    window.alert("An error happend, try matching the passwords and try again!");
    location.href = " https://rasts.se/pages/create_new_password.php?token=" ,token;
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

// async function event_display_peeps(){

//   const urlParams = new URLSearchParams(window.location.search);
//   event_id = urlParams.get("event_id");

//   event_data = await fetch("https://rasts.se/api/Results?event_id=" + event_id, {method:'GET',
//   headers: {'Accept': 'Application/json'}})

//   data = await event_data.json();
//   console.log(data)

//   //console.log(data)

//   // for(let i = 0; i < data.results.length; i++)
//   // {
//   //   console.log(data.results[i])
//   // }
//   if (data.results){
//   for (let i = 0; i < data.results.length; i++) {
//     let row = event_user_results.insertRow(i + 1)
//     let cell1 = row.insertCell(0) //user1
//     let cell2 = row.insertCell(1) //user2
//     let cell3 = row.insertCell(2) //date
//     let cell4 = row.insertCell(3) //time
//     let cell5 = row.insertCell(4) //button
//     cell1.innerHTML = data.results.results[i].user1
//     cell2.innerHTML = data.results.results[i].user2
//     cell3.innerHTML = data.results.results[i].DATE
//     cell4.innerHTML = data.results.results[i].Time
//     let greeting = '<a href="https://rasts.se/pages/timetable.php?greeting='
//     + data.results[i].result_id + ',' + event_id + '"' + '>' + 'See detailed results</a>'
//     console.log(greeting)
//     cell5.innerHTML = greeting
//   }}
//   //GetChecks(result_id, event_id)
// }

async function timetable_link_func(){
  const urlParams = new URLSearchParams(window.location.search);
  event_id = urlParams.get("event_id");
  result_id = urlParams.get("result_id")
  GetChecks(result_id, event_id)
}
