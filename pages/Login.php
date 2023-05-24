<?php
include '../assets/head.php';
?>

<body>
    <?php include '../assets/navbar.php'; ?>
    <!--The swimrun image-->
    <form action="../assets/organization_request.php" class="" method="GET">
        <div class=" form-group form_group_style mx-auto">

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightOrg" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Register your organization</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body canvas_container" id="org_canvas_container">
                    To make sure you are an organization, we would like you to fill this form:
                    <div class="form-group form_group_style mx-auto needs-validation" novalidate>
                        <div class="form-group form_group_style mx-auto"></div>
                        <p>Organization name</p>
                        <input type="text" name="org_name" class="form-control input_field_style" placeholder="Name" id="org_name" required>

                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Address</p>
                        <input type="text" name="address" class="form-control input_field_style" placeholder="Region of domain" id="org_country" required>

                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Email Address for organization </p>
                        <input type="email" name="org_email" class="form-control input_field_style" placeholder="expproject@gmail.com" id="org_email" required>
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Organization number </p>
                        <input type="text" name="org_number" class="form-control input_field_style" placeholder="111111-0000" id="org_number" required>
                    </div>
                    <h2>Contact information</h2>
                    <div class="form-group form_group_style mx-auto">
                        <p>Private Email Address </p>
                        <input type="text" name="contact_email" class="form-control input_field_style" placeholder="expproject@gmail.com" id="private_email" required>
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <p>Phone Number </p>
                        <input type="tel" name="number" class="form-control input_field_style" placeholder="" id="phone_number" required>
                    </div>
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                        Form submitted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="form-group form_group_style mx-auto">
                        <button class="btn btn-primary" button id="submit_org_form" type="submit" value="Submit">Submit form</button>
                    </div>
                    After submission we will as soon as possible get back to you to give you more information on how to set up your organizational account. We will be in touch!
                </div>
            </div>
        </div>
    </form>

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
                    <div class="row form-group form_group_style mx-auto" style="margin-top:30px">
                        <div class="col-sm-6">
                            <p class="" style="padding-left: 1rem;"><a href="../pages/ForgotPassword.php">Forgot your password? </a></p>
                        </div>
                        <div class="col-sm-6">
                        <p class="left_item" style="padding-left: 1rem; text-decoration: underline; cursor: pointer" ><a href="../pages/SignUp.php">Don't have an account? Click here </a></p>
                        </div>
                    </div>

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
                    <div class="row form-group form_group_style mx-auto" style="margin-top:30px">
                        <div class="col-sm-6">
                            <p class="" style="padding-left: 1rem;"><a href="../pages/ForgotPassword.php">Forgot your password? </a></p>
                        </div>
                        <div class="col-sm-6">
                        <p class="left_item" style="padding-left: 1rem; text-decoration: underline; cursor: pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightOrg" aria-controls="offcanvasRight">How do I register my organization?</p>
                        </div>
                    </div>
                    
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