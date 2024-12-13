<?php

    session_start();
    include('includes/config.php');
    //error_reporting(1);
    if(isset($_POST['submit']))
    {
        $fromdate=$_POST['fromdate'];
        $todate=$_POST['todate'];
        $message = $_POST['message'];
        $useremail=$_POST['login'];
        $status=0;
        $vhid = $_GET['vhid'];
        $bookingno= mt_getrandmax(100000000000,999999999999);
        $ret="SELECT * FROM tblbooking WHERE (:fromdate BETWEEN DATE(Fromdate) AND DATE(ToDate) || :todate BETWEEN date(FromDate) and DATE(ToDate) || date(FromDate) BETWEEN :fromdate and :todate) AND VehicleId=:vhid";
        $query1= $dbh->prepare($ret);
        $query1->bindParam(":vhid", $vhid, PDO::PARAM_STR);
        $query1->bindParam(":fromdate", $fromdate, PDO::PARAM_STR);
        $query->bindParam(":todate", $todate, PDO::PARAM_STR);
        $query1->execute();
        $results1= $query1->fetchAll(PDO::FETCH_OBJ);

        if($query1-> rowCount()==0) {

            $sql="INSERT INTO tblbooking(BookingNumber, userEmail,VehicleId,FromDate,ToDate, message, Status) VALUES(:bookingno, :useremail, :vhid, :fromdate, :todate, :message, :status)";
            

        }
    }
?>