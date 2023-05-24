<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password - Rasts</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="../images/logo_color.png">
    <!--Tre librarys dont remove, Bootstrap 5-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="1028296111112-0dfp9jds49j0a3nr942ui74lachcl9os.apps.googleusercontent.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://apis.google.com/js/api.js"></script>
    <link rel="stylesheet" href="../styles/stylesheet.css">
    <link rel="stylesheet" href="../styles/login_and_signup.css">
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
                <p>Click the button bellow to confirme your email</p>
            </div>
            <div class="form-group form_group_style mx-auto">
            <input type="submit" value="Confirme you email" onclick="email_confirmed(event)">
            <p id="responde"> </p>
            </div>
        </form>
    </div>
    <?php include '../assets/footer.php'; ?>
</body>

</html>
