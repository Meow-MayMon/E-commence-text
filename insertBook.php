<?php
    require_once"dbconnect.php";
    try
        {
            $sql ="select * from category";
            $stmt = $conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Print_r($categories); 
        }
    catch(PDOException $e)
        {
            echo $e->getMessage();
        }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insert Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg" style="background-color: #BFECFF;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="./images/stack-of-books.png" alt="" style="width: 10%; height: auto;">
          Batch 100 Book Store 
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link"  href="#">Home</a>
            <a class="nav-link" href="#">Features</a>
            <a class="nav-link" href="#">Pricing</a>
            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>

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
  <div class="container-fluid bg-light">

        <div class="row">

            <div class="col-md-2 col-sm-12 border" style="background-color:#ebd9fa">
                Some Links
            </div>

            <div class="col-md-9 pt-5">
                <a href="insertBook.php">Add new Book</a>
            
                <form>
                    <div class="col-lg-6 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">    
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price">    
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity">    
                    </div>

                    <select class="form-select" name="category">
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
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                            
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>