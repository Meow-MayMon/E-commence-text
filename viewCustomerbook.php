<?php

    require_once "dbconnect.php";

    if(!isset($_SESSION)){
        session_start();
    }


    $sql = "select b.bookid, b.title, a.author_name as author, b.price,
                        p.publisher_name as publisher,
                        b.year, c.category_name as category , 
                        b.coverpath, b.quantity
                        from book b , category c, author a , publisher p
                        where 
                        b.category = c.category_id AND 
                        b.author = a.author_id  and 
                        b.publisher = p.publisher_id;";

    try{
        $stmt = $conn->query($sql); 
        $status = $stmt->execute();
        
        if ($status) //if execution is successful
        {
        
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            
        }
    }catch(PDOException $e){
        echo $e->getMessage();

    }

    //categories, publishers, authors, 
    try{
        $sql = "select * from category";
        $stmt = $conn->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($categories); check query work

        $sql = "select * from publisher";
        $stmt = $conn->query($sql);
        $publishers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "select * from author";
        $stmt = $conn->query($sql);
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo $e->getMessage();  

    }


    //for category search
    if(isset($_POST['ctySearch'])){
        //id which user has selected
        $id = $_POST['catgy'];
        
        try{
            $sql = "select b.bookid, b.title, a.author_name as author, b.price,
                        p.publisher_name as publisher,
                        b.year, c.category_name as category , 
                        b.coverpath, b.quantity
                        from book b , category c, author a , publisher p
                        where 
                        b.category = c.category_id AND 
                        b.author = a.author_id  and 
                        b.publisher = p.publisher_id AND 
                        c.category_id=?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){

            echo $e->getMessage();
        }
    }

    //for author

    if(isset($_POST['auSearch'])){
        //id which user has selected
        $id = $_POST['author'];
        
        try{
            $sql = "select b.bookid, b.title, a.author_name as author, b.price,
                        p.publisher_name as publisher,
                        b.year, c.category_name as category , 
                        b.coverpath, b.quantity
                        from book b , category c, author a , publisher p
                        where 
                        b.category = c.category_id AND 
                        b.author = a.author_id  and 
                        b.publisher = p.publisher_id AND 
                        a.author_id=?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){

            echo $e->getMessage();
        }
    }

    //for publisher
    if(isset($_POST['pubSearch'])){
        //id which user has selected
        $id = $_POST['publisher'];
        
        try{
            $sql = "select b.bookid, b.title, a.author_name as author, b.price,
                        p.publisher_name as publisher,
                        b.year, c.category_name as category , 
                        b.coverpath, b.quantity
                        from book b , category c, author a , publisher p
                        where 
                        b.category = c.category_id AND 
                        b.author = a.author_id  and 
                        b.publisher = p.publisher_id AND 
                         p.publisher_id=?";
                         $stmt = $conn->prepare($sql);
                         $stmt->execute([$id]);
                         $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
             
                     }catch(PDOException $e){
             
                         echo $e->getMessage();
                     }
                 }//publisher select box ends
             
                 //radio search
             
                 if(isset($_POST['priceSearch'])){
                     $priceRange = $_POST['priceRange'];
             
                     try{
             
                         $sql = "select b.bookid, b.title, a.author_name as author, b.price,
                                     p.publisher_name as publisher,
                                     b.year, c.category_name as category , 
                                     b.coverpath, b.quantity
                                     from book b , category c, author a , publisher p
                                     where 
                                     b.category = c.category_id AND 
                                     b.author = a.author_id  and 
                                     b.publisher = p.publisher_id AND 
                                      b.price between ? and ?";
             
                                      $stmt = $conn->prepare($sql);
                                      
             
                         if($priceRange == 'third')
                             {
                                 $stmt->execute([50,100]);
                             }else if($priceRange == 'second')
                             {
                                 $stmt->execute([101,150]);
                             }else{
                                 $stmt->execute([150,200]);
                             }
             
                            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
             
                     }catch(PDOException $e){
                         echo $e->getMessage();
                     }
             
                             
             
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
                                >
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
                    
                </div>
                    <p >
                        <?php

if(isset($_SESSION['cloginSuccess'])){
  echo "<span class='w-screen alert alert-success'>$_SESSION[cloginSuccess]</span> " ; 
  unset($_SESSION['cloginSuccess']);
}// if ends

if(isset($books)){
  echo "<div class=row>";
  foreach($books as $book){

      echo "<div class=col-lg-2 col-md-6 col-sm-12>

              <div class=card h-100 card-deck style=height:26rem;>
                  <img src=$book[coverpath] class=img-fluid card-img-top style='height:12rem; object-fit:cover;'>
                      <div class=card-body>
                          <div class=card-title>
                              $book[title]
                          </div>

                          <div class=card-text>
                              $book[price] &nbsp; $book[publisher] &nbsp; $book[author]
                          </div>

                          <div class=card-text>$$book[price] &nbsp; &nbsp;$book[publisher]</div>
                        <a href='addCart.php?id=$book[bookid]' style=background:#32a4a8;>Add To Cart</a>
                      </div>
              </div>
          </div>
      "
    ?>
 <?php }

}

echo "</div>";

?>

</p>


</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>