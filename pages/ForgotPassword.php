<?php include '../assets/navbar.php'; ?>

<body>
    <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->
    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
    </div>

    <div class="section w-100 content_container">
        <h1> Welcome!</h1>
        <form>
            <div class="form-group form_group_style mx-auto">
                <p>Enter your Email address</p>
                <input type="email" class="form-control input_field_style" aria-describedby="emailHelp" placeholder="Enter email" id="fetchEmail">
            </div>
            <div class="form-group form_group_style mx-auto">
                <button type="button" id="button_style" onclick="">Send A Reset Password Link To Email</button>
            </div>
        </form>
    </div>
    <?php include '../assets/footer.php'; ?>
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</body>

</html>