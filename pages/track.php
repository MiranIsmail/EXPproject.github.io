<!DOCTYPE html>
<html lang="en">

<head>
  <title>Track - Rasts</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css">
  <link rel="stylesheet" href="../styles/login_and_signup.css">
  <link rel="stylesheet" href="../styles/google_maps_api.css">
  <script src="https://kit.fontawesome.com/dbe6ff92a1.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</head>


<body>
  <?php include '../assets/navbar.php'; ?>
  <div class="image_div">
    <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run">
  </div>
  <div class="section content_container">
    <h1>Create your own track</h1>
    <div class="form-group">
      <div class="form-group form_group_style mx-auto container">
        <p>Here you can create tracks that can then be accesed during events</p>
        <p>Make sure that all your checkpoints are functional and that their ID is visable</p>
        <label for="InputTrackName" class="clear_text">Track name</label>
        <input type="text" class="form-control" id="InputTrackName" placeholder="My Track">
      </div>
      <!-- Include the Bootstrap 5 CSS file -->
      <!-- Create a table with Bootstrap 5 classes -->
      <div class="form-group form_group_style mx-auto">
        <p>Start by adding the first section!</p>
        <div class="container opacity_background" id="track_input">

          <div class="row">
            <div class="col-sm-2">
              <label for="numberInput" id="numberInput" class="form-label fw-bold">ID</label>
              <input type="number" class="form-control" id="usr" min="100" max="200" required>
            </div>

            <div class="col-sm-2">
              <label for="numberInput" id="dist" class="form-label fw-bold">Distance</label>
              <input type="text" class="form-control" placeholder="15" name="distance">
            </div>
            <div class="col btn-group-vertical">
              <!-- Button to Open the Modal -->
              <label for="button" id="pin_button" class="form-label fw-bold">Location</label>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-map-location-dot"></i>

              </button>
            </div>

            <!-- The Modal -->
            <div class="modal" id="myModal">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header text-center">
                    <h4 class="modal-title w-100">Map</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <div id="map"></div>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteMarkers()">Delete</button>
                    <button type="button" class="btn btn-success" disabled id="save_btn" onclick="send_coords()" data-bs-toggle="modal">Save</button>
                  </div>

                </div>
              </div>
            </div>
            <div class="col">
              <label for="dropdown" id="terrain_dropdown" class="form-label fw-bold">Terrain</label>
              <div class="dropdown" name="terrain">

                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonTerrain1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-person-running"></i>
                  Terrain
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButtonTerrain1">
                  <li><a class="dropdown-item" onclick='select("Water")'>Water</a></li>
                  <li><a class="dropdown-item" onclick='select("Land")'>Land</a></li>
                  <li><a class="dropdown-item" onclick='select("Mixed")'>Mixed</a></li>
                </ul>
              </div>
            </div>
            <div class="col btn-group-vertical">
              <label for="delete_button" class="form-label fw-bold">Option</label>
              <button class="btn btn-danger" onclick="deleteRow(this.parentNode.parentNode)" name="delete_button"><i class="fa-solid fa-trash"></i></button>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="mb-3">
            <button id="add_button" class="btn btn-secondary" onclick="addRow()"><i class="fa-regular fa-plus"></i></button>
          </div>
          <div class="">
            <button type="submit" button id="submit_button" class="btn btn-primary" role="button" disabled onclick=submit()>Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <?php include '../assets/footer.php'; ?>
</body>

<script>
  function select(option) {
    // Get the button element and the dropdown menu element
    const button = document.querySelector('.dropdown-toggle');
    const dropdown = document.querySelector('.dropdown-menu');

    // Set the button text to the selected option
    button.textContent = option;

    // Change the button color based on the selected option
    switch (option) {
      case 'Water':
        button.style.backgroundColor = 'blue';
        break;
      case 'Land':
        button.style.backgroundColor = 'green';
        break;
      case 'Mixed':
        button.style.backgroundColor = 'turquoise';
        break;
      default:
        button.style.backgroundColor = '';
        break;
    }

    // Close the dropdown menu
    dropdown.classList.remove('show');
  }

  class Section {
    constructor(id, distance, terrain) {
      this.station_id = id;
      this.next_distance = distance;
      this.terrain = terrain;
      this.next_id = null;
    }
  }

  function save(row) {
    i = i + 1

    var id_start = row.querySelector("[name='id']").value;
    var distance = row.querySelector("[name='distance']").value;
    var terrain = row.querySelector("[name='terrain']").value;
    console.log(id_start)
    var index = row.rowIndex - 1;

    //If the input is empty, do nothing
    if (id_start == "" || distance == "" || terrain == "") {
      return;
    }

    row.querySelector("[name='usr']").readOnly = true;
    row.querySelector("[name='distance']").readOnly = true;
    row.querySelector("[name='terrain']").readOnly = true;

    var saveBtn = row.querySelector("[name='save_button']");
    console.log(saveBtn)
    // Change the save button to an edit button
    saveBtn.innerHTML = "Edit";
    saveBtn.onclick = function() {
      edit(row);
    }
    row.style.backgroundColor = "#ccc";
    //If the data already exists, update it
    if (data.length && typeof data[index] != "undefined") {
      data[index].station_id = id_start;
      data[index].next_distance = distance;
      data[index].terrain = terrain;
      //If the row is not the first row, update the previous row's next_id
      if (index > 0) {
        data[index - 1].next_id = id_start;
      }
    } else {
      var section = new Section(id_start, distance, terrain);

      if (data.length > 0) {
        data[data.length - 1].next_id = id_start;
      }
      data.push(section);
    }
  }

  function edit(row) {
    i = index
    row.querySelector("[name='id']").readOnly = false;
    row.querySelector("[name='distance']").readOnly = false;
    row.querySelector("[name='terrain']").readOnly = false;


    var saveBtn = row.querySelector("[name='save_button']");
    // Change the button to a save button
    saveBtn.innerHTML = "Save";
    saveBtn.onclick = function() {
      save(row);
    }
    row.style.backgroundColor = "#fff";
  }

  function addRow() {
    // Get the existing grid container
    const gridContainer = document.querySelector(".grid-container");

    // Create a new row element and add the HTML string you provided
    const newRow = document.createElement("div");
    newRow.classList.add("row");
    newRow.innerHTML = `<div class="col-sm-2">
                      <label for="numberInput" id="numberInput" class="form-label fw-bold">ID</label>
                      <input type="number" class="form-control" id="usr" min="100" max="200" required>
                    </div>
                    
                    <div class="col-sm-2">
                      <label for="numberInput" id="dist" class="form-label fw-bold">Distance</label>
                      <input type="text" class="form-control" placeholder="15" name="distance">
                    </div>
                    <div class="col btn-group-vertical">
                      <!-- Button to Open the Modal -->
                      <label for="button" id="pin_button" class="form-label fw-bold">Location</label>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-map-location-dot"></i>
                        
                      </button>
                    </div>
                  
                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                  
                          <!-- Modal Header -->
                          <div class="modal-header text-center">
                            <h4 class="modal-title w-100">Map</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                  
                          <!-- Modal body -->
                          <div class="modal-body">
                              <div id="map"></div>
                          </div>
                  
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Close</button>
                            <button type="button" class="btn btn-danger" onclick="deleteMarkers()" >Delete</button>
                            <button type="button" class="btn btn-success" disabled id="save_btn" onclick="send_coords()" data-bs-toggle="modal">Save</button>
                          </div>
                  
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <label for="dropdown" id="terrain_dropdown" class="form-label fw-bold">Terrain</label>
                      <div class="dropdown" name="terrain">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonTerrain1" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa-solid fa-person-running"></i>
                          Terrain
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButtonTerrain1">
                          <li><a class="dropdown-item" onclick='select("Water")'>Water</a></li>
                          <li><a class="dropdown-item" onclick='select("Land")'>Land</a></li>
                          <li><a class="dropdown-item" onclick='select("Mixed")'>Mixed</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col btn-group-vertical">
                      <label for="delete_button" class="form-label fw-bold">Option</label>
                      <button class="btn btn-danger" onclick="deleteRow(this.parentNode.parentNode)" name="delete_button"><i class="fa-solid fa-trash"></i></button>
                    </div>`
    // Add row to grid
    var myGrid = document.getElementById("track_input");
    myGrid.appendChild(newRow);
  }

  function deleteRow(row) {
    const index = row.parentNode.parentNode.rowIndex;
    document.getElementById("myTable").deleteRow(index);
  }


  function submit() {
    var table = document.getElementById("sections_table");
    var name = document.getElementById("InputTrackName").value;
    var start = data[0].station_id
    var end = data[data.length - 1].station_id
    var checkpoints = data.slice(1, data.length - 1)
    var track = {
      track_name: name,
      start_station: start,
      end_station: end
    }
    //download a txt file with the checkpoints
    var checkpoint_file = new File([JSON.stringify(checkpoints)], "checkpoints.txt", {
      type: "text/plain;charset=utf-8"
    });
    var track_file = new File([JSON.stringify(track)], "track.txt", {
      type: "text/plain;charset=utf-8"
    });

    window.location.href = '../eventcreate.php';
  }


  let map;
  let markers_list = [];
  const btn = document.getElementById('save_btn')

  function init_map() {
    const bth_coords = {
      lat: 56.179475,
      lng: 15.595062
    };
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: bth_coords,
      mapTypeId: "terrain",
    });
    // This event listener will call add_marker() when the map is clicked.
    map.addListener("click", (event) => {
      setMapOnAll(null)
      const check_point_id = document.getElementById('usr').value
      add_marker(event.latLng, check_point_id);
    });
  }

  // Adds a marker to the map and push to the array.
  function add_marker(position, check_point_id) {
    const marker = new google.maps.Marker({
      position,
      map,
      label: check_point_id
    });

    markers_list.push(marker);
    btn.disabled = false;

  }

  // Sets the map on all markers in the array.
  function setMapOnAll(map) {
    for (let i = 0; i < markers_list.length; i++) {
      markers_list[i].setMap(map);
    }
  }

  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    setMapOnAll(null);
    markers_list = [];
    btn.disabled = true;
  }
  //figure out how to confirm
  function send_coords() { //needs fixing

    for (let index = 0; index < markers_list.length; index++) {
      let object_string = JSON.stringify(markers_list[index])
      //data base call
    }

    window.init_map = init_map;
  }
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkY5KKVjLNfTPCAX17XbClpOpfTQd0cFM&callback=init_map">
</script>

</html>