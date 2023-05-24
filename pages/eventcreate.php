<?php
include '../assets/head.php';
?>

<body>
  <?php include '../assets/navbar.php'; ?>
  <h1 class="mx-auto" id="nice_text">Create your Event here</h1>
  <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="Running figures" id="image_run">

  <div class="section w-100" style="padding-bottom: 4rem;" id="searchFade">
    <div class="mb-3 mx-auto w-50">
      <label for="InputEventName" class="form-label">Event Name</label>
      <input type="text" class="form-control" id="send_event_name" placeholder="Input Event Name">
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputTrackName" class="form-label">Track Name</label>
      <select id="dropdown_track" class="w-100"></select>
      <!-- <input type="text" class="form-control" id="send_track_name" placeholder="Input Track Name"> -->
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputStartDate" class="form-label">Start Date</label>
      <input class="form-control" type="datetime-local" id="send_start_date" />
      <span id="startDateSelected"></span>
    </div>
    <div class="mb-3 mx-auto w-50">End Date
      <input class="form-control" type="datetime-local" id="send_end_date" />
      <span id="endDateSelected"></span>
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputTrackName" class="form-label">Write a description for your event</label>
      <textarea class="form-control" aria-label="With textarea" id="send_description" placeholder="Write your description here!"></textarea>
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputEventName" class="form-label">Event Sport</label>
      <input type="text" class="form-control" id="send_sport" placeholder="Input the sport for the event">
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputTrackName" class="form-label">Upload Event Image</label>
      <input type="file" name="filename" id="send_image" multiple="false">
    </div>
    <div class="form-check form-switch mb-3 mx-auto w-50">
      <input class="form-check-input" type="checkbox" id="send_open" aria-describedby="publicHelpBlock">
      <label class="form-check-label" for="send_open">Open for Entry</label>
      <div id="publicHelpBlock" class="">
        Check this box if you want all users to be able to participate to your event
      </div>
    </div>
    <div class="form-check form-switch mb-3 mx-auto w-50">
      <input class="form-check-input" type="checkbox" id="send_public" aria-describedby="openHelpBlock">
      <label class="form-check-label" for="send_public">Public View</label>
      <div id="openHelpBlock" class="">
        Check this box if you want the event to be visable and searchable for all users.
      </div>
    </div>
    <div class="mb-3 mx-auto w-50">
      <button type="submit" class="btn btn-primary" onclick="preview_event()">Preview event</button>
    </div>
    <div id="event_cards_dynamic" class="w-75 mx-auto"></div>
    <div class="mb-3 mx-auto w-50">
      <button type="submit" class="btn btn-primary" onclick="create_event()">Submit</button>
    </div>
  </div>
  <?php include '../assets/footer.php'; ?>
  <script>
    dropdown = document.getElementById("dropdown_track");
    dropdown.add(new Option("Select a Track"));
    TrackDropdown();
  </script>
</body>

</html>