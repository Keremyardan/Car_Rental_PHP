<?php

    session_start();
    error_reporting(1);
    include('includes/config.php');

    if(isset($_POST['send'])) {
        $name=$_POST['fullname'];
        
    }

?>