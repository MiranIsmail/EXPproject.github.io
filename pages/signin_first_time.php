<?php include '../assets/head.php'; ?>


<body>
    <!--The swimrun image-->
    <?php include '../assets/navbar.php'; ?>
    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
    </div>

    <div class="section w-100 content_container">
        <h1 id="special_h1">Please enter your values!</h1>
        <p class="center_item">I dont want to! <a href="Login.php">Skip</a></p>
        <form>
            <div class="form-group form_group_style mx-auto">
                <h3 class="text-shift"><button type="button" class="button" data-bs-toggle="modal" data-bs-target="#edit_profile" id="button_style">Uppload Profile Image</button>
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Birth date</p>
                <input type="date" class="form-control input_field_style" placeholder="Enter email" id="fetch_bday">
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Height</p>
                <input type="value" class="form-control input_field_style" placeholder="Height in cm" id="fetch_height">
            </div>
            <div class="form-group form_group_style mx-auto">
                <p>Weight</p>
                <input type="value" class="form-control input_field_style" placeholder="Weight in kg" id="fetch_weight">
            </div>
            <div class="form-group form_group_style mx-auto">
                <div class="row">
                    <div class="col-sm">
                        <a href="Login.php"><button type="button" class="button" id="button_style">Skip</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" id="button_style">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include '../assets/footer.php'; ?>
</body>

</html>