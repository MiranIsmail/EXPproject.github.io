<?php include '../assets/head.php'; ?>
<body>
  <?php include '../assets/navbar.php'; ?>
  <div class="image_div">
    <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
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
            <p>Section<p>
            <div class="col-3 input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Start</label>
              </div>
              <input type="number" class="form-control" name="StartID" min="100" max="200" placeholder="Start Station ID" required>
              <button type="button" class="btn btn-secondary" name="Startpin" onclick="find_pin_id(this, 'Start')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
              </button>
            </div>
            <div class="col-3 input-group md-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">End</label>
              </div>
              <input type="number" class="form-control" name="EndID" min="100" max="200" placeholder="End Station ID" required>
              <button type="button" class="btn btn-secondary" name="Endpin" onclick="find_pin_id(this, 'End')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
              </button>
            </div>

            <div class="col-4">
              <label for="numberInput" id="dist" class="form-label fw-bold">Distance (m)</label>
              <input type="number" class="form-control" placeholder="Ex. 15" name="distance" required>
            </div>
            <div class="col-4">
              <label for="dropdown" id="terrain_dropdown" class="form-label fw-bold">Terrain</label>
              <div class="dropdown" name="terrain">
                <button class="btn btn-secondary dropdown-toggle" type="button" name="Terrain" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-person-running"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButtonTerrain1" required>
                  <li><a class="dropdown-item" onclick='select("Swim", event)'><i class="fa-solid fa-person-swimming"></i> Swim</a></li>
                  <li><a class="dropdown-item" onclick='select("Run", event)'><i class="fa-solid fa-person-running"></i> Land</a></li>
                  <li><a class="dropdown-item" onclick='select("Mixed", event)'><i class="fa-solid fa-frog"></i> Mixed</a></li>
                </ul>
              </div>
            </div>
            <div class="col-1">
            <label for="button_delete" id="del" class="form-label fw-bold">Options</label>
              <button class="btn btn-danger" onclick="deleteRow(this)" name="delete_button"><i class="fa-solid fa-trash"></i>
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
      </div>
    </div>
  </div>
  </div>
  </div>

  <?php include '../assets/footer.php'; ?>

<script type="text/javascript" src="../scripts/js_scripts.js"></script>    
<script>
  // Create template row 
  const template_row = document.getElementById("0")
  const info = template_row.innerHTML
  const success = 'green'
  const fail = 'maroon'

  var i = 0
  function addRow() {
    i = i + 1 

    // Create a new row element and add the HTML string you provided
    const newRow = document.createElement("div");
    newRow.classList.add('row');
    newRow.classList.add('track_form')
    newRow.id = i
    newRow.innerHTML = info

    var myGrid = document.getElementById("track_input");
    myGrid.appendChild(newRow);
    
    // Add row to grid
  
    // Change row
    const container = document.getElementById(i)
    const fieldInput = container.querySelector('input[name="StartID"]')
    const pinButton = container.querySelector('button[name="Startpin"]')
    
    const previous_row = newRow.previousElementSibling;
    const previous_rowFieldInput = previous_row.querySelector('input[name="EndID"]')
    const previous_rowPinButton = previous_row.querySelector('button[name="Endpin"]')

    fieldInput.value = previous_rowFieldInput.value;
    fieldInput.disabled = true
    pinButton.style.backgroundColor = previous_rowPinButton.style.backgroundColor
    pinButton.disabled = true 

    // Add so that when the row above changes, the below one does as well
    previous_rowFieldInput.addEventListener("change", () => {
      fieldInput.value = previous_rowFieldInput.value
    })
    previous_rowFieldInput.addEventListener("keydown", () => {
      fieldInput.value = previous_rowFieldInput.value
    })

  }

  function select(option, event) {
    // Get the button element and the dropdown menu element
    var row = event.target.closest('div');
    var button = row.querySelector('button[name="Terrain"]');
    var dropdown = document.querySelector('.dropdown-menu');
    
    // Set the button text to the selected option
    button.textContent = option;
    // Change the button color based on the selected option
    switch (option) {
      case "Swim":
        button.style.backgroundColor = 'blue';
        break;
      case 'Run':
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
    const StartID = row.querySelector('input[name="StartID"]').value
    const EndID = row.querySelector('input[name="EndID"]').value
    const previous_row = row.previousElementSibling;
    const next_row = row.nextElementSibling;


    if (previous_row == null && next_row == null) {
      row.remove();
      deleteMarkersPrompt(StartID)
      deleteMarkersPrompt(EndID)
    }
    else if (previous_row == null) {
      const next_row_start_field_input = next_row.querySelector('input[name="StartID"]')
      const next_row_start_pin_button = next_row.querySelector('button[name="Startpin"]')
      if (next_row_start_pin_button.style.backgroundColor !== success) {
        next_row_start_field_input.disabled = false
      }
      next_row_start_pin_button.disabled = false
      row.remove()
      deleteMarkersPrompt(StartID)
    }
    else if (next_row == null) {
      const prev_row_end_field_input = previous_row.querySelector('input[name="EndID"]')
      const prev_row_end_pin_button = previous_row.querySelector('button[name="Endpin"]')
      
      if (prev_row_end_pin_button.style.backgroundColor !== success) {
        prev_row_end_field_input.disabled = false
      }
      prev_row_end_pin_button.disabled = false
      deleteMarkersPrompt(EndID)
      row.remove()
    }
    else {
      const next_row_start_field_input = next_row.querySelector('input[name="StartID"]')
      const next_row_start_pin_button = next_row.querySelector('button[name="Startpin"]')
      const prev_row_end_field_input = previous_row.querySelector('input[name="EndID"]')
      const prev_row_end_pin_button = previous_row.querySelector('button[name="Endpin"]')

      prev_row_end_field_input.removeEventListener("change", KeyboardEvent)
      prev_row_end_field_input.removeEventListener("keydown", KeyboardEvent)

      prev_row_end_field_input.addEventListener("change", () => {
        next_row_start_field_input.value = prev_row_end_field_input.value;
      })
      prev_row_end_field_input.addEventListener("keydown", () => {
        next_row_start_field_input.value = prev_row_end_field_input.value;
      })
      next_row_start_field_input.value = prev_row_end_field_input.value;
      next_row_start_field_input.disabled = true
      next_row_start_pin_button.style.backgroundColor = prev_row_end_pin_button.style.backgroundColor
      next_row_start_pin_button.disabled = true 
      deleteMarkersPrompt(EndID)

    }


  
    row.remove();
  }
  function DeleteSection(){
  
}

  function submit() {
    // Get all required input fields
    const requiredFields = document.querySelectorAll('input[required]')

    // Check if all required fields are filled in and valid
    const allFieldsValid = Array.from(requiredFields).every(field => field.checkValidity());

    const rows = document.querySelectorAll('.track_form');

    let track_name = document.getElementById('InputTrackName').value
    console.log(track_name)
    // Loop through each row
    let i = 0;
    let start_station;
    let end_station;

    rows.forEach(row => {
      // Get the input fields in the row
      console.log(row)
      const idInputStart = row.querySelector('input[name="StartID"]');
      const idInputEnd = row.querySelector('input[name="EndID"]');
      const distanceInput = row.querySelector('input[name="distance"]');
      const terrainDropdown = row.querySelector('button[name="Terrain"]');
      
      // Get the values of the input fields
      const start_id = idInputStart.value;
      const end_id = idInputEnd.value;
      const distance = distanceInput.value;
      const terrain = terrainDropdown.textContent;
      
      console.log(start_id, end_id, distance, terrain)
      //console.log(i)

      let gps;
      
      // Add endpoint post here 

      if(i === 0){
        start_station = start_id; 
      }
      CreateCheckpoint(track_name, start_id, end_id, distance, terrain, "5");
      i++;
      end_station = end_id

    })
    CreateTrack(track_name, start_station, end_station);
    console.log("Submitted")
  }

  let row
  let next_row
  let input_field
  let checkpoint_id;
  let pin_button;
  let next_pin_button;
  let map;
  let markers_list = [];
  const btn = document.getElementById('save_btn')

  function find_pin_id(button, type) {
    for (let i = 0; i < markers_list.length; i++) {
      if (markers_list[i].getLabel() == checkpoint_id) {
        
        markers_list[i].setMap(null);
        markers_list.splice(i, 1); } 
        console.log("Already exists")
        break
      }
    row = button.parentNode.parentNode;
    input_field = row.querySelector(`input[name=${type+"ID"}]`)
    checkpoint_id = input_field.value
    pin_button = row.querySelector(`button[name=${type+"pin"}]`)

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


  function deleteMarkersPrompt(CheckID) {
    for (let i = 0; i < markers_list.length; i++) {
      if (markers_list[i].getLabel() == CheckID) {
        markers_list[i].setMap(null);
        markers_list.splice(i, 1);
      }
    }
  }
  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    let last_row = document.getElementById("track_input").lastElementChild
    
    for (let i = 0; i < markers_list.length; i++) {
      
      if (markers_list[i].getLabel() == checkpoint_id) {
        
        markers_list[i].setMap(null);
        markers_list.splice(i, 1);
        pin_button.style.backgroundColor = fail
  
        if (row !== last_row && input_field.name == "EndID") {
          next_row = row.nextElementSibling;
          var next_pin_button = next_row.querySelector('button[name="Startpin"]')
          next_pin_button.style.backgroundColor = fail
        }
        input_field.disabled = false
      }
      console.log(markers_list)
      btn.disabled = true;
    }
    console.log(markers_list)
    btn.disabled = true;
  }
  //figure out how to confirm
  function send_coords() { 
    console.log(next_pin_button)
    let last_row = document.getElementById("track_input").lastElementChild

    if (row !== last_row && input_field.name == "EndID") {
      next_row = row.nextElementSibling;
      var next_pin_button = next_row.querySelector('button[name="Startpin"]')
      next_pin_button.style.backgroundColor = success
    }
    input_field.disabled = true
    pin_button.style.backgroundColor = success
    for (let index = 0; index < markers_list.length; index++) {
    let object_string = JSON.stringify(markers_list[index])
    //data base call
    }
  }
  function open_map(event) {
    window.init_map = init_map;
    console.log(checkpoint_id)
  }
  
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkY5KKVjLNfTPCAX17XbClpOpfTQd0cFM&callback=init_map">
</script>
</body>
</html>
