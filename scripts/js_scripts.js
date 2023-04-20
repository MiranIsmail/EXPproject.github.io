var BASE_ULR = "https://rasts.se/api/";

window.onload = function () {};

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
  load_image(data["pimage"]);

  let container = document.getElementById("myTableContainerResults");
  let myTable = await generate_user_results();
  container.appendChild(myTable);
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
    var blob = await image_to_blob(document.getElementById("send_image"));
    parameters["pimage"] = await blobToBase64(blob);
  }

  for (const [key, value] of Object.entries(parameters)) {
    console.log(key, value);
    if (!value) {
      delete parameters[key];
    }
  }
  console.log(parameters);

  const response = await fetch(BASE_ULR + "Account", {
    method: "PATCH",
    headers: {
      "Content-Type": "application/json",
      Authorization: get_cookie("auth_token"),
    },
    body: JSON.stringify(parameters),
  });

  location.href = "../pages/profile.php";
}

async function generate_user_results() {
  const response = await fetch(
    BASE_ULR + "Results/?token=" + get_cookie("auth_token"),
    {
      method: "GET",
    }
  );
  const data = await response.json();

  let table = document.createElement("table");
  table.setAttribute("class", "table");

  // create table header row
  let headerRow = document.createElement("tr");
  for (let key in await data.results.results[0]) {
    let headerCell = document.createElement("th");
    headerCell.textContent = key;
    headerRow.appendChild(headerCell);
  }
  table.appendChild(headerRow);

  // create table rows
  for (let i = 0; i < (await data.results.results.length); i++) {
    let row = document.createElement("tr");
    for (let key in await data.results.results[i]) {
      let cell = document.createElement("td");
      cell.textContent = await data.results.results[i][key];
      console.log(await data.results.results[i][key]);
      row.appendChild(cell);
    }
    table.appendChild(row);
  }

  return table;
}

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
  document.getElementById("event_name_colapse").innerHTML = await data["event_name"];
  document.getElementById("event_name").innerHTML = await data["event_name"];
  document.getElementById("event_sport").innerHTML = await data["sport"];
  document.getElementById("event_sdate").innerHTML = await data["startdate"];
  document.getElementById("event_edate").innerHTML = await data["enddate"];
  document.getElementById("event_org").innerHTML = await data["username"];
  document.getElementById("event_desc").innerHTML = await data["description"];
  console.log(await data["description"]);
  load_image_event(data["eimage"]);

  let container = document.getElementById("myTableContainer");
  let myTable = await generate_event_results(event_id);
  container.appendChild(myTable);


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

async function CreateTrack(track_input, start_station, end_station) {
  //var track_name = document.getElementById("InputTrackName")
  await fetch(BASE_ULR + "Track", {
    method: "POST",
    body: JSON.stringify({
      track_name: track_input,
      start_station: start_station,
      end_station: end_station,
    }),
    headers: { "Content-Type": "application/json; charset=UTF-8" },
  });
}

async function CreateCheckpoint(
  track_name,
  station_id,
  next_id,
  distance,
  terrain,
  lng,
  lat
) {
  await fetch(BASE_ULR + "Checkpoint", {
    method: "POST",
    body: JSON.stringify({
      track_name: track_name,
      station_id: station_id,
      next_id: next_id,
      next_distance: distance,
      terrain: terrain,
      longitude: lng,
      latitude: lat,
    }),
    headers: { "Content-Type": "application/json; charset=UTF-8" },
  });
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
    var blob = await image_to_blob(document.getElementById("send_image"));
    parameters["eimage"] = await blobToBase64(blob);
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

// Function to generate table
async function generate_event_results(event_id) {
  const response = await fetch(BASE_ULR + "Results/?event_id=" + event_id, {
    method: "GET",
  });
  const data = await response.json();

  let table = document.createElement("table");
  table.setAttribute("class", "table");

  // create table header row
  let headerRow = document.createElement("tr");
  for (let key in await data.results[0]) {
    let headerCell = document.createElement("th");
    headerCell.textContent = key;
    headerRow.appendChild(headerCell);
  }
  table.appendChild(headerRow);

  // create table rows
  for (let i = 0; i < (await data.results.length); i++) {
    let row = document.createElement("tr");
    for (let key in await data.results[i]) {
      let cell = document.createElement("td");
      cell.textContent = await data.results[i][key];
      console.log(await data.results[i][key]);
      row.appendChild(cell);
    }
    table.appendChild(row);
  }

  return table;
}

function register_on_event(event_id) {
  var parameters = {};
  parameters["chip_id"] = document.getElementById("send_chip").value;
  parameters["event_id"] = event_id;
  const response = fetch(BASE_ULR + "Registration", {
    method: "POST",
    body: JSON.stringify(parameters),
  });
  alert("Chip has been Registerd");
}

async function get_chip() {
  const response = await fetch(BASE_ULR + "Account", {
    method: "GET",
    headers: { Authorization: get_cookie("auth_token") },
  });
  const data = await response.json();

  document.getElementById("chip_id_display").value = await data["chip_id"];
}

async function email_to_forgot_password() {
  var email = document.getElementById("email").value;
  const response = await fetch("../api/src/TokenGateway.php", {
    method: "PATCH",
    body: JSON.stringify({ email: email }),
    headers: { "Content-Type": "application/json" },
  });

  if (response.ok) {
    alert("Email was sent successfully!");
  } else {
    alert("There was an error sending the email!");
    alert(response);
  }
}
