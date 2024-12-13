<?php

session_start();
include('includes/config.php');
//error_reporting(1);
if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_POST['login'];
    $status = 0;
    $vhid = $_GET['vhid'];
    $bookingno = mt_getrandmax(100000000000, 999999999999);
    $ret = "SELECT * FROM tblbooking WHERE (:fromdate BETWEEN DATE(Fromdate) AND DATE(ToDate) || :todate BETWEEN date(FromDate) and DATE(ToDate) || date(FromDate) BETWEEN :fromdate and :todate) AND VehicleId=:vhid";
    $query1 = $dbh->prepare($ret);
    $query1->bindParam(":vhid", $vhid, PDO::PARAM_STR);
    $query1->bindParam(":fromdate", $fromdate, PDO::PARAM_STR);
    $query->bindParam(":todate", $todate, PDO::PARAM_STR);
    $query1->execute();
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    if ($query1->rowCount() == 0) {

        $sql = "INSERT INTO tblbooking(BookingNumber, userEmail,VehicleId,FromDate,ToDate, message, Status) VALUES(:bookingno, :useremail, :vhid, :fromdate, :todate, :message, :status)";
        $query1->bindParam(":bookingno", $bookingno, PDO::PARAM_STR);
        $query1->bindParam(":useremail", $useremail, PDO::PARAM_STR);
        $query1->bindParam(":vhid", $vhid, PDO::PARAM_STR);
        $query1->bindParam(":fromdate", $fromdate, PDO::PARAM_STR);
        $query1->bindParam(":todate", $todate, PDO::PARAM_STR);
        $query1->bindParam(":message", $message, PDO::PARAM_STR);
        $query1->bindParam(":status", $status, PDO::PARAM_STR);
        $query1->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('Booking successful.');</script>";
            echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
        } else {
            echo "<script> alert('Seomething went wrong!'); </script>";
            echo "<script type='text/javascript'> document.location ='car-listing.php';</script>";
        }
    } else {
        echo "<script>alert('Car already booked for that date range!');</script>";
        echo "<script type='text/javascript'> document.location ='car-listing.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Vehicle Details</title>

    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" type="text/css">

    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">

    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">

    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" type="text/css">

    <link rel="stylesheet" href="assets/css/slick.css">

    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />

    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" media="all" title="red"
        data-default-color="true" />

    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" media="all" title="orange" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" media="all" title="blue" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" media="all" title="pink" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" media="all" title="green" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" media="all" title="purple" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>


    <?php include('includes/colorswitcher.php') ?>

    <?php include('includes/header.php') ?>

    <?php

    $vhid = intval($_GET['vhid']);
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id AS bid FROM tblvehicles JOIN tblbrands on tblbrands.id=tblvehicles.VehiclesBrand WHERE tblvehicles.id=:vhid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['brandid'] = $result->bid;

            ?>

            <section id="listing-img-slider">
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive"
                        alt="image" width="900" height="560"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" class="img-responsive"
                        alt="image" width="900" height="560"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" class="img-responsive"
                        alt="image" width="900" height="560"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" class="img-responsive"
                        alt="image" width="900" height="560"></div>

                <?php

                if ($result->Vimage5 == "") {

                } else {

                    ?>



                    <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive"
                            alt="image" width="900" height="560"></div>

                <?php } ?>

            </section>

            <section class="listing-detail">
                <div class="container">
                    <div class="listing_detail_head row">
                        <div class="col-md-9">
                            <h2><?php echo htmlentities($result->BrandName); ?>,
                                <?php echo htmlentities($result->VehiclesTitle); ?></h2>
                        </div>
                        <div class="col-md-3">
                            <div class="price_info">
                                <p><?php echo htmlentities($result->PricePerDay); ?>$</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="main_features">
                                <ul>
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <h5><?php echo htmlentities($result->ModelYear); ?></h5>
                                        <p>Reg. Year</p>
                                    </li>
                                    <li><i class="fa fa-cogs" aria-hidden="true"></i>
                                        <h5><?php echo htmlentities($result->FuelType); ?></h5>
                                        <p>Fuel Type</p>
                                    </li>
                                    <li><i class="fa fa-user-plus" aria-hidden="true"></i>
                                        <h5><?php echo htmlentities($result->SeatingCapacity); ?></h5>
                                        <p>Seats</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="listing_more_info">
                                <div class="listing_detail_wrap">
                                    <ul class="nav nav-tabs gray-bg" role="tablist">
                                        <li role="presentation" class="active"><a href="#veihcle-overview"
                                                aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle
                                                Overview</a></li>
                                        <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab"
                                                data-toggle="tab">Accessories</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                                            <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="accessories">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Accessories</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Air Conditioner</td>
                                                        <?php if ($result->AirConditioner == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td>Anti Lock Breaking System</td>
                                                        <?php if ($result->AntiLockBreakingSystem == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Power Steering</td>
                                                        <?php if ($result->PowerSteering == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Power Windows</td>
                                                        <?php if ($result->PowerWindows == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>CD Player</td>
                                                        <?php if ($result->CDPlayer == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Leather Seats</td>
                                                        <?php if ($result->LeatherSeats == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Central Locking</td>
                                                        <?php if ($result->CentralLocking == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Power Door Locks</td>
                                                        <?php if ($result->PowerDoorLocks == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Break Assist</td>
                                                        <?php if ($result->BreakAssist == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Driver Airbag</td>
                                                        <?php if ($result->DriverAirbag == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Passenger Airbag</td>
                                                        <?php if ($result->PassengerAirbag == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Crash Sensor</td>
                                                        <?php if ($result->CrashSensor == 1) {
                                                            ?>
                                                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
    } ?>
                </div>
                
            </div>
        </div>
    </section>



</body>

</html>