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
        <form action="../assets/organization_request.php" class="orgform" method="GET>
            <div class=" form-group form_group_style mx-auto">
            <button class="button-modular" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Want to register your organisation?</button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Register your organisation</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body canvas_container">
                    To make sure you are an organisation, we would like you till fill this form:
                    <div class="form-group form_group_style mx-auto needs-validation" novalidate>
                        <div class="form-group form_group_style mx-auto"></div>
                        <p>Organisation name</p>

                        <input type="text" name="org_name" class="form-control input_field_style" placeholder="Name" id="org_name" required>

                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Country</p>
                        <input type="text" name="Country" class="form-control input_field_style" placeholder="Region of domain" id="org_country" required>

                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Email Address for organisation </p>
                        <input type="email" name="org_email" class="form-control input_field_style" placeholder="expproject@gmail.com" id="org_email" required>
                    </div>
                    <h2>Contact information</h2>
                    <div class="form-group form_group_style mx-auto">
                        <p>Private Email Address </p>
                        <input type="text" name="contact_email" class="form-control input_field_style" placeholder="expproject@gmail.com" id="user_email" required>
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Phone Number </p>
                        <input type="tel" name=" number" class="form-control input_field_style" placeholder="+46" id="user_email" required>
                    </div>
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                        Form submitted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <button class="btn btn-primary" button id="submit_org_form" type="submit" onclick="fill_org_form()" value="Submit">Submit form</button>
                    </div>
                    After submission we will as soon as possible get back to you to give you more information on how to set up your organisational account. We will be in touch!
                </div>
            </div>
    </div>
    </form>
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
            <button type="button" id="button_style" onclick="createAccount()">Continnue</button>
        </div>
        <p class="center_item">Already Signed Up? <a href="../pages/Login.php">SIGN IN HERE!</a></p>
    </form>
    </div>

    <?php include '../assets/footer.php'; ?>
    <script type="text/javascript" src="../scripts/js_scripts.js"></script>


    <script>
        // Add event listener for form submission
        document.getElementsByClassName("orgform").addEventListener("submit", function(event) {
            // Prevent default form submission behavior
            event.preventDefault();
            // Show success alert
            document.getElementById("success-alert").classList.remove("d-none");

            submit_button = document.getElementById("submit_org_form");
            submit_button.setAttribute('disabled', '')
        });
    </script>
    <!--footer-->

</body>

</html>