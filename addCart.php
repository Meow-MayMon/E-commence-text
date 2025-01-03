<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if (!isset($_SESSION['cart']))
    {
        header("Location:customerLogin.php");

    }
    else if(isset($_SESSION['cart']) && isset($_GET['id']))
    {
        $cart = $_SESSION['cart'];
        $id = $_GET['id'];
        if(!in_array($id,$cart)){
            array_push($cart, $_GET['id']);
            $_SESSION['cart']=$cart;

        }
    }

    else {
        $id=$_GET['id'];
        $cart= array();
        array_push($cart,$id);

    }

    print_r($cart);
?>