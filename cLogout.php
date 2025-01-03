<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if($_SESSION['is_logged_in'])
    {
        session_destroy();
        header("Location: customerlogin.php");
    }




?>