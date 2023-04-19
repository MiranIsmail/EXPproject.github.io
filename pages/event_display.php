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
                        <h5>Host Username: <span id="event_org"></span></h5>
                    </div>
                </div>
                <div class="col-md-8" id="info_grid">
                    <div class="padding_border">
                        <h3>Description</h3>
                        <h5 class="mx-auto"><span id="event_desc"></span></h5>
                    </div>
                </div>
            </div>

            <div class="mx-auto" id="chip_input_witdh">

            <p><button class="btn w-100" type="button" data-bs-toggle="collapse" data-bs-target="#register_event" aria-expanded="false" aria-controls="collapseExample" id="button_style_create">
                Register On This Event!
            </button>
            </p>
            <div class="collapse" id="register_event">
                <div class="card card-body" id="register_card">
                    <h3 class="underline_text">Register on event!</h3>

                    <div class="form-group mx-auto w-100" id="inputfield_padding">
                        <p>Team member:</p>
                        <input type="text" class="form-control input_field_style w-100" placeholder="Team members username:" aria-describedby="emailHelp" id="email">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#mychip" aria-expanded="true" aria-controls="collapseExample" checked>
                            <label class="btn btn-secondary w-100" for="option1">Register New Chip</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#thirechip" aria-expanded="false" aria-controls="collapseExample">
                            <label class="btn btn-secondary w-100" for="option2">I Have My Own</label>
                        </div>
                    </div>

                    <div class="collapse show" id="mychip">
                        <div class="card card-body" id="register_card">
                            <div class="form-group mx-auto w-100" id="inputfield_padding">
                                <p>Chip ID:</p>
                                <input type="text" class="form-control input_field_style w-100" placeholder="Input The ChipID on provided chip:" aria-describedby="emailHelp" id="send_chip">
                            </div>
                        </div>
                    </div>
                    chip_id_display
                    <div class="collapse" id="thirechip">
                        <div class="card card-body" id="register_card">
                            <div class="form-group mx-auto w-100" id="inputfield_padding">
                                <p>Chip ID:</p>
                                <input type="text" class="form-control input_field_style w-100" placeholder="Input The ChipID on provided chip:" aria-describedby="emailHelp" id="chip_id_display send_chip" readonly>
                            </div>
                        </div>
                    </div>

                    <script>
                        const option1 = document.getElementById("option1");
                        const option2 = document.getElementById("option2");
                        const mychip = document.getElementById("mychip");
                        const thirechip = document.getElementById("thirechip");

                        option1.addEventListener("click", function() {
                            if (!mychip.classList.contains("show")) {
                                thirechip.classList.remove("show");
                            }
                        });

                        option2.addEventListener("click", function() {
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
    var g_event_id = sessionStorage.getItem('s_event_id');
    console.log(g_event_id)
    get_event_info(g_event_id);
    get_chip()

</script>

</html>