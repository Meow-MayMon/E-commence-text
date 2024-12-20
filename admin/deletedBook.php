<?php
require_once "dbconnect.php";
if(!isset($_SESSION))
{
    session_start();    //to create succes if not exist 
}

    if(isset($_GET['bid']))
    {   
        $book_id =$_GET['bid'];
        $sql ="delete from book where bookid = ?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$book_id]);

        if ($status)
        {
            $_SESSION['deleteSuccess']="Book with $book_id has been deleted.";
            header("Location:viewBook.php");
        }

    }
?>