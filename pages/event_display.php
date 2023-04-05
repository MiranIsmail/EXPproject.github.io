<!DOCTYPE html>
<html lang="en">

<head>
    <title>Homepage - Rasts</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="../images/s_black.svg">
    <!--Tre librarys dont remove, Bootstrap 5-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesheet.css">
    <link rel="stylesheet" href="../styles/login_style.css">
    <link rel="stylesheet" href="../styles/SignUp_LogIn_style.css">
    <link rel="stylesheet" href="../styles/event_display_style.css">
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</head>


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
                        <h5>Host Mail: <span id="event_org"></span></h5>
                    </div>
                </div>
                <div class="col-md-8" id="info_grid">
                    <div class="padding_border">
                        <h3>Description</h3>
                        <h5 class="mx-auto"><span id="event_desc"></span></h5>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3 w-50 mx-auto">
                        <div class="input-group-prepend">
                            <button class="btn btn-dark" type="button" onclicl="">Register</button>
                        </div>
                        <input type="text" class="form-control" placeholder="Ex: 312343" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </div>
            <div id="myTableContainer"></div>
        </div>
    </div>
    <?php include '../assets/footer.php'; ?>
</body>

<script>
    var g_event_id = sessionStorage.getItem('s_event_id');
    console.log(g_event_id)
    get_event_info(g_event_id)
    console.log("-----")
    let myTable = generate_table_results(2);
    document.getElementById('myTableContainer').appendChild(myTable);
</script>

</html>