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
    <?php include '../assets/footer.php'; ?>
</body>

</html>