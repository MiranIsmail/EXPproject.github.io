var BASE = "rasts.se/api/"

window.onload = function () {
  include_HTML()
};

const get_cookie = (name) => (
  document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || ''
)

function calculate_age(date) {
  if(date != null){

  var today = new Date();
  var birthDate = new Date(date);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;}

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

  fetch("https://rasts.se/api/Account", {
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

function update_account() {
  let xbday = document.getElementById('fetch_bday').value;
  let xheight = document.getElementById('fetch_height').value;
  let xweight = document.getElementById('fetch_weight').value;

  fetch("https://rasts.se/api/Account", {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ "first_name": xfirst_name, "last_name": xlast_name, "birthDate": xbday, "height": xheight, "weight": xweight })
  })

    .then(response => {
      var test = response.json()
      console.log(test)
    })
    .then((data) => { console.log(data) })
    .catch(error => console.error(error))
  location.href = '../pages/profile.html'
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

async function logIn() {

  let femail = document.getElementById('fetchEmail').value;
  let fpword = document.getElementById('fetchPword').value;
  const response = await fetch("https://rasts.se/api/Login", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ "email": femail, "password": fpword })
  })
  const data = await response.json()
  document.cookie = `auth_token=${await data["auth_token"]}`;
  console.log("test")
  location.href = '../pages/profile.html'
}



async function get_user_info() {

  const response = await fetch("https://rasts.se/api/Account", {
    method: 'GET',
    headers: { 'Authorization': get_cookie('auth_token') }
  })
  const data = await response.json()
  img.src = URL.createObjectURL(0x89504e470d0a1a0a0000000d494844520000030c000003040806000000122ca216000030eb7a5458745261772070726f66696c6520747970652065786966000078daad9c697265b98d85ff7315b5048e20b91c8e11bd835e7e7f874f4ae750e57044dbe94a29a537dc4b006700c1e7cefffecf757ffdf557083e46974b6dd6cd3cffcb3df738f8a6f9cfffc6fb3bf8fcfefefc6ff9f4f5d35f7eeef8c7e717911fe9bbcfbf7cb3cfd7f0fdf3ef17fafa1a06df959f5ea8adaf5fcc5f7fd1f3e76b6cbfbdd0d71b255d51e49bfdf542fdeb8552fcfc227cbdc0f8dc96b7deeacfb730cfe7ebd7f33fcbd0746bfcb5ce7b6d1fbedeedf77fe7caeaedc20f538c27f163fe8e297f2e20e9bfe0d2e017e1fddde2fbd1fb3ef3b74fdf57c282fcdd3af99faecafd1195efef7e8bcafdbe97df8292ecf308c70f7e5d4cfbf1f56f7f1ecadf2fbe7b4bfcd33ba7f5f55dfcf5e76bc6fefbed7cff77ef6eeedef3b9bb918d25b5af9bfabec5f71d0f9c2c797a4f33fe54fe2b7c5fdf9fce9fe6c8de45c837193bf9b3420f91b0dc90c30e23dc70ded715169798e38995af312ea2a29fb554638f2b79f722c49f70634d3dedd488dc22bc899fc61fd712defbf6f7762b34de78071e19032f16784674faebbff1e71f5fe85ea53c85dd5ee8c38b4f884a542e4391d3);
  concole.log(blob)
  console.log(img)
  document.getElementById("profileImage").innerHTML = img
  document.getElementById("profileName").innerHTML = await data["first_name"] + " " + await data["last_name"]
  document.getElementById("profile_age").innerHTML = await calculate_age(data["birthdate"])
  document.getElementById("profile_length").innerHTML = await data["height"]
  document.getElementById("profile_weight").innerHTML = await data["weight"]
  document.getElementById("profile_image").innerHTML = NULL

}


async function edit_user_info() {

  let first_name = document.getElementById('send_f_name').value;
  let last_name = document.getElementById('send_l_name').value;
  let birth_date = document.getElementById('send_bday').value;
  let height = document.getElementById('send_height').value;
  let weight = document.getElementById('send_weight').value;
  let pimage = document.getElementById('send_image');


  await image_to_blob(pimage)
    .then(blob => {
      console.log(blob)
    })
    .catch(error => {
      console.log("909")
    });

  console.log(first_name)
  console.log(last_name)
  console.log(birth_date)
  console.log(height)
  console.log(weight)

}

async function generate_table() {
  /**/
  res = await fetch(BASE + "event?key=host_email&search_text=")

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
