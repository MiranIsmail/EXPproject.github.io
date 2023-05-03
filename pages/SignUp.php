<?php include '../assets/head.php'; ?>
<!--header-->

<body>
    <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->

    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
    </div>
    <div class="section content_container order-1">
        <h1> Welcome!</h1>

        <form>

            <div class="form-group form_group_style mx-auto">
                <p>Username</p>
                <input type="text" class="form-control input_field_style" placeholder="Username" id="fuser">
            </div>
            <div class="form-group form_group_style mx-auto">
                <p>First Name</p>
                <input type="text" class="form-control input_field_style" placeholder="Name" id="fname">
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Surname</p>
                <input type="text" class="form-control input_field_style" placeholder="Surname" id="lname">
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Email</p>
                <input type="email" class="form-control input_field_style" placeholder="expproject@gmail.com" aria-describedby="emailHelp" id="email">
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Password</p>
                <input type="password" class="form-control input_field_style" placeholder="Password" id="pword">
            </div>

            <div class="form-group form_group_style mx-auto">
                <p>Confirm password</p>
                <input type="password" class="form-control input_field_style" placeholder="Password">
            </div>

            <div class="form-group form_group_style mx-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="gdprCheckbox" required>
                    <label class="form-check-label" for="gdprCheckbox">
                        I agree to the <a href="terms_of_service.php">GDPR terms and conditions</a>
                    </label>
                </div>
                <button type="button" id="button_style" onclick="createAccount()">Continnue</button>
            </div>

            <p class="center_item">Already Signed Up? <a href="../pages/Login.php">SIGN IN HERE!</a></p>
        </form>
    </div>

    <?php include '../assets/footer.php'; ?>
</body>

</html>