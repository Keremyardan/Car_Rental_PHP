<?php

session_start();
include('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Car Listing</title>

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


</head>

<body>

    <?php include('includes/colorswitcher.php'); ?>
    <?php include('includes/header.php'); ?>


    <section class="page-header listing_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                    <h1>Car Listing</h1>
                </div>
                <ul class="coustom-breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Car Listing</li>
                </ul>
            </div>
        </div>
        <div class="dark-overlay"></div>
    </section>

    <section class="listing-page">
        <div class="container">
            <div class="row">

                <div class="col-md-0 col-md-push-3">
                    <div class="result-sorting-wrapper">
                        <div class="sorting-count">
                            <?php

                            $brand = $_POST['brand'];
                            $fueltype = $_POST['fueltype'];
                            $sql = "SELECT id FROM tblvehicles WHERE tblvehicles.VehiclesBrand=:brand AND tblvehicles.FuelType=:fueltype";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(":brand", $brand, PDO::PARAM_STR);
                            $query->bindParam(":fueltype", $fueltype, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = $query->rowCount();

                            ?>
                            <p><span><?php echo htmlentities($cnt); ?></span></p>
                        </div>
                    </div>

                    <?php

                    $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id AS bid FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand WHERE tblvehicles.VehiclesBrand=:brand AND tblvehicles.FuelType=:fueltype";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(":brand", $brand, PDO::PARAM_STR);
                    $query->bindParam(":fueltype", $fueltype, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>

                            <div class="oroduct-listing-m gray-bg">
                                <div class="product-listing-img"><img
                                        src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                        class="img-responsive" alt="image" />
                                </div>
                                <div class="pdoruct-listing-content">
                                    <h5><a href="vehicle-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?>,
                                            <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                                    <p class="list-price">Per Day<?php echo htmlentities($result->PricePerDay); ?>$</p>
                                    <ul>
                                        <li><i class="fa fa-user"
                                                aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>seats
                                        </li>
                                        <li><i class="fa fa-calendar"
                                                aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>model</li>
                                        <li><i class="fa fa-car"
                                                aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                                    </ul>
                                    <a href="vehicle-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View
                                        Details<span class="angle_arrow"><i class="fa fa-angle-right"
                                                aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>

                <aside class="col-md-3 col-md-pull-9">
                    <div class="sidebar_widget">
                        <div class="widget_heading">
                            <h5><i class="fa fa-filter" aria-hidden="true"></i>Find Your Car</h5>
                        </div>
                        <div class="sidebar_filter">
                            <form action="#" method="get">
                                <div class="form-group select">
                                    <select class="form-control">
                                        <option>Select Brand</option>

                                        <?php

                                        $sql = "SELECT * FROM tblbrands";

                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {

                                            foreach ($results as $result) { ?>

                                                <option value="<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->BrandName); ?>
                                                </option>
                                            <?php }
                                        } ?>


                                    </select>
                                </div>
                                <div class="form-group select">
                                    <select class="form-control">
                                        <option>Select Fuel Type</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="CNG">CNG</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block"><i class="fa fa-search"
                                            aria-hidden="true"></i>Search Car</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="sidebar_widget">
                        <div class="widget_heading">
                            <h5><i class="fa fa-car" aria-hidden="true"></i>Recently Listed Cars</h5>
                        </div>
                        <div class="recent_addedcars">
                            <ul>
                                <?php
                                $sql = "SELECT tblvehicles.*,tblbrands,BrandName,tblbrands.id AS bid FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand ORDER BY id DESC LIMIT 4";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {

                                        ?>

                                        <li class="gray-bg">
                                            <div class="recent_post_img"><a
                                                    href="vehicle-details.php?vhid=<?php echo htmlentities($result->id) ?>"><img
                                                        src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                                        alt="image"></a></div>
                                            <div class="recent_post_title"><a
                                                    href="vehicle-details.php?vhid<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?>,
                                                    <?php echo htmlentities($result->VehiclesTitle); ?></a>
                                                <p class="widget_price">Per Day<?php echo htmlentities($result->PricePerDay); ?>
                                                </p>
                                            </div>
                                        </li>

                                    <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <div id="back-top" class="back-top"><a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a></div>

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