<?php
require_once "dbconnect.php";


if(isset($_SESSION))
{
    session_start();
}

$dbconn= $conn;

function getInfo($id)
{
    global $dbconn;
    $sql = "select * from book where bookid = ?;";
    $stmt = $dbconn -> prepare($sql);
    $stmt -> execute([$id]);
    $book = $stmt->fetch();
    return $book;
}

    if($_SERVER['REQUEST_METHOD']=="post" && $_POST['update'])
    {
        echo "button summit";
    }

    if(isset($_POST['update']));

    {
        $ids = $_POST['id'];
        $quantities = $_POST['qty'];
        $cart = array();
        foreach($ids as $id=>$val)
        {
            $cart [$val]=$quantities['$id'];
        }
        foreach($cart as $key=> $value)
        {
            $total = 0;
            $book = getInfo($key);
            $amt = $book['price']*$value;
            $total += $amt;
            echo "$key, $book['price'], $val, $amt<br>";
        }
        echo $total; 
    }
?>


<!doctype html>
             <html lang="en">
                 <head>
                     <meta charset="utf-8">
                     <meta name="viewport" content="width=device-width, initial-scale=1">
                     <title>Book Information</title>
                     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                 </head>
               <body>
                 <nav class="navbar navbar-expand-lg" style="background-color: #BFECFF;">
                 <div class="container-fluid">
                     <a class="navbar-brand" href="#"><img src="./images/stack-of-books.png" alt="" style="width: 10%; height: auto;"></a>
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                     <div class="navbar-nav">
                         <a class="nav-link" href="#">Home</a>
                         <a class="nav-link" href="#">Features</a>
                         <a class="nav-link" href="#">Pricing</a>
                         
                         <?php 
                         
                             if(isset($_SESSION['is_logged_in'])){
                         
                         ?>
             
                         <a class="nav-link" href="cLogout.php">Logout</a>
                         <p class="text-dark"> <?php echo $_SESSION['cemail'] ?> </p>
                         
                         
                         <?php 
                         if (isset($_SESSION['cart']))
                         {
                            echo "<a href=viewCart.php class='btn btn-outline-primary mx-4'><Cart</a>";
                         }
                             
                             }
                         ?>
                     </div>
                     </div>
                 </div>
                 </nav>
             
                     <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-3 border" style="background-color: #BFECFF;" >
                             <div class="navbar-nav ps-3">
                                 <?php if(isset($_SESSION['is_logged_in'])) { ?>
                                     <a class="nav-link"  href="viewCustomerBooks.php">view Customber Books</a>
                                     <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <label for="">Category</label>
                                <select name="catgy" class="mt-3 form-select">
                                <?php
                                    
                                    foreach($categories as $category){
                                        echo "<option value=$category[category_id]>$category[category_name]</option>";
                                    }
                                ?>
                                >
                            </select>

                            <button type="submit" name="ctySearch" class="btn btn-outline-primary mt-3">Search</button>
                        </form>


                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <label for="">Authors</label>
                                <select name="author" class="mt-3 form-select">
                                <?php
                                    
                                    foreach($authors as $author){
                                        echo "<option value=$author[author_id]>$author[author_name]</option>";
                                    }
                                ?>
                                >
                            </select>
                            
                            <button type="submit" name="auSearch" class="btn btn-outline-primary mt-3">Search</button>
                        </form>

                       

                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <label for="">Publishers</label>
                                <select name="publisher" class="mt-3 form-select">
                                <?php
                                    
                                    foreach($publishers as $publisher){
                                        echo "<option value=$publisher[publisher_id]>$publisher[publisher_name]</option>";
                                    }
                                ?>
                                
                            </select>
                            
                            <button type="submit" name="pubSearch" class="btn btn-outline-primary mt-3">Search</button>
                        </form>

                        <!-- choose price range -->
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="radio" name="priceRange" value="third" class="form-check-input">
                            <label for="" class="form-check-label text-primary">$50 - $100</label><br>
                            <input type="radio" name="priceRange" value="second" class="form-check-input">
                            <label for="" class="form-check-label text-primary">$101 - $150</label><br>
                            <input type="radio" name="priceRange" value="frist" class="form-check-input">
                            <label for="" class="form-check-label text-primary">$151 - $200</label><br>
                            <button type="submit" class="btn btn btn-outline-primary" name="priceSearch">Search</button>
                        </form>
                        
                        
                    <?php } ?>
                </div>

            </div>
            <div class="col-md-9 pt-5" style="background-color: rgb(255, 246, 227);">
                <div class="col-md-10 col-sm-12 px5">
                    <div class="pb-5">
                        <a href="insertBook.php">Add new Book</a>
                    </div>

                    <div class ="row">
                        <div class = "col-md-6">
                            <table class="table table-striped">
                                <?php 
                                    $cart = $_SESSION['cart']; ?>
                                        <from action = "<?php echo $_SERVER['PHP_SELF'] ?>" method ="post">
                                    <?php
                                    foreach($cart as $id)
                                    {
                                        $book = getInfo($id);
                                        ?>
                                            <form action="">
                                                <tr>
                                                    <input type ="hidden" name="id" value="<?php echo $book['bookid']; ?>">
                                                    <td><?php echo $book['title']; ?></td>
                                                    <td><?php echo $book['price'];?></td>
                                                    <td><input type = "number" name="qty" value=""></td>
                                                </tr>
                                            </form>

                                    <?php
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <input colspan=2 type ="submit" name="update" value="update" class="btn btn-outline-primary">
                                    </td>
                                </tr>

                                </form>
                            </table>

                        </div>

                        <div calss="col-md-4">
                            <table>
                                
                            </table>

                        </div>


                    </div>
                    
                </div>
                    
            


            </div>
        </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>