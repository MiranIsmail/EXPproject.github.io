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
      <div class="form-group col-md-12 form_group_style mx-auto">
        <p>Start by adding the first section!</p>
        <div class="container" id="track_input">
          <div class="row track_form" id="0">
            <div class="col-sm-2">
              <label for="numberInput" id="numberInput" class="form-label fw-bold">Start ID</label>
              <input type="number" class="form-control" name="StartID" min="100" max="200" placeholder="Ex. 101" required>
            </div>
            <div class="col-sm-2">
              <label for="btn-group" id="Location" class="form-label fw-bold">Start Pin</label>
              <button type="button" class="btn btn-secondary" name="pin" onclick="find_pin_id(event, 'StartID')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
                Pin
              </button>
            </div>
            <div class="col-sm-2">
              <label for="numberInput" id="numberInput" class="form-label fw-bold">End ID</label>
              <input type="number" class="form-control" name="EndID" min="100" max="200" placeholder="Ex. 102" required>
            </div>
            <div class="col-sm-2">
              <!-- Button to Open the Modal -->
              <label for="btn-group" id="Location" class="form-label fw-bold">End Pin</label>
              <button type="button" class="btn btn-secondary" name="pin" onclick="find_pin_id(event, 'EndID')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
                Pin
              </button>
            </div>

            <div class="col-sm-2">
              <label for="numberInput" id="dist" class="form-label fw-bold">Distance</label>
              <input type="number" class="form-control" placeholder="Ex. 15" name="distance">
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
            <div class="col-sm-3">
              <label for="dropdown" id="terrain_dropdown" class="form-label fw-bold">Terrain</label>
              <div class="dropdown" name="terrain">

                <button class="btn btn-secondary dropdown-toggle" type="button" name="Terrain" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-person-running"></i>
                  Terrain
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButtonTerrain1">
                  <li><a class="dropdown-item" onclick='select("Water", event)'>Water</a></li>
                  <li><a class="dropdown-item" onclick='select("Land", event)'>Land</a></li>
                  <li><a class="dropdown-item" onclick='select("Mixed", event)'>Mixed</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-2">
              <label for="delete_button" class="form-label fw-bold">Option</label>
              <button class="btn btn-danger" onclick="deleteRow(this)" name="delete_button"><i class="fa-solid fa-trash"></i>
              Delete
              </button>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="option_background">
            <button id="add_button" button type="button" class="btn btn-secondary" onclick="addRow()">Add another section <i class="fa-regular fa-plus"></i></button>
            <button type="submit" button type="button" button id="submit_button" class="btn btn-primary" role="button" onclick='submit()'>Submit</button>     
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
  // Create template row 
  const template_row = document.getElementById("0")
  const info = template_row.innerHTML

  var i = 0
  function addRow() {
    i = i + 1 
    // Get the existing grid container
    const gridContainer = document.querySelector(".grid-container");
    // Create a new row element and add the HTML string you provided
    const newRow = document.createElement("div");
    newRow.classList.add('row');
    newRow.classList.add('track_form')
    newRow.id = i
    newRow.innerHTML = info
    // Add row to grid
    var myGrid = document.getElementById("track_input");
    myGrid.appendChild(newRow);
  }

  function select(option, event) {
    // Get the button element and the dropdown menu element
    var row = event.target.closest('div')
    var button = row.querySelector('button[name="Terrain"]');
    var dropdown = document.querySelector('.dropdown-menu');
    
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
        button.style.backgroundColor = '#2ac8ab';
        break;
      default:
        button.style.backgroundColor = '';
        break;
    }

    // Close the dropdown menu
    dropdown.classList.remove('show');
  }

  function deleteRow(button) {
    var row = button.parentNode.parentNode;
    row.remove();
  }


  function submit() {
    const rows = document.querySelectorAll('.row');

    let track_name = document.getElementById('InputTrackName').value
    console.log(track_name)
  // Loop through each row
  let i = 0;
  let start_station;
  let end_station;
  const checkpoint_list = [];
  class checkpoint{
    constructor(check_id, distance, terrain, next){
      this.check_id = check_id, this.distance = distance, this.terrain = terrain, this.next = NULL
    }
    UpdateNext(checkpoint_id){
      this.next = checkpoint_id;
    }
  }
    rows.forEach(row => {
      // Get the input fields in the row
      const idInput = row.querySelector('input[id=CheckID]');
      const distanceInput = row.querySelector('input[name=distance]');
      const terrainDropdown = row.querySelector('button[name=Terrain]');
      
      // Get the values of the input fields
      const id = idInput.value;
      const distance = distanceInput.value;
      const terrain = terrainDropdown.textContent;
      let check = new checkpoint(id, distance, terrain, next)
      checkpoint_list[i] = check
      console.log(checkpoint_list[i])
      //console.log(i)
      // Do something with the data
      console.log(`ID: ${id}, Distance: ${distance}, Terrain: ${terrain}`);
      if(i === 0){
        start_station = idInput.value;
      }
      i++;
      end_station = idInput.value;
      CreateTrack(track_name, start_station, end_station);
      for(let i = 0; i < checkpoint_list.length - 1; i++){
        checkpoint_list[i].UpdateNext(checkpoint_list[i+1].check_id)
      }
    });

  }

  let checkpoint_id;
  let pin_button;
  let map;
  let markers_list = [];
  const btn = document.getElementById('save_btn')

  function find_pin_id(event, name) {
    var row = event.target.closest('.row')
    checkpoint_id = row.querySelector(`input[name=${name}]`).value
    pin_button = row.querySelector('button[name=pin]')
  }
  
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
      deleteMarkers();
      add_marker(event.latLng, checkpoint_id);
    });
  }

  // Adds a marker to the map and push to the array.
  function add_marker(position, checkpoint_id) {
    const marker = new google.maps.Marker({
      position,
      map,
      label: checkpoint_id
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
    for (let i = 0; i < markers_list.length; i++) {
      console.log(markers_list[i].getLabel())
      if (markers_list[i].getLabel() == checkpoint_id) {
        console.log("found")
        markers_list[i].setMap(null);
        markers_list.splice(i, 1);
        pin_button.style.backgroundColor = 'maroon'
      }
    }
    console.log(markers_list)
    btn.disabled = true;
  }
  //figure out how to confirm
  function send_coords() { //needs fixing
    pin_button.style.backgroundColor = 'green'
    for (let index = 0; index < markers_list.length; index++) {
      let object_string = JSON.stringify(markers_list[index])
      //data base call
    }
  
  function open_map(event) {
    window.init_map = init_map;
    console.log(checkpoint_id)
  }
  }
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkY5KKVjLNfTPCAX17XbClpOpfTQd0cFM&callback=init_map">
</script>

</html>
