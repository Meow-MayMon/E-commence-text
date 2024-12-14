<?php
    require_once "dbconnect.php";
    if(!isset($_SESSION))
    {
      session_start();
    }

    if($_SESSION['isLogginedIn'])
  {
    session_destroy();
    header("Location:adminLogin.php");
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
                    <a class="nav-link"  href="viewBook.php">View Books</a>
                    <a class="nav-link" href="viewAuthor.php">View Authors</a>
                    <a class="nav-link" href="viewPublisher.php">View Publishers</a>
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">another</a>
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