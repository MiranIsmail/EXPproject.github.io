async function get_chip() {
  const response = await get_user_details_endpoint(get_cookie("auth_token"));
  const data = await response.json();
  console.log(data["chip_id"])
  document.getElementById("chip_id_display").value = await data["chip_id"];
}

async function generate_event_results() {
  const urlParams = new URLSearchParams(window.location.search);
  event_id = urlParams.get("event_id");

  const response = await get_event_results_endpoint(event_id);
  const data = await response.json();

  if (data.results) {
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
      link_button.onclick = function () {
        window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
      }
      cell1.setAttribute("class", "no_padding_vert")
      cell2.setAttribute("class", "no_padding_vert")
      cell3.setAttribute("class", "no_padding_vert")
      cell4.setAttribute("class", "no_padding_vert")
      cell5.setAttribute("class", "no_padding");
      cell5.appendChild(link_button)

    }
  }
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

async function get_event_info(event_id) {
  const response = await get_event_endpoint(event_id)
  const data = await response.json();
  console.log(data);
  //Just getting the source from the span. It was messy in JS.
  document.getElementById("event_name_colapse").innerHTML = await data[
    "event_name"
  ];
  document.getElementById("event_id").innerHTML = await data["event_id"];
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
  if (await data["username"] == get_cookie("username")) { 
    btn = document.getElementById("delete_event_button_display")
    btn.classList.remove("d-none")
  }

  generate_event_results()
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
      generate_card_wide_preview(
        event_name,
        "Date: " + start_date + "\n - " + end_date,
        host_name,
        image
      );
    };
    reader.readAsDataURL(imageInput.files[0]); // read the selected file as a data URL
  } else {
    generate_card_wide_preview(
      event_name,
      "Date: " + start_date + "\n - " + end_date,
      host_name,
      image
    );
  }
}

function register_on_event(event_id) {
  var parameters = {};
  parameters["event_id"] = event_id;
  parameters["token"] = get_cookie("auth_token");
  parameters["user2"] = document.getElementById("send_team8").value;
  parameters["chip_id"] = document.getElementById("send_chip").value;

  const response = register_event_endpoint(parameters);

  alert("You have been Registerd");
}

function register_on_event_my(event_id) {
  var parameters = {};
  parameters["event_id"] = event_id;
  parameters["token"] = get_cookie("auth_token");
  parameters["user2"] = document.getElementById("send_team8").value;
  parameters["chip_id"] = document.getElementById("chip_id_display").value;

  const response = register_event_endpoint(parameters);

  alert("You have been Registerd");
}

function generate_card_wide_preview(input_name, input_date, input_text, input_image, input_id) {

  let event_text = input_text
  let event_name = input_name
  let event_date = input_date
  let event_image = input_image
  let event_id = input_id

  // Create a div element for the card
  var cardDiv = document.createElement('div');
  cardDiv.classList.add('card', 'mb-3', 'drop_shadow', "w-75", "mx-auto", "border-0");
  cardDiv.style.listStyle = 'none';

  // Create a div element for the row
  var rowDiv = document.createElement('div');
  rowDiv.classList.add('row', 'g-1');

  // Create a div element for the image column
  var imgColDiv = document.createElement('div');
  imgColDiv.classList.add('col-lg-4');

  // Create an img element for the image
  var img = document.createElement('img');
  img.src = event_image;
  img.classList.add('img-fluid', 'rounded_style', "card_image_events");
  img.alt = 'one of our events';

  // Append the image element to the image column
  imgColDiv.appendChild(img);

  // Create a div element for the card body column
  var cardBodyColDiv = document.createElement('div');
  cardBodyColDiv.classList.add('col-lg-8');

  // Create a div element for the card body
  var cardBodyDiv = document.createElement('div');
  cardBodyDiv.classList.add('card-body', 'card_link');

  // Create a h3 element for the card title
  var cardTitle = document.createElement('h3');
  cardTitle.classList.add('card-title', 'title-text');
  cardTitle.textContent = event_name;

  // Create a h5 element for the card text
  var cardText = document.createElement('h5');
  cardText.classList.add('card-text', "card-text-content");
  cardText.textContent = event_date;

  // Create a div element for the text section
  var textDiv = document.createElement('div');
  textDiv.classList.add("card-text-content")

  // Create a p element for the short text
  var shortText = document.createElement('p');
  shortText.textContent = event_text.slice(0, 60) + "..."

  // Create a div element for the longer text section
  var moreTextDiv = document.createElement('div');
  moreTextDiv.classList.add('more-text', "card-text-content");
  moreTextDiv.style.display = 'none';


  // Create a p element for the long text
  var longText = document.createElement('p');
  longText.textContent = event_text

  // Append the short and long text elements to their respective containers
  textDiv.appendChild(shortText);
  moreTextDiv.appendChild(longText);

  // Append the text and button elements to the card body
  cardBodyColDiv.appendChild(cardTitle);
  cardBodyColDiv.appendChild(cardText);
  cardBodyColDiv.appendChild(textDiv);
  cardBodyColDiv.appendChild(moreTextDiv);

  // Create a button element for the "Show More" button
  var showMoreBtn = document.createElement('button');
  showMoreBtn.classList.add('show-more-btn');
  showMoreBtn.textContent = 'Show More';

  // Add an event listener to the "Show More" button to toggle the visibility of the longer text section
  showMoreBtn.addEventListener('click', function () {
    if (moreTextDiv.style.display === 'none') {
      moreTextDiv.style.display = 'block';
      shortText.style.display = 'none';
      showMoreBtn.textContent = 'Show Less';
    } else {
      moreTextDiv.style.display = 'none';
      shortText.style.display = 'block';
      showMoreBtn.textContent = 'Show More';
    }
  });

  // Append the button element to the card body
  cardBodyColDiv.appendChild(showMoreBtn);

  // Append the image
  // Append the image column to the row
  rowDiv.appendChild(imgColDiv);

  // Append the card body column to the row

  rowDiv.appendChild(cardBodyColDiv);

  // Append the row to the card
  cardDiv.appendChild(rowDiv);

  // Append the card to the document body
  document.getElementById("event_cards_dynamic").appendChild(cardDiv);

}

async function delete_event() {
  const urlParams = new URLSearchParams(window.location.search);
  const event_id = urlParams.get('event_id');
  const response = await delete_event_endpoint(event_id, get_cookie("auth_token"));
  if (response.status >= 300) {
    alert("Invalid");
  } else {
    location.href = "../pages/profile.php";
  }
}

async function unregister_from_event() {
  const urlParams = new URLSearchParams(window.location.search);
  const event_id = urlParams.get('event_id');
  const response = await delete_registration_endpoint(event_id, get_cookie("auth_token"));
  if (response.status >= 300) {
    alert("Invalid");
  }
}
