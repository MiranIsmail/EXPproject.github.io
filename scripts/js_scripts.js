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
  open("Login.html")
}


function logIn() {
  let femail = document.getElementById('fetchEmail').value;
  let fpword = document.getElementById('fetchPword').value;

  fetch(BASE + 'account?email=' + femail + "&password=" + fpword)
    .then((response) => response.json())
    .then((data) => {
      document.cookie = "token=" + data[1]
    });

  open("profile.html")
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
  var data_string = "test"
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


function load_events() {
  var event_text = "New race courses since 2022. Utö is where the whole swimrun movement started and where the late night bet which became ÖTILLÖ was made. It is an island in the southern part of the Stockholm archipelago almost 90 minutes from Stockholm. This is Swimrun heaven!"
  var event_name = "ÖTILLÖ SWIMRUN UTÖ"
  var event_date = "17 JUNE 2023"
  var event_image = "../images/eventimg/otillo.jpg"
  document.cookie = event_text
  document.cookie = event_name
  document.cookie = event_date
  document.cookie = event_image
}


/*Event card */
// Create a div element for the card
function generate_card(){
  // var value = document.cookie;
  // var value = document.cookie;
  // var value = document.cookie;
  // var value = document.cookie;
  var event_text = "New race courses since 2022. Utö is where the whole swimrun movement started and where the late night bet which became ÖTILLÖ was made. It is an island in the southern part of the Stockholm archipelago almost 90 minutes from Stockholm. This is Swimrun heaven!"
  var event_name = "ÖTILLÖ SWIMRUN UTÖ"
  var event_date = "17 JUNE 2023"
  var event_image = "../images/eventimg/otillo.jpg"




  var cardDiv = document.createElement('div');
  cardDiv.classList.add('card', 'event_left_box', 'mb-3', 'drop_shadow');
  cardDiv.style.listStyle = 'none';

  // Create a div element for the row
  var rowDiv = document.createElement('div');
  rowDiv.classList.add('row', 'g-1');

  // Create a div element for the image column
  var imgColDiv = document.createElement('div');
  imgColDiv.classList.add('col-md-12');

  // Create an img element for the image
  var img = document.createElement('img');
  img.src = event_image;
  img.classList.add('img-fluid', 'rounded-start');
  img.alt = '...';

  // Append the image element to the image column
  imgColDiv.appendChild(img);

  // Create a div element for the card body column
  var cardBodyColDiv = document.createElement('div');
  cardBodyColDiv.classList.add('col-md-12');

  // Create a div element for the card body
  var cardBodyDiv = document.createElement('div');
  cardBodyDiv.classList.add('card-body', 'card_link');

  // Create a h3 element for the card title
  var cardTitle = document.createElement('h3');
  cardTitle.classList.add('card-title');
  cardTitle.textContent = event_name;

  // Create a h5 element for the card text
  var cardText = document.createElement('h5');
  cardText.classList.add('card-text');
  cardText.textContent = event_date;

  // Create a div element for the text section
  var textDiv = document.createElement('div');

  // Create a p element for the short text
  var shortText = document.createElement('p');
  var shortTextSpan = document.createElement('span');
  shortTextSpan.id = 'short_text';
  shortText.appendChild(shortTextSpan);

  // Create a div element for the longer text section
  var moreTextDiv = document.createElement('div');
  moreTextDiv.classList.add('more-text');
  moreTextDiv.style.display = 'none';

  // Create a p element for the long text
  var longText = document.createElement('p');
  var longTextSpan = document.createElement('span');
  longTextSpan.id = 'long_text';
  longText.appendChild(longTextSpan);

  // Append the short and long text elements to their respective containers
  textDiv.appendChild(shortText);
  moreTextDiv.appendChild(longText);

  // Append the text and button elements to the card body
  cardBodyDiv.appendChild(cardTitle);
  cardBodyDiv.appendChild(cardText);
  cardBodyDiv.appendChild(textDiv);
  cardBodyDiv.appendChild(moreTextDiv);

  // Create a button element for the "Show More" button
  var showMoreBtn = document.createElement('button');
  showMoreBtn.classList.add('show-more-btn');
  showMoreBtn.textContent = 'Show More';

  // Add an event listener to the "Show More" button to toggle the visibility of the longer text section
  showMoreBtn.addEventListener('click', function() {
    if (moreTextDiv.style.display === 'none') {
      moreTextDiv.style.display = 'block';
      showMoreBtn.textContent = 'Show Less';
    } else {
      moreTextDiv.style.display = 'none';
      showMoreBtn.textContent = 'Show More';
    }
  });

  // Append the button element to the card body
  cardBodyDiv.appendChild(showMoreBtn);

  // Append the image
  rowDiv.appendChild(imgColDiv);

  // Append the card body column to the row
  rowDiv.appendChild(cardBodyColDiv);

  // Append the row to the card
  cardDiv.appendChild(rowDiv);

  // Append the card to the document body
  document.body.appendChild(cardDiv);
}
