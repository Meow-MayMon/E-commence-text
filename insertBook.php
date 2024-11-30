<?php
    require_once "dbconnect.php";
    if(!isset($_SESSION))
    {
        session_start();
    }
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

    if(isset($_POST['insert'])){

        $title = $_POST["title"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $year = $_POST["year"];
        $publisher = $_POST["publisher"];
        $category = $_POST["category"];
        $author = $_POST["author"];
        $filename = $_FILES['bookcover']['name'];
        // store images
        $uploadPath = "covers/".$filename; 
        
        //store uploaded files to destinated server in a specificed folder 
        move_uploaded_file($_FILES["bookcover"]["tmp_name"], $uploadPath);

        try{

            $sql = "insert into book (title, author, price, publisher, year, category, coverpath, quantity) values (?,?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$title, $author, $price, $publisher, $year, $category, $uploadPath, $quantity]);

            $book_id = $conn->lastInsertId();
            if($status)
            {
                $_SESSION['insertSuccess']="Book with bookid has been inserted.";
                header("Location:viewBook.php");
                
            }

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
  <title>Insert Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <style>
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
        padding-top: 60px;
        padding-left: 10px;
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
            
            <form method="post" action ="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                  <div class ="row mb-3">

                          <div class="col-lg-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title">    
                        </div>

                        <div class="col-lg-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price">    
                        </div>
                  </div>

                  <div class ="row mb-3">
                        <div class="col-lg-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity">    
                        </div>
                  
                        <div class ="col-lg-6">
                            <label for ="quantity" class="form-label">Category</label>
                            <select class="form-select mb-3" name="category">
                                <option selected>Choose Category</option>
                                <?php if(isset($categories))
                                    {
                                        foreach($categories as $category)
                                        {
                                            echo  "<option value=$category[category_id]>
                                                $category[category_name]</option>";
                                        }
                                    
                                    }
                                ?>
                            </select> 
                        </div>
                    </div>
                    
                    <div class ="row mb-3">
                        <div class ="col-lg-6">
                        <label for ="publisher" class="form-label">Publisher</label>
                          <select class="form-select mb-3" name="publisher">
                                <option selected>Choose Publisher</option>
                                <?php if(isset($publishers))
                                    {
                                        foreach($publishers as $publisher)
                                        {
                                            echo  "<option value=$publisher[publisher_id]>
                                                $publisher[publisher_name]</option>";
                                        }
                                    
                                    }
                                ?>
                            </select>
                        </div> 

                        <div class ="col-lg-6">
                          <label for ="author" class="form-label">Author</label>
                            <select class="form-select mb-3" name="author">
                                <option selected>Choose Author</option>
                                <?php if(isset($authors))
                                    {
                                        foreach($authors as $author)
                                        {
                                            echo  "<option value=$author[author_id]>
                                                $author[author_name]</option>";
                                        }
                                    
                                    }
                                ?>
                            </select> 
                        </div>
                    </div>

                    
                    <div class ="row mb-3">
                        <div class="col-lg-6">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" class="form-control" name="year">    
                        </div>

                        <div class="col-lg-6">
                            <label for="bookcover" class="form-label">Choose Book Cover</label>
                            <input type="file" class="form-control" name="bookcover">    
                        </div>
                    </div>
                    

                    <button type="submit" class="btn btn-outline-dark" name="insert" >Submit</button>
                </form>
                            
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>