<?php

session_start();
include('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental Portal | Car Listing</title>
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
                <h1>Search Result of Keyword"<?php echo $_POST['searchdata']; ?>"</h1>
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
                <div class="col-md-9 col-md-push-3">
                    <div class="result-sorting-wrapper">
                        <div class="sorting-count">
                            <?php 
                            
                            $searchdata=$_POST['searchdata'];
                            $sql="SELECT tblvehicles.id FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand WHERE tblvehicles.VehiclesTitle=:search || tblvehicles.FuelType=:search || tblbrands.BrandName=:search || tblvehicles.ModelYear=:search";
                            $query= $dbh->prepare( $sql);
                            $query->bindParam(":search", $searchdata, PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = $query->rowCount(); 
                            ?>
                            <p><span><?php echo htmlentities($cnt); ?>Listings found</span></p>
                        </div>
                    </div>
                    <?php

                        $sql="SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id AS bid FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand WHERE tblvehicles.VehiclesTitle=:search || tblvehicles.FuelType=:search || tblbrands.BrandName=:search || tblvehicles.ModelYear=:search";
                        $query = $dbh ->prepare($sql);
                        $query -> bindParam(":search" , $searchdata,PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;

                        if($query->rowCount()> 0){

                            foreach($results as $result){


                    ?>

                    <div class="product-listing-m gray-bg">
                        <div class="product-listing-img"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image"/>
                    </div>
                    <div class="product-listing-content">
                        <h5><a href="vehicle-details.php?vhid=<?php echo htmlentities($result_id); ?>"><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                        <p class="list-price">Per Day<?php echo htmlentities($result->PricePerDay); ?>$</p>
                        <ul>
                            <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>Seats</li>
                            <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>Model</li>
                            <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                        </ul>
                        <a href="vehicle-details.php?vhid=<?php echo htmlentities($result-> id); ?>" class="btn">View Details<span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </section>

</body>

</html>