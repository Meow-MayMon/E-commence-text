<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if($_SESSION['isLoggedIn']){
        session_destroy();
        header("Location: adminLogin.php");
    }




?>