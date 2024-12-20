<?php
    require_once "dbconnect.php";
    if(!isset($_SESSION))
    {
      session_start();
    }

    

    $sql ="select b.bookid, b.title, 
            a.author_name as author, 
            b.price, 
            p.publisher_name as publisher, 
            b.year, 
            c.category_name as category, 
            b.coverpath, 
            b.quantity
            from book b, category c, author a, publisher p 
            where 
            b.category = c.category_id AND
            b.author = a.author_id and 
            b.publisher = p.publisher_id; ";

    try{

    $stmt = $conn->query($sql);
    $status  = $stmt->execute();
    
    if ($status) //if execution is successful
    {
        
      $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    }catch(PDOException $e)
        {
            echo $e->getMessage();
        }


    // categories, publishers, authors

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
    }

      catch(PDOException $e)
      {
          echo $e->getMessage();
      }


      // for category search
      if(isset($_POST['ctySearch']))
      { // id which is user has selected 
        $id = $_POST['catgy'];

        try{
          $sql ="select b.bookid, b.title, 
            a.author_name as author, 
            b.price, 
            p.publisher_name as publisher, 
            b.year, 
            c.category_name as category, 
            b.coverpath, 
            b.quantity
            from book b, category c, author a, publisher p 
            where 
            b.category = c.category_id AND
            b.author = a.author_id and 
            b.publisher = p.publisher_id AND
            c.category_id = ? ";


          $stmt = $conn->prepare($sql);
          $stmt->execute([$id]);
          $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();

        }
      }

        // for author search
      if(isset($_POST['auSearch']))
      { // id which is user has selected 
        $id = $_POST['author'];

        try{
          $sql ="select b.bookid, b.title, 
            a.author_name as author, 
            b.price, 
            p.publisher_name as publisher, 
            b.year, 
            c.category_name as category, 
            b.coverpath, 
            b.quantity
            from book b, category c, author a, publisher p 
            where 
            b.category = c.category_id AND
            b.author = a.author_id and 
            b.publisher = p.publisher_id AND
            a.author_id = ? ";


          $stmt = $conn->prepare($sql);
          $stmt->execute([$id]);
          $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();

        }

      }

      // for publisher search
      if(isset($_POST['puSearch']))
      { // id which is user has selected 
        $id = $_POST['publisher'];

        try{
          $sql ="select b.bookid, b.title, 
            a.author_name as author, 
            b.price, 
            p.publisher_name as publisher, 
            b.year, 
            c.category_name as category, 
            b.coverpath, 
            b.quantity
            from book b, category c, author a, publisher p 
            where 
            b.category = c.category_id AND
            b.author = a.author_id and 
            b.publisher = p.publisher_id AND
            p.publisher_id = ? ";


          $stmt = $conn->prepare($sql);
          $stmt->execute([$id]);
          $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();

        }

      }

      // for price search (radio search)
      if(isset($_POST['prSearch']))
      { // id which is user has selected 
        $PriceRange = $_POST['PriceRange'];
        
        try{$sql ="select b.bookid, b.title, 
            a.author_name as author, 
            b.price, 
            p.publisher_name as publisher, 
            b.year, 
            c.category_name as category, 
            b.coverpath, 
            b.quantity
            from book b, category c, author a, publisher p 
            where 
              b.category = c.category_id AND
              b.author = a.author_id and 
              b.publisher = p.publisher_id AND
              b.price between ? and ?";

            $stmt = $conn->prepare($sql);
            

            if($PriceRange=='third')
            {
              $stmt -> execute([500,600]);
            }
            else if($PriceRange=='second')
            {
              $stmt -> execute([600,700]);
            }
            else{
              $stmt -> execute([700,800]);
            }

            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        catch(PDOException $e)
        {
          echo $e->getMessage();
        }



      }
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        nav.navbar {
            background-color: rgb(51, 155, 200);
            height: 70px; /* Adjust this value for desired height */
            padding: 15px 20px; /* Add padding for spacing */
        }

        body {
        margin: 0;
        padding: 0;
        background-color: #ebd9fa;
        }

        .container-fluid {
        margin: 0%;
        padding: 0%;
        }

        .sidebar {
        height: 100vh; /* Full viewport height */
        background-color:rgb(191, 133, 225); /* Sidebar background */
        padding-top: 40px;
        }

        .sidebar a {
        color: #000;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
        }

        .sidebar a:hover {
        background-color: #d9c4ee;
        }

        .content {
        padding-top: 10px;
       
        padding-bottom: 60px;
      
        }
  </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color:rgb(51, 155, 200);">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="./images/stack-of-books.png" alt="" style="width: 70%; height: auto;">
          Batch 100 Book Store 
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link"  href="#">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
                

            <li class="nav-item dropdown">
                <?php if(isset($_SESSION['adminLoginSuccess']))
                  {

                ?>
                <li class="nav-item">
                <a class="nav-link" href="adminLogout.php">Logout</a>
            </li>
              <?php 
              }
            ?>
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown </a>
            

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>

            </li>

            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>
      </ul>
      
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

  <div class="container-fluid">

        <div class="row">
            <!-- Sidebar -->
           <div class="col-md-2 sidebar">
                <div class ="navbar-nav ps-3">
                    <a class="nav-link"  href="viewbook.php">View Books</a>
                    <a class="nav-link" href="viewAuthor.php">View Authors</a>
                    <a class="nav-link" href="viewPublisher.php">View Publishers</a>
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"></a>

                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']  ?>"> 
                      <p class ="text-primary">Category</p>
                        <select name="catgy" class= "mt-3 form-select">
                          <?php

                              foreach($categories as $category)
                              {
                                echo "<option value=$category[category_id]> $category[category_name]
                                </option>";
                              }

                          ?>
                        </select>
                        <button type="submit" class="btn btn-outline-primary" name="ctySearch">Search</button>
                    </form>

                   
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']  ?>">
                      <p class ="text-primary">Author</p>
                          <select name="author" class= "mt-3 form-select">
                            <?php

                                foreach($authors as $author)
                                {
                                  echo "<option value=$author[author_id]> $author[author_name]
                                  </option>";
                                }

                            ?>
                          </select>
                          <button type="submit" class="btn btn-outline-primary" name="auSearch">Search</button>
                      </form>

                      <form method="post" action="<?php echo $_SERVER['PHP_SELF']  ?>">
                      <p class ="text-primary">Publisher</p>
                          <select name="publisher" class= "mt-3 form-select">
                            <?php

                                foreach($publishers as $publisher)
                                {
                                  echo "<option value=$publisher[publisher_id]> $publisher[publisher_name]
                                  </option>";
                                }

                            ?>
                          </select>
                          <button type="submit" class="btn btn-outline-primary" name="puSearch">Search</button>
                      </form>

                      <form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div>
                            <input type="radio" name="PriceRange" value="third" class="form-check-input">
                            <label class="form-check-label">Between 500 and 600</label>
                        </div>

                        <div>
                            <input type="radio" name="PriceRange" value="second" class="form-check-input">
                            <label class="form-check-label">Between 600 and 700</label>
                        </div>

                        <div>
                            <input type="radio" name="PriceRange" value="first" class="form-check-input">
                            <label class="form-check-label">Between 700 and 800</label>
                        </div>

                          <button input type = "submit" class="btn btn-outline-primary" name="prSearch">Search</button>

                      </form>

                    <?php
                    
                    ?>

                </div>
            </div>


            <!-- Main Content --> 
            <div class="col-md-10 content"> <!--<div class="col-md-10 col-sm-12 px-5"> -->
                <div calss="ph-3"><a href="insertBook.php" class="btn btn-outline-dark">Add new Book</a></div>

              <p>
                <?php 
                  if(isset($_SESSION['deleteSuccess'])){
                  echo "<span class =  'alert alert-success'> $_SESSION[deleteSuccess]</span>"; 
                  unset($_SESSION['deleteSuccess']);
                  }

                  if(isset($_SESSION['insertSuccess'])){
                  echo "<span class =  'alert alert-success'> $_SESSION[insertSuccess]</span>"; 
                  unset($_SESSION['insertSuccess']);
                  }

                  if(isset($_SESSION['updateBookSuccess'])){
                  echo "<span class =  'alert alert-success'> $_SESSION[updateBookSuccess]</span>"; 
                  unset($_SESSION['updateBookSuccess']);
                  }
            
            
                ?>
                
              </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Year</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Coverpath</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          if(isset(($books)))
                          {
                              foreach($books as $book)
                              {
                                  echo "<tr>
                                    <td>$book[bookid]</td>
                                    <td>$book[title]</td>
                                    <td>$book[price]</td>
                                    <td>$book[year]</td>
                                    <td>$book[author]</td>
                                    <td>$book[publisher]</td>
                                    <td>$book[category]</td>
                                    <td>$book[quantity]</td>
                                    <td>$book[coverpath]</td>

                                    <td><img src='$book[coverpath]' style ='width:60px; height:70px;'></td>
                                    <td><a href='editBook.php?bid=$book[bookid]' class='btn btn-info'>Edit</a></td>
                                    <td><a href='deletedBook.php?bid=$book[bookid]' class='btn btn-danger'>Delete</a></td>
                                    
                                    
                                  </tr>";
                              }
                          }
                        ?>

                    </tbody>

                </table>
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>