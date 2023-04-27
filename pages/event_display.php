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
                    <div class="padding_border">
                        <h3>Information</h3>
                        <h5>Sport: <span id="event_sport"></span></h5>
                        <h5>StartDate: <span id="event_sdate"></span></h5>
                        <h5>EndDate: <span id="event_edate"></span></h5>
                        <a id="username_link"><h5>Host Username: <span id="event_org"></span></h5></a>
                        <h5>Track: <span id="event_track"></span></h5>
                    </div>
                    <div class="padding_border">
                        <h3>Description</h3>
                        <h5 class="mx-auto"><span id="event_desc"></span></h5>
                    </div>
                </div>
                <div class="col-md-8" id="map_grid">
                    <div id="map"></div>
                </div>
            </div>

            <div class="mx-auto" id="chip_input_witdh">

                <p><button class="btn w-100" type="button" data-bs-toggle="collapse" data-bs-target="#register_event" aria-expanded="false" aria-controls="collapseExample" id="button_style_create">
                        Register On This Event!
                    </button>
                </p>
                <div class="collapse" id="register_event">
                    <div class="card card-body" id="register_card">
                        <h3 class="underline_text">Register on <span id="event_name_colapse"><span></h3>

                        <div class="form-group mx-auto w-100" id="inputfield_padding">
                            <p>Team member:</p>
                            <input type="text" class="form-control input_field_style w-100" placeholder="Team members username: (optional)" aria-describedby="emailHelp" id="email">
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
                                <div class="form-group mx-auto w-100" id="inputfield_padding">
                                    <p>Chip ID:</p>
                                    <input type="text" class="form-control input_field_style w-100" placeholder="Input The ChipID on provided chip:" aria-describedby="emailHelp" id="send_chip">
                                </div>
                                <button class="btn w-100 padding_top" id="button_style_create" onclick="register_on_event(g_event_id)">Register</button>
                            </div>
                        </div>
                        <div class="collapse" id="mychip">
                            <div class="card card-body" id="register_card">
                                <div class="form-group mx-auto w-100" id="inputfield_padding">
                                    <p>Chip ID:</p>
                                    <input type="text" class="form-control input_field_style w-100" placeholder="You have no registerd chip!" aria-describedby="emailHelp" id="chip_id_display" disabled>
                                </div>
                                <button class="btn w-100 padding_top" id="button_style_create" onclick="register_on_event_my(g_event_id)">Register</button>
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




            <h2 class="underline_text"> Results </h2>
            <div id="myTableContainer"></div>
        </div>
    </div>
    </div>
    <?php include '../assets/footer.php'; ?>
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</body>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const g_event_id = urlParams.get('event_id');
    const g_track_name = document.getElementById('event_track').innerHTML

    console.log(await get_checkpoints_track_name(g_track_name))
    console.log(g_event_id)
    get_event_info(g_event_id);
    get_track(g_track_name)
    get_chip()
    console.log(g_track_name)

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
    }
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkY5KKVjLNfTPCAX17XbClpOpfTQd0cFM&callback=init_map">
</script>

</html>