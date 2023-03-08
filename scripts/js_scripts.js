var BASE = "http://193.11.187.227:5000/"

window.onload = function() {
  include_HTML()
};


function createAccount() {
  let xemail = document.getElementById('email').value;
  let xfirst_name = document.getElementById('fname').value;
  let xlast_name = document.getElementById('lname').value;
  let xpassword = document.getElementById('pword').value;


  fetch(BASE + 'account', {
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
      // "Content-Type": "multipart/form-data",
    },
    method: 'PUT',
    body: JSON.stringify({ 'first_name': xfirst_name, 'last_name': xlast_name, 'password': xpassword, 'email': xemail })
  }).then(response => response.json())
  location.href = "../pages/signin_first_time.html"
}


function logIn() {
  let femail = document.getElementById('fetchEmail').value;
  let fpword = document.getElementById('fetchPword').value;

  fetch(BASE + 'account?email=' + femail + "&password=" + fpword)
    .then((response) => response.json())
    .then((data) => {
      document.cookie = "token=" + data[1]
    });

    location.href = "../pages/profile.html"
}


function get_user_info() {
  let token = document.cookie.split('=');
  /**/

  fetch(BASE + 'get_info?token=' + token[1])
    .then((response) => response.json())
    .then((data) => {
      var dataString = String(data).split(',')
      document.getElementById("profileName").innerHTML = dataString[3]
      document.getElementById("profile_age").innerHTML = dataString[8]
      document.getElementById("profile_length").innerHTML = dataString[6]
      document.getElementById("profile_weight").innerHTML = dataString[7]
    });
}

function calculate_age(date) {
  var today = new Date();
  var birthDate = new Date(date);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
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
  console.log(z.length)

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

let startDate = document.getElementById('startDate')
let endDate = document.getElementById('endDate')
let b_day = document.getElementById('b_day')

startDate.addEventListener('change',(e)=>{
  let startDateVal = e.target.value
  document.getElementById('startDateSelected').innerText = startDateVal
})

endDate.addEventListener('change',(e)=>{
  let endDateVal = e.target.value
  document.getElementById('endDateSelected').innerText = endDateVal
})

b_day.addEventListener('change',(e)=>{
  let b_day_val = e.target.value
  document.getElementById('b_day_selected').innerText = b_day_val
})

/* EVENT PAGE*/



/*Event card */
// Create a div element for the card
