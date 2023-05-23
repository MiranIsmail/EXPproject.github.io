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