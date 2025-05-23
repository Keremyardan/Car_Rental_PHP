<?php

session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['updateprofile'])) {

        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_POST['login'];
        $sql = "UPDATE tblusers SET FullName=:name,ContactNo=:mobileno,dob=:dob,Address=:address,City=:city,Country=:country, WHERE EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(":name", $name, PDO::PARAM_STR);
        $query->bindParam(":mobileno", $mobileno, PDO::PARAM_STR);
        $query->bindParam(":dob", $dob, PDO::PARAM_STR);
        $query->bindParam(":address", $address, PDO::PARAM_STR);
        $query->bindParam(":city", $city, PDO::PARAM_STR);
        $query->bindParam(":country", $country, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $msg = "Profile updated successfully!";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Car Rental Portal | My Profile</title>

        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">

        <link rel="stylesheet" href="assets/css/style.css" type="text/css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <link rel="stylesheet" id="switcher-css" text="text/css" href="assets/switcher/css/switcher.css" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all"
            data-default-color="true" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

        <link rel="apple-touch-icon-precomposed" sizes="144x144"
            href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114"
            href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="72x72"
            href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900">


        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>

    </head>

    <body>
        <?php include('includes/colorswitcher.php'); ?>
        <?php include('includes/header.php'); ?>

        <section class="page-header profile_page">
            <div class="container">
                <div class="page-header wrap">
                    <div class="page-heading">
                        <h1>Your Profile</h1>
                    </div>
                    <ul class="coustom-breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li>Profile</li>
                    </ul>
                </div>
            </div>
            <div class="dark-overlay"></div>
        </section>

        <?php

        $Sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
        $query = $dbh->prepare($Sql);
        $query->bindParam(":useremail", $useremail, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <section class="user_profile inner_pages">
                    <div class="container">

                        <div class="user_profile_info gray-bg padding_4x4_40">
                            <div class="upload_user_logo"><img src="assets/images/dealer-logo.jpg" alt="image">
                            </div>
                            <div class="dealer_info">
                                <h5><?php echo htmlentities($result->FullName); ?></h5>
                                <p><?php echo htmlentities($result->Address); ?> <br>
                                    <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country); ?>


                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <?php include('includes/sidebar.php'); ?>
                                <div class="col-md-6 col-sm-8">
                                    <div class="profile_wrap">
                                        <h5 class="uppercase underline">General Settings</h5>
                                        <?php
                                        if ($msg) { ?>
                                            <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                                        <?php } ?>
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="control-label">Reg Date -</label>
                                                <?php echo htmlentities($result->RegDate); ?>
                                            </div>
                                            <?php if ($result->UpdationDate != "") { ?>
                                                <div class="form-group">
                                                    <label class="control-label">Last Update at -</label>
                                                    <?php echo htmlentities($result->UpdationDate); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="control-label">Full Name</label>
                                                <input class="form-control white_bg" name="fullname"
                                                    value="<?php echo htmlentities($result->FullName); ?>" id="fullname" type="text"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Email Address</label>
                                                <input class="form-control white_bg" name="emailid"
                                                    value="<?php echo htmlentities($result->EmailId); ?>" id="email" type="email"
                                                    required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input class="form-control white_bg" name="mobilenumber"
                                                    value="<?php echo htmlentities($result->ContactNo); ?>" id="phone-number"
                                                    type="text" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date of Birth&nbsp;(dd/mm/yyyy)</label>
                                                <input class="form-control white_bg" name="dob"
                                                    value="<?php echo htmlentities($result->dob); ?>" id="birth-date" type="text"
                                                    placeholder="dd/mm/yyyy">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <textarea class="form-control white_bg" name="address" rows="4" <?php echo htmlentities($result->Address); ?>></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <input class="form-control white_bg" name="country"
                                                    value="<?php echo htmlentities($result->Country); ?>" id="country" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <input class="form-control white_bg" name="city"
                                                    value="<?php echo htmlentities($result->City); ?>" id="city" type="text">
                                            </div>
                                        <?php }
        } ?>
                                    <div class="form-group">
                                        <button type="submit" name="updateprofile" class="btn">Save Changes <span
                                                class="angle_arrow"><i class="fa fa-angle-right"
                                                    aria-hidden="true"></i></span></button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <?php include('includes/footer.php'); ?>

        <div id="back-top" class="back-top"><a href="#top"><i class="fa fa-angle-up"></i></a></div>

        <?php include('includes/login.php'); ?>
        <?php include('includes/registration.php'); ?>
        <?php include('includes/forgotpassword.php'); ?>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/interface.js"></script>
        <script src="assets/switcher/js/switcher.js"></script>
        <script src="assets/js/bootstrap-slider.min.js"></script>
        <script src="assets/js//slick.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>

    </body>

    </html>

<?php } ?>