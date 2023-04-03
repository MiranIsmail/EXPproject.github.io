var BASE_ULR = "https://rasts.se/api/"

window.onload = function () {
  include_HTML()
};

const get_cookie = (name) => (
  document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || ''
)

function blobToBase64(blob) {
  return new Promise((resolve, _) => {
    const reader = new FileReader();
    reader.onloadend = () => resolve(reader.result);
    reader.readAsDataURL(blob);
  });
}


function calculate_age(date) {
  if (date != null) {

    var today = new Date();
    var birthDate = new Date(date);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    return age;
  }

  return "missing"

}

function image_to_blob(inputElement) {
  const file = inputElement.files[0];
  if (!file) {
    return Promise.reject(new Error('No file selected'));
  }
  const reader = new FileReader();
  reader.readAsArrayBuffer(file);
  return new Promise((resolve, reject) => {
    reader.onload = () => {
      const blob = new Blob([reader.result], { type: file.type });
      resolve(blob);
    };
    reader.onerror = () => {
      reject(new Error('Error reading file'));
    };
  });
}

function createAccount() {
  let xemail = document.getElementById('email').value;
  let xfirst_name = document.getElementById('fname').value;
  let xlast_name = document.getElementById('lname').value;
  let xpassword = document.getElementById('pword').value;

  fetch(BASE_ULR + "Account", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ "email": xemail, "first_name": xfirst_name, "last_name": xlast_name, "password": xpassword })
  })

    .then(response => {
      var test = response.json()
      console.log(test)
    })
    .then((data) => { console.log(data) })
    .catch(error => console.error(error))
}


function fill_org_form() {
  // Get all required input fields
  const requiredFields = document.querySelectorAll('input[required]')

  // Check if all required fields are filled in and valid
  const allFieldsValid = Array.from(requiredFields).every(field => field.checkValidity());

  if (allFieldsValid) {
    // get references to form elements
    const orgNameInput = document.getElementById('org_name');
    const orgCountryInput = document.getElementById('org_country');
    const orgEmailInput = document.getElementById('org_email');
    const userEmailInput = document.getElementById('user_email');

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
  let femail = document.getElementById('fetchEmail').value;
  let fpword = document.getElementById('fetchPword').value;
  const response = await fetch(BASE_ULR + "Token", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ "email": femail, "password": fpword })
  })
  const data = await response.json()
  document.cookie = `auth_token=${await data["auth_token"]}`;
  location.href = '../pages/profile.html'
}

async function log_out() {

  const response = await fetch(BASE_ULR + "Token", {
    method: 'PATCH',
    headers: { 'Authorization': get_cookie('auth_token') }
  })
  const data = await response.json()
  console.log(await data)
  location.href = '../pages/'
}

function load_image(indata) {
  var img = document.createElement("img")
  img.setAttribute("id", "profile_image")
  img.setAttribute("class", "img-fluid d-block")
  img.src = indata
  var src = document.getElementById("profile_box")
  src.appendChild(img);
}

async function get_user_info() {

  const response = await fetch(BASE_ULR + "Account", {
    method: 'GET',
    headers: { 'Authorization': get_cookie('auth_token') }
  })
  const data = await response.json()

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("profileName").innerHTML = await data["first_name"] + " " + await data["last_name"]
  document.getElementById("profile_age").innerHTML = await calculate_age(await data["birthdate"])
  document.getElementById("profile_length").innerHTML = await data["height"]
  document.getElementById("profile_weight").innerHTML = await data["weight"]
  load_image(data["pimage"])
}


async function edit_user_info() {
  var parameters = {}
  parameters["first_name"] = document.getElementById('send_f_name').value
  parameters["last_name"] = document.getElementById('send_l_name').value
  parameters["birthdate"] = document.getElementById('send_bday').value
  parameters["height"] = document.getElementById('send_height').value
  parameters["weight"] = document.getElementById('send_weight').value

  if (document.getElementById("send_image").files.length != 0) {
    var blob = await image_to_blob(document.getElementById('send_image'))
    parameters["pimage"] = await blobToBase64(blob)
  }

  for (const [key, value] of Object.entries(parameters)) {
    console.log(key, value);
    if (!value) {
      delete parameters[key];
    }
  }
  console.log(parameters);

  const response = await fetch(BASE_ULR + "Account", {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json', 'Authorization': get_cookie('auth_token') },
    body: JSON.stringify(parameters)
  })

  location.href = '../pages/profile.html'
}

async function generate_table() {
  /**/
  res = await fetch(BASE_ULR + "event?key=host_email&search_text=")

  text = await res.json()
  var dataString = String(text[1].replace(/[(')]/g, '').replace(/datetime.date/g, '')).split(',')
  console.log(dataString)
  let amount_event = dataString.length / 9


  const tbl = document.createElement("table");
  tbl.setAttribute("id", "profile_table")
  const tbl_head = document.createElement("thead");
  const row = document.createElement("tr");
  const cellText1 = document.createTextNode(`Tävling`);
  const cellText2 = document.createTextNode(`Organisatör`);
  const cellText3 = document.createTextNode(`Sport`);
  const cellText4 = document.createTextNode(`StartDatum`);
  const cellText5 = document.createTextNode(`SlutDatum`);

  const tblBody = document.createElement("tbody");

  // creating all cells
  for (let i = 0; i < amount_event; i++) {
    var startdate = dataString[i * 9 + 3].trim() + "-" + dataString[i * 9 + 4].trim() + "-" + dataString[i * 9 + 5].trim()
    var enddate = dataString[i * 9 + 6].trim() + "-" + dataString[i * 9 + 7].trim() + "-" + dataString[i * 9 + 8].trim()

    // creates a table row
    const row = document.createElement("tr");

    for (let j = 0; j < 5; j++) {
      // Create a <td> element and a text node, make the text
      // node the contents of the <td>, and put the <td> at
      // the end of the table row
      const cell = document.createElement("td");
      let cellText = ''
      if (j < 3) {
        cellText = document.createTextNode(dataString[i * 9 + j]);
      }
      else if (j == 3) {
        cellText = document.createTextNode(startdate);
      }
      else {
        cellText = document.createTextNode(enddate);

      }

      cell.appendChild(cellText);
      row.appendChild(cell);
    }

    // add the row to the end of the table body
    tblBody.appendChild(row);
  }

  // put the <tbody> in the <table>
  tbl.appendChild(tbl_head)
  tbl.appendChild(tblBody);
  // appends <table> into <body>
  document.getElementById("event").appendChild(tbl)

  // sets the border attribute of tbl to '2'
  tbl.setAttribute("border", "4");
  tbl.setAttribute("class", "mx-auto w-75")
}


function search_event() {
  let input = document.getElementById('searchQueryInput').value
  input = input.toLowerCase();
  let x = document.getElementsByClassName('card-title');
  let xcard = document.getElementsByClassName('eventCards');

  for (i = 0; i < x.length; i++) {
    if (!xcard[i].innerHTML.toLowerCase().includes(input)) {
      xcard[i].style.display = "none";
    }
    else {
      xcard[i].style.display = "list-item";
    }
  }
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
      console.log(file)
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) { element.innerHTML = this.responseText; }
          if (this.status == 404) { element.innerHTML = "Page not found."; }
          /* Remove the attribute, and call this function once more: */
          element.removeAttribute("include-html");
          include_HTML();
        }
      }
      xhttp.open("GET", file, true);
      xhttp.send();
      /* Exit the function: */
      return;
    }
  }
}


/*CREATE EVENT */

function create_event() {
  let startDate = document.getElementById('startDate')
  let endDate = document.getElementById('endDate')
  let b_day = document.getElementById('b_day')

  startDate.addEventListener('change', (e) => {
    let startDateVal = e.target.value
    document.getElementById('startDateSelected').innerText = startDateVal
  })

  endDate.addEventListener('change', (e) => {
    let endDateVal = e.target.value
    document.getElementById('endDateSelected').innerText = endDateVal
  })

  b_day.addEventListener('change', (e) => {
    let b_day_val = e.target.value
    document.getElementById('b_day_selected').innerText = b_day_val
  })
}



/* EVENT PAGE*/
async function get_event_info(event_id) {

  const response = await fetch(BASE_ULR+"Event", {
    method: 'GET',
    body: JSON.stringify({"event_id": event_id })
  })
  const data = await response.json()

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("event_sport").innerHTML = await data["sport"]
  document.getElementById("event_sdate").innerHTML = await data["start_date"]
  document.getElementById("event_edate").innerHTML = await data["end_date"]
  document.getElementById("event_org").innerHTML = await data["host_organization"]
  // load_image(data["pimage"])
}