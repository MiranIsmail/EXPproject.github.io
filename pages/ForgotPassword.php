<?php include '../assets/navbar.php'; ?>

<body>
    <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->
    <div class="image_div">
        <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
    </div>

    <div class="section w-100 content_container">
        <h1> Welcome!</h1>
        <form action="../api/src/TokenGateway.php" method="post">
            <div class="form-group form_group_style mx-auto">
                <p>Enter your Email address</p>
                <input type="email" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group form_group_style mx-auto">
                <input type="submit" value="Send a Reset Password Link To Email">
            </div>
        </form>
        <?php
            if (isset($_GET["reset"])) {
                if ($_GET["reset"] == "success") {
                    echo '<p color="green">Check your e-mail!</p>';
                }
            }
        ?>
    </div>
    <?php include '../assets/footer.php'; ?>
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>
</body>

</html>
