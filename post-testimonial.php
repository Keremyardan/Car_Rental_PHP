<?php

session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $testimonial = $_POST['testimonial'];
        $email = $_SESSION['login'];
        $sql = "INSERT INTO tbltestimonial(UserEmail,Testimonial) VALUES(:email,:testimonial)";
        $query = $dbh->prepare($sql);
        $query->bindParam(":testimonial", $testimonial, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Testimonial submitted successfully.";
        } else {
            $error = "Something went wrong";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Car Rental Portal | Post Testimonial</title>

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
                <div class="page-header_wrap">
                    <div class="page-heading">
                        <h1>Post Testimonial</h1>
                    </div>
                    <ul class="coustom-breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li>Post Testimonial</li>
                    </ul>
                </div>
            </div>
            <div class="dark-overlay"></div>
        </section>

        <?php

        $useremail = $_SESSION['login'];
        $sql = 'SELECT * FROM tblusers WHERE EmailId=:useremail';
        $query = $dbh->prepare($sql);
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
                                <p><?php echo htmlentities($result->Address); ?>
                                    <br>
                                    <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country);
            }
        } ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <?php include('includes/sidebar.php'); ?>
                        <div class="col-md6 col-sm-8">
                            <div class="profile_wrap">
                                <h5 class="uppercase underline">
                                    Post a Testimonial
                                </h5>
                                <?php if ($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                                <?php } elseif ($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                                <?php } ?>
                                <form method="post">
                                    <div class="form-group">
                                        <label class="control-label">Testimonial</label>
                                        <textarea class="form-control white-bg" name="testimonial" rows="4"
                                            required=""></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn">Save <span class="angle_arrow"><i
                                                    class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <?php include('includes/footer.php') ?>

        <div id="back-top" class="back-top"><a href="#top"> <i class="fa fa-angle-up" aria-hidden="true"></i></a></div>

        <?php include('includes/login.php') ?>

        <?php include('includes/registration.php') ?>

        <?php include('includes/forgotpassword.php') ?>




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