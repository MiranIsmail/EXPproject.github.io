<?php
include '../assets/head.php';
?>



<body>
    <?php include '../assets/navbar.php'; ?>
    <div class="content_display mx-auto">
        <div class="cropped mx-auto">
            <div id="image_box">
            </div>
        </div>
        <div class="overflow-hidden" id="information_container">
            <div class="row information">
                <h1><span id="event_name"></span></h1>
                <div class="col-lg-4" id="info_grid">
                    <div>
                        <h3>Information</h3>
                        <h5>EventID: <span id="event_id"></span></h5>
                        <h5>Sport: <span id="event_sport"></span></h5>
                        <h5>StartDate: <span id="event_sdate"></span></h5>
                        <h5>EndDate: <span id="event_edate"></span></h5>
                        <a id="username_link">
                            <h5>Host Username: <span id="event_org"></span></h5>
                        </a>
                        <h5>Track: <span id="event_track"></span></h5>
                    </div>
                    <div id="padding_border">
                        <h3>Description</h3>
                        <h5 class="mx-auto"><span id="event_desc"></span></h5>
                    </div>
                    <button onclick="delete_event()" type="button" class="btn btn-danger mb-1 d-none" id="delete_event_button_display">
                        delete
                    </button>
                </div>
                <div class="col-md-8 map_box" id="map_grid">
                    <div class="map_border" id="map"></div>
                </div>
            </div>
            <div class="mx-auto" id="chip_input_witdh">

                <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#register_event" aria-expanded="false" aria-controls="collapseExample" id="button_style_create">
                    Register On This Event!
                </button><button onclick="unregister_from_event()" type="button" class="btn btn-danger mb-3">
                    Unregister
                </button>


                <div class="collapse" id="register_event">
                    <div class="card card-body" id="register_card">
                        <h3 class="underline_text">Register on <span id="event_name_colapse"><span></h3>

                        <div class="mx-auto w-100" id="inputfield_padding">
                            <label for="InputMate" class="form-label">Team mate</label>
                            <input type="text" class="form-control" id="send_team8" placeholder="Input User Name">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 padding_bottom_half">
                                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#thirechip" aria-expanded="true" aria-controls="collapseExample" checked>
                                <label class="btn btn-secondary w-100" for="option1">Register New Chip</label>
                            </div>
                            <div class="col-sm-6 padding_bottom_half">
                                <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#mychip" aria-expanded="false" aria-controls="collapseExample">
                                <label class="btn btn-secondary w-100" for="option2">I Have My Own</label>
                            </div>

                        </div>

                        <div class="collapse show" id="thirechip">
                            <div class="card card-body" id="register_card">
                                <div class=" mx-auto w-100" id="inputfield_padding">
                                    <p>Chip ID:</p>
                                    <input type="text" class="form-control input_field_style w-100" placeholder="Input The ChipID on provided chip:" aria-describedby="emailHelp" id="send_chip">
                                </div>
                                <button class="btn w-100 padding_top" id="button_style_create" onclick="register_on_event(g_event_id)" data-bs-toggle="collapse" data-bs-target="#register_event">Register</button>
                            </div>
                        </div>
                        <div class="collapse" id="mychip">
                            <div class="card card-body" id="register_card">
                                <div class="form-group mx-auto w-100" id="inputfield_padding">
                                    <p>Chip ID:</p>
                                    <input type="text" class="form-control input_field_style w-100" placeholder="You have no registerd chip!" aria-describedby="emailHelp" id="chip_id_display" disabled>
                                </div>
                                <button class="btn w-100 padding_top" id="button_style_create" onclick="register_on_event_my(g_event_id)" data-bs-toggle="collapse" data-bs-target="#register_event">Register</button>
                            </div>
                        </div>
                        <script>
                            const option1 = document.getElementById("option1");
                            const option2 = document.getElementById("option2");
                            const mychip = document.getElementById("mychip");
                            const thirechip = document.getElementById("thirechip");

                            option2.addEventListener("click", function() {
                                if (!mychip.classList.contains("show")) {
                                    thirechip.classList.remove("show");
                                }
                            });

                            option1.addEventListener("click", function() {
                                if (!thirechip.classList.contains("show")) {
                                    mychip.classList.remove("show");
                                }
                            });
                        </script>



                    </div>
                </div>

                <!-- <div class="input-group-prepend">
                    <button class="btn btn-dark" type="button" onclick="register_on_event(g_event_id)">Register</button>

                </div>
                <input type="text" class="form-control" placeholder="Ex: 312343" aria-label="" aria-describedby="basic-addon1" id="send_chip"> -->
            </div>

            <!--adding the buttons to select gender-->



            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="btn-group" role="group" aria-label="Button group">
                        <button type="button" class="btn table_color btn-custom active" onclick="toggleButton(1)">Everyone</button>
                        <button type="button" class="btn table_color btn-custom" onclick="toggleButton(2)">Men</button>
                        <button type="button" class="btn table_color btn-custom" onclick="toggleButton(3)">Women</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <h2 class="underline_text blue_text"> Results </h2>
                    </div>
                    <div class="col-3">
                    </div>
                </div>
            </div>


            <script>
                let selectedButton = 1; // Set Button 1 as the default selected button

                function toggleButton(buttonNumber) {
                const buttons = document.querySelectorAll('.btn-custom');

                if (selectedButton === buttonNumber) {
                    // Button is already selected, deselect it
                    buttons[buttonNumber - 1].classList.remove('active');
                    selectedButton = null;
                } else {
                    // Deselect the currently selected button
                    if (selectedButton !== null) {
                    buttons[selectedButton - 1].classList.remove('active');
                    }

                    // Select the clicked button
                    buttons[buttonNumber - 1].classList.add('active');
                    selectedButton = buttonNumber;
                }
                }
            </script>

            <table class="table table-bordered result_table" id="event_user_results">
                <thead>
                    <tr>
                        <th scope="col">User1</th>
                        <th scope="col">User2</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <script src="../scripts/js_scripts.js">
            event_display_peeps()
        </script> -->
                </tbody>
            </table>
            <div id="myTableContainer"></div>
        </div>
    </div>
    </div>
    <?php include '../assets/footer.php'; ?>

</body>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const g_event_id = urlParams.get('event_id');
    console.log(g_event_id)
    get_event_info(g_event_id);

    get_checkpoints(g_event_id);
    get_chip()
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsBStdDh_BYJILh8nLu9sDvIrJ-bB3fi8&callback=init_map">
</script>

</html>