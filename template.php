<!-- template.php -->

<!DOCTYPE html>
<html lang="en">
<!-- Your common head content goes here -->

<!-- Mirrored from www.Legatordigitalpro.com/?a=account by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Dec 2023 12:14:04 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Title -->
    <title>Legator Mining Room</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="1/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="1/assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="1/assets/css/lime.min.css" rel="stylesheet">
    <link href="1/assets/css/custom.css" rel="stylesheet">
    <link rel="icon" href="images/logo.png"
		sizes="32x32" />

    <script language="javascript">
        showGetMessage = function (getData, getValue, message, alert) {
            // Get the URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const errorParam = urlParams.get(getData);

            // Show alert if the 'error' parameter is present and has the value 'username_exists'
            if (errorParam === getValue) {
                // document.write("<div class='alert alert-danger' role='alert'> invalid username and password </div>");
                showErrorMessage(message, alert);
            }
        };
    </script>
    <script language="javascript">
        // errorHandling.js

        window.showErrorMessage = function (message, alertClass) {
            var errorMessage = document.getElementById("error-message");
            var errorText = document.getElementById("error-text");

            // Remove existing classes
            errorMessage.classList.remove("alert-success", "alert-warning", "alert-danger");

            // Set the new class based on the provided alertClass
            if (alertClass === "success") {
                errorMessage.classList.add("alert-success");
            } else if (alertClass === "warning") {
                errorMessage.classList.add("alert-warning");
            } else {
                // Default to danger if the class is not recognized
                errorMessage.classList.add("alert-danger");
            }

            errorText.innerHTML = message;
            errorMessage.style.display = "block";
        };

        window.closeErrorMessage = function () {
            var errorMessage = document.getElementById("error-message");
            errorMessage.style.display = "none";
        };

    </script>

    <?php
    include("auth/get_user_details.php");
    ?>
</head>

<body>
    <?php require 'nav.php';?>
    <div class="lime-container">
        <div class="lime-body">
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Display an error message -->
                                <div id="error-message" class="error-message alert alert-danger">
                                    <span id="error-text"></span>
                                    <span class="close-btn" onclick="closeErrorMessage()">&times;</span>
                                </div>
                                <?php include $pageContent; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lime-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="footer-text">2023 © Legator Digital Dashboard</span>
                </div>
            </div>
        </div>
    </div>



    <!-- Javascripts -->
    <script src="1/assets/plugins/jquery/jquery-3.1.0.min.js"></script>
    <script src="1/assets/plugins/bootstrap/popper.min.js"></script>
    <script src="1/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="1/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="1/assets/plugins/chartjs/chart.min.js"></script>
    <script src="1/assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
    <script src="1/assets/js/lime.min.js"></script>
    <script src="1/assets/js/pages/dashboard.js"></script>
</body>
<script src="../code.tidio.co_443/9quipgijvkwhsexreqqfpjeri9h4jp0o.js" async></script>

<!-- Mirrored from www.Legatordigitalpro.com/?a=withdraw by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Dec 2023 12:14:14 GMT -->


</html>