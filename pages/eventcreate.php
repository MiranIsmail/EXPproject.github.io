<!DOCTYPE html>
<html lang="en">

<head>
  <title>Create Event - Rasts</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
  <!--Tre librarys dont remove, Bootstrap 5-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../styles/stylesheet.css">
  <link rel="stylesheet" href="../styles/login_style.css">
  <link rel="stylesheet" href="../styles/SignUp_LogIn_style.css">
  <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</head>


<body">
  <?php include '../assets/navbar.php'; ?>
  <h1 class="mx-auto" id="nice_text">Create your Event here</h1>
  <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="running figures" id="image_run">

  <div class="section w-100" style="padding-bottom: 4rem;" id="searchFade">    <div class="mb-3 mx-auto w-50">
      <label for="InputEventName" class="form-label">Event Name</label>
      <input type="text" class="form-control" id="InputEventName" placeholder="Input Event Name">
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputTrackName" class="form-label">Track Name</label>
      <input type="text" class="form-control" id="InputTrackName" placeholder="Input Track Name">
    </div>
    <div class="mb-3 mx-auto w-50">
      <label for="InputStartDate" class="form-label">Start Date</label>
      <input id="startDate" class="form-control" type="date" />
      <span id="startDateSelected"></span>
    </div>
    <div class="mb-3 mx-auto w-50">End Date
      <input id="endDate" class="form-control" type="date" />
      <span id="endDateSelected"></span>
    </div>

    <div class="mb-3 mx-auto w-50">
      <img id="blah" src="#" alt="your image" />
      <label for="InputTrackName" class="form-label">Upload Event Image</label>
      <input type="file" name="filename" id="send_eimage" onchange="readURL(this);">
    </div>

    <div class="form-check form-switch mb-3 mx-auto w-50">
      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" aria-describedby="publicHelpBlock">
      <label class="form-check-label" for="flexSwitchCheckDefault">Open for Entry</label>
      <div id="publicHelpBlock" class="form-text">
        Check this box if you want all users to be able to participate to your event
      </div>
    </div>
    <div class="form-check form-switch mb-3 mx-auto w-50">
      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" aria-describedby="openHelpBlock">
      <label class="form-check-label" for="flexSwitchCheckDefault">Public View</label>
      <div id="openHelpBlock" class="form-text">
        Check this box if you want the event to be visable and searchable for all users.
      </div>
    </div>
    <!-- Include the Bootstrap 5 CSS file -->
    <div class="mb-3 mx-auto w-50">
      <button type="submit" class="btn btn-primary" href="../eventcreate.php" onclick="submit()">Submit</button>
    </div>
  </div>
  <input type='file' onchange="readURL(this);" />
  <img id="blah" src="#" alt="your image" />
  <?php include '../assets/footer.php'; ?>
  </body>

  <script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
  </script>
</html>