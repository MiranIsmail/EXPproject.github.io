<?php include '../assets/head.php'; ?>
<body>
    <?php include '../assets/navbar.php'; ?>
    <a type="button" style="float:right; padding: 0.5rem;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"><img class="op30" src="../images/settings.svg" id="settings" alt=Gear"></a>
    <div id="container-img">
        <div class="row">
            <div class="col-sm-6" id="profile_box">
            </div>
            <div class="col-sm-6" style="vertical-align: middle;">
                <div class="accout-piture">
                    <div class="reslut"></div>
                </div>
                <div>
                    <h1 class="text-shift">
                        <span id="profileName">Profile name</span>
                    </h1>
                    <h3 class="text-shift">Age: <span id="profile_age"></span> years</h3>
                    <h3 class="text-shift">Length: <span id="profile_length"></span> cm</h3>
                    <h3 class="text-shift">Weight: <span id="profile_weight"></span> kg</h3>
                    <h3 class="text-shift">Private Chip: <span id="profile_chip_id"></span> kg</h3>
                </div>
            </div>
        </div>
    </div>



    <img class="w-100 op30" style="padding-top:2rem;" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">

    <div id="previousEventes">
        <h1 class="text-center">Previous Events</h1>
    </div>

    <div class="events" id="event">
    </div>

    <!--Edit profile popup-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body canvas_container">
            <h4>Edit your profile</h4>
            <div class="form-group form_group_style mx-auto needs-validation" novalidate>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">First Name</label>
                    <input type="text" class="form-control" placeholder="Input Your Name" id="send_f_name">
                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Surname</label>
                    <input type="text" class="form-control" placeholder="Input Your Name" id="send_l_name">
                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Birth day</label>
                    <input class="form-control" type="date" id="send_bday">
                    <span id="b_day_selected"></span>

                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Height</label>
                    <input type="number" class="form-control" placeholder="Input Your Height" id="send_height">
                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Weight</label>
                    <input type="number" class="form-control" placeholder="Input Your Weight" id="send_weight">
                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Personal ChipID</label>
                    <input type="number" class="form-control" placeholder="Input Your Personal ChipID" id="send_chip">
                </div>

                <div class="mb-3 mx-auto">
                    <label for="InputTrackName" class="form-label">Upload Profile Picture</label>
                    <input type="file" name="filename" id="send_image">
                </div>

            </div>

            <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                Form submitted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="form-group form_group_style mx-auto">
                <button class="btn btn-primary" button id="submit_org_form" type="submit" onclick="edit_user_info()">Save changes</button>
            </div>
        </div>
    </div>
    <div id="myTableContainerResults"></div>

    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
    <script>
        get_user_info();
    </script>
</body>

</html>