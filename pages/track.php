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
        <p>Here you can create tracks that can then be chosen when creating events.</p>
        <p>Make sure that all your checkpoints are functional and that their ID is visable.</p>
        <p>The sections are automatically connected. Following sections always start where the last one ended.</p>
        <label for="InputTrackName" class="clear_text">Track name</label>
        <input type="text" class="form-control" id="InputTrackName" placeholder="My Track">
      </div>
      <!-- Include the Bootstrap 5 CSS file -->
      <!-- Create a table with Bootstrap 5 classes -->
      <div class="form-group col-md-12 form_group_style mx-auto">
        <p>Start by adding the first section!</p>
        <div class="container needs-validation" id="track_input" novalidate>
          <div class="row track_form" id="row0">
            <p>Section
            <p>
            <div class="col-3 input-group mb-3">
              <div class="input-group-prepend" required>
                <label class="input-group-text" for="inputGroupSelect01">Start</label>
              </div>
              <div class="invalid-feedback">
                Please enter in an ID number between 101 and 199
              </div>
              <input type="number" class="form-control" id="start0" name="StartID" min="101" max="199" placeholder="Start Station ID">
              <button type="button" class="btn btn-secondary" name="Startpin" onclick="find_pin_id(this, 'Start')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
              </button>
            </div>
            <div class="col-3 input-group md-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01"> End </label>
              </div>
              <input type="number" class="form-control" id="end0" name="EndID" min="100" max="200" placeholder="End Station ID" required>
              <button type="button" class="btn btn-secondary" name="Endpin" onclick="find_pin_id(this, 'End')" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-map-location-dot"></i>
              </button>
              <div class="col-12">
                <small class="form-text ">IDs of 0, 90 and 101-199 are accepted</small>
              </div>
            </div>

            <div class="col-4">
              <label for="numberInput" id="dist" class="form-label fw-bold">Distance (m)</label>
              <input type="number" class="form-control" placeholder="1500" name="distance" required>
            </div>
            <div class="col-4">
              <label for="dropdown" id="terrain_dropdown" class="form-label fw-bold">Terrain</label>
              <div class="dropdown" name="terrain">
                <button class="btn btn-secondary dropdown-toggle" type="button" name="Terrain" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-person-running"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButtonTerrain1">
                  <li><a class="dropdown-item" onclick='select("Swim", event)'><i class="fa-solid fa-person-swimming"></i> Swim</a></li>
                  <li><a class="dropdown-item" onclick='select("Run", event)'><i class="fa-solid fa-person-running"></i> Run</a></li>
                  <li><a class="dropdown-item" onclick='select("Mixed", event)'><i class="fa-solid fa-frog"></i> Mixed</a></li>
                </ul>
              </div>
            </div>
            <div class="col-4">
              <label for="button_delete" id="del" class="form-label fw-bold">Options</label>
              <button class="btn btn-danger" onclick="deleteRow(this)" name="delete_button"><i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="option_background">
            <button id="add_button" button type="button" class="btn btn-secondary" onclick="addRow()">Add another section <i class="fa-regular fa-plus"></i></button>
            <button type="submit" button type="button" button id="submit_button" class="btn btn-primary" role="button">Submit</button>
          </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="myModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="alert alert-danger" role="alert" id="mult_id_alert" style="display:none;">
                You have inputed a Station ID that has already been saved
              </div>
              <div class="alert alert-warning" role="alert" id="invalid_id_alert" style="display:none;">
                You have inputed a invalid Station ID. Please correct it.
              </div>
              <!-- Modal Header -->
              <div class="modal-header text-center">
                <h4 class="modal-title w-100">Map</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="close_map()"></button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div id="map"></div>
                SAVED pins must be DELETED before their ID can be modified.
              </div>


              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="close_map()">Close</button>
                <button type="button" class="btn btn-danger" disabled id="del_btn" onclick="deleteMarkers()">Delete</button>
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
  <script sync>
    // Create template row 
    const template_row = document.getElementById("row0")
    const info = template_row.innerHTML
    const success = 'green'
    const fail = 'maroon'
    const submit_btn = document.getElementById("submit_button")

    submit_btn.addEventListener('click', function(e) {
      e.preventDefault();

      const trackname = document.getElementById('InputTrackName')
      const inputs = document.querySelectorAll('input');
      const dropdowns = document.querySelectorAll('dropdown')
      let TrackName = false;
      let allDisabled = true;
      let allValid = true;

      // check if all inputs are disabled

      if (trackname.value == "") {
        TrackName = false;
      } else {
        TrackName = true;
      }
      inputs.forEach(function(input) {
        if (!input.disabled && input.name == "EndID" || !input.disabled && input.name == "StartID") {
          allDisabled = false;
        }
      });

      inputs.forEach(function(input) {
        let name = input.name
        switch (name) {
          case 'StartID':
            const start_id = parseInt(input.value);
            if (start_id != 0) {
              if (isNaN(start_id) || start_id < 101 || start_id > 199) {
                allValid = false;
                break;
              }
            }
            // additional validation for text input
            break;

          case 'EndID':
            const end_id = parseInt(input.value);
            if (end_id != 90) {
              if (isNaN(end_id) || end_id < 101 || end_id > 199) {
                allValid = false;
                break;
              }
            }
            // additional validation for email input
            break;

          case 'distance':
            const range = parseInt(input.value);
            if (isNaN(range)) {
              allValid = false;
              break;
            }
            // additional validation for number input
            break;

        }
      });

      if (allDisabled && allValid && TrackName) {
        submit();
      } else if (!allDisabled && !allValid) {
        alert('Please check your inputs');
      } else if (!allDisabled) {
        alert('Please pin a location to each Checkpoint.');
      } else if (!allValid) {
        alert('Some fields are missing input or have incorrect values');
      } else if (!TrackName) {
        alert('Please enter a Track Name');
      }

    });

    var i = 0

    function addRow() {
      i = i + 1

      // Create a new row element and add the HTML string you provided
      const newRow = document.createElement("div");
      newRow.classList.add('row');
      newRow.classList.add('track_form')
      newRow.id = "row" + i
      newRow.innerHTML = info

      var myGrid = document.getElementById("track_input");
      myGrid.appendChild(newRow);

      // Add row to grid

      // Change row
      const container = document.getElementById("row" + i)
      const fieldInput = container.querySelector('input[name="StartID"]')
      const fieldInput2 = container.querySelector('input[name="EndID"]')
      const pinButton = container.querySelector('button[name="Startpin"]')

      fieldInput.id = "start" + i
      fieldInput2.id = "end" + i

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
      } else if (previous_row == null) {
        const next_row_start_field_input = next_row.querySelector('input[name="StartID"]')
        const next_row_start_pin_button = next_row.querySelector('button[name="Startpin"]')
        if (next_row_start_pin_button.style.backgroundColor !== success) {
          next_row_start_field_input.disabled = false
        }
        next_row_start_pin_button.disabled = false
        row.remove()
        deleteMarkersPrompt(StartID)
      } else if (next_row == null) {
        const prev_row_end_field_input = previous_row.querySelector('input[name="EndID"]')
        const prev_row_end_pin_button = previous_row.querySelector('button[name="Endpin"]')

        if (prev_row_end_pin_button.style.backgroundColor !== success) {
          prev_row_end_field_input.disabled = false
        }
        prev_row_end_pin_button.disabled = false
        deleteMarkersPrompt(EndID)
        row.remove()
      } else {
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


    function submit() {

      var rows = document.querySelectorAll('.track_form');

      var last_row = document.getElementById("track_input").lastElementChild
      var first_row = document.getElementById("track_input").firstElementChild
      var start_station_id = first_row.querySelector('input[name="StartID"]').value
      var end_station_id = last_row.querySelector('input[name="EndID"]').value
      var track_name = document.getElementById('InputTrackName').value

      console.log(track_name, start_station_id, end_station_id)
      CreateTrack(track_name, start_station_id, end_station_id)

      var idInputStart
      var idInputEnd
      var distanceInput
      var terrainDropdown

      var start_id
      var end_id
      var distance
      var terrain
      // Loop through each row
      let checkpoint_number = 0
      rows.forEach(row => {
        // Get the input fields in the row
        checkpoint_number++
        console.log(rows)
        idInputStart = row.querySelector('input[name="StartID"]');
        idInputEnd = row.querySelector('input[name="EndID"]');
        distanceInput = row.querySelector('input[name="distance"]');
        terrainDropdown = row.querySelector('button[name="Terrain"]');

        // Get the values of the input fields
        start_id = idInputStart.value.toString();
        end_id = idInputEnd.value.toString();
        distance = distanceInput.value;
        terrain = terrainDropdown.textContent;

        var current_marker
        var marker_longitude
        var marker_latitude

        for (let i = 0; i < markers_list.length; i++) {
          if (markers_list[i].getLabel() == start_id) {
            current_marker = markers_list[i]
            marker_longitude = current_marker.getPosition().lng()
            marker_latitude = current_marker.getPosition().lat()
          }
        }
        console.log(track_name, start_id, end_id, distance, terrain, marker_longitude, marker_latitude, checkpoint_number)
        create_checkpoint_endpoint(track_name, start_id, end_id, distance, terrain, marker_longitude, marker_latitude, checkpoint_number);

      })
      checkpoint_number++
      //endstation
      for (let i = 0; i < markers_list.length; i++) {
        if (markers_list[i].getLabel() == end_id) {
          current_marker = markers_list[i]
          marker_longitude = current_marker.getPosition().lng()
          marker_latitude = current_marker.getPosition().lat()

          create_checkpoint_endpoint(track_name, end_id, "undef", "0", "undef", marker_longitude, marker_latitude, checkpoint_number)
        }
      }
      location.href = "../pages/confirmation_track.php";
    }


    let row;
    let next_row;
    let input_field;
    let checkpoint_id;
    let pin_button;
    let next_pin_button;
    let map;
    let marker;
    let markers_list = [];
    let placement_ready = true;
    let marker_connections_with_rows = {};
    const save_btn = document.getElementById('save_btn');
    const del_btn = document.getElementById('del_btn');
    const pin_alert = document.getElementById("mult_id_alert");
    const pin_warning = document.getElementById("invalid_id_alert");

    function find_pin_id(button, type) {
      row = button.parentNode.parentNode;
      input_field = row.querySelector(`input[name=${type+"ID"}]`)
      checkpoint_id = parseInt(input_field.value)
      pin_button = row.querySelector(`button[name=${type+"pin"}]`)
      placement_ready = false
      save_btn.disabled = true
      del_btn.disabled = true

      if (marker_connections_with_rows[checkpoint_id] !== undefined && marker_connections_with_rows[checkpoint_id] !== input_field.id) {
        // Pin already registered
        save_btn.disabled = true
        del_btn.disabled = true
        pin_alert.style.display = "block";
      } else if (checkpoint_id == 0 || checkpoint_id == 90 || (checkpoint_id >= 101 && checkpoint_id <= 199)) {
        // Valid pin
        console.log("Valid pin")
        console.log(checkpoint_id)
        save_btn.disabled = false
        del_btn.disabled = false
        placement_ready = true
        checkpoint_id = checkpoint_id.toString()
      } else {
        // Invalid pin
        pin_warning.style.display = "block";
      }
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
        if (placement_ready == true) {
          deleteMarkers();
          save_btn.disabled = false;
          del_btn.disabled = false;
          add_marker(event.latLng, checkpoint_id);
        }
      });
    }

    // Adds a marker to the map and push to the array.
    function add_marker(position, checkpoint_id) {
      marker = new google.maps.Marker({
        position: position,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        label: checkpoint_id
      });

      markers_list.push(marker);

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
          delete marker_connections_with_rows[CheckID];

        }
      }
    }

    function close_map() {
      pin_alert.style.display = "none";
      pin_warning.style.display = "none";
      for (let i = 0; i < markers_list.length; i++) {
        if (markers_list[i].getLabel() == checkpoint_id && marker_connections_with_rows[checkpoint_id] !== input_field.id) {
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
          delete marker_connections_with_rows[checkpoint_id];

          pin_button.style.backgroundColor = fail

          if (row !== last_row && input_field.name == "EndID") {
            next_row = row.nextElementSibling;
            var next_pin_button = next_row.querySelector('button[name="Startpin"]')
            next_pin_button.style.backgroundColor = fail
          }
          input_field.disabled = false
        }
      }
      save_btn.disabled = true;
      del_btn.disabled = true;
    }

    function send_coords() {

      let last_row = document.getElementById("track_input").lastElementChild

      if (row !== last_row && input_field.name == "EndID") {
        next_row = row.nextElementSibling;
        var next_pin_button = next_row.querySelector('button[name="Startpin"]')
        next_pin_button.style.backgroundColor = success
      }
      input_field.disabled = true
      pin_button.style.backgroundColor = success
      marker.setDraggable(false);
      marker_connections_with_rows[marker.getLabel()] = input_field.id

    }

    function open_map(event) {

      window.init_map = init_map;
    }
  </script>
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsBStdDh_BYJILh8nLu9sDvIrJ-bB3fi8&callback=init_map">
  </script>
</body>

</html>