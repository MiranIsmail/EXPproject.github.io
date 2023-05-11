<?php
include '../assets/head.php';
?>

<body>
    <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->
    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run">
    </div>

    <div class="section w-100 content_container">
        <h1> Welcome back!</h1>
        <div class="mx-auto form_group_style row">
            <div class="col-sm-6 padding_bottom_half" style="padding: left 10px;">
                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#user" aria-expanded="true" aria-controls="collapseExample" checked>
                <label class="btn btn-secondary w-100" for="option1">Log in as user</label>
            </div>
            <div class="col-sm-6 padding_bottom_half">
                <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#org" aria-expanded="false" aria-controls="collapseExample">
                <label class="btn btn-secondary w-100" for="option2">Log in as organization</label>
            </div>

        </div>
        <div>
            <div class="collapse log_in_user show drop_shadow mx-auto" id="user">
                <h3>Athletes</h3>
                <form>
                    <div class="form-group form_group_style mx-auto">
                        <p>Email address</p>
                        <input type="email" class="form-control input_field_style" aria-describedby="emailHelp" placeholder="Enter email" id="fetchEmail">
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Password</p>
                        <input type="password" class="form-control input_field_style" placeholder="Password" id="fetchPword">
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <button type="button" id="button_style" onclick="log_in()">Sign in</button>
                    </div>
                    <p class="center_item">Forgot password? <a href="../pages/ForgotPassword.php">CLICK HERE!</a></p>
                    <p class="center_item">Don't have an account? <a href="../pages/SignUp.php">SIGN UP HERE!</a></p>
                </form>
            </div>

            <div class="collapse log_in_organisation drop_shadow mx-auto" id="org">
                <h2>Organization</h2>
                <form>
                    <div class="form-group form_group_style mx-auto">
                        <p>Email address</p>
                        <input type="email" class="form-control input_field_style" aria-describedby="emailHelp" placeholder="Enter email" id="fetchEmailOrg">
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Password</p>
                        <input type="password" class="form-control input_field_style" placeholder="Password" id="fetchPwordOrg">
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <button type="button" id="button_style" onclick="log_in_org()">Sign in</button>
                    </div>
                    <p class="center_item">Forgot password? <a href="../pages/ForgotPassword.php">CLICK HERE!</a></p>
                    <p class="center_item">Don't have an account? <a href="../pages/SignUp.php">SIGN UP HERE!</a></p>
                </form>
            </div>
        </div>
    </div>
    <?php include '../assets/footer.php'; ?>

    <script>
        const option1 = document.getElementById("option1");
        const option2 = document.getElementById("option2");
        const user = document.getElementById("user");
        const org = document.getElementById("org");

        option2.addEventListener("click", function() {
            if (!org.classList.contains("show")) {
                user.classList.remove("show");
            }
        });

        option1.addEventListener("click", function() {
            if (!user.classList.contains("show")) {
                org.classList.remove("show");
            }
        });
    </script>
</body>

</html>