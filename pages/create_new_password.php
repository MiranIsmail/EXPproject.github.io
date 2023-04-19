<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password - Rasts</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</head>
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
                <p>Enter your New Password</p>
                <input type="password" id="password_reseted" placeholder="New Password" name="password">
            </div>
            <div class="form-group form_group_style mx-auto">
                <p>Confirm New Password</p>
                <input type="password" id="confirm_password_reseted" placeholder="Confirm Password" name="confirm password">
            </div>
            <div class="form-group form_group_style mx-auto">
                <input type="submit" value="Reset Password" onclick="">
            </div>
        </form>
    </div>
    <?php include '../assets/footer.php'; ?>
</body>

</html>
