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
            <div class="input-group mb-3 mx-auto" id="chip_input_witdh">
                <div class="input-group-prepend">
                    <button class="btn btn-dark" type="button" onclick="register_on_event(g_event_id)">Register</button>
                </div>
                <input type="text" class="form-control" placeholder="Ex: 312343" aria-label="" aria-describedby="basic-addon1" id="send_chip">
            </div>



            <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>

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

</script>

</html>