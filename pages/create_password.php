<?php
include '../assets/head.php';
?>

<body>
  <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->
    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
    </div>
    <div class="section content_container order-1">
        <h1> Please choose your password</h1>

        <div class="form-group form_group_style mx-auto">
            <p>Password</p>
            <input type="password" class="form-control input_field_style" placeholder="Password" id="pword">
        </div>

        <div class="form-group form_group_style mx-auto">
            <p>Confirm password</p>
            <input type="password" class="form-control input_field_style" placeholder="Password">
        </div>

        <div class="form-group form_group_style mx-auto">
            <button type="button" id="button_style" onclick="createAccount()">Sign up</button>
        </div>
        <p class="center_item">Already Signed Up? <a href="../Login.php">SIGN IN HERE!</a></p>
        </form>
    </div>

    <?php include '../assets/footer.php'; ?>
</body>

<!--footer-->

</html>