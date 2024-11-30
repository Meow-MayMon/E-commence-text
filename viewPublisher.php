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

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Publishers</title>
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
                    background-color:#ebd9fa;
                

                }
                .sidebar {
                    height: 90vh; /* Full viewport height */
                    background-color:rgb(214, 171, 239); /* Sidebar background */
                    padding-top: 40px;
                }

                .sidebar a {
                
                    color:rgb(15, 135, 131);
                    text-decoration: none;
                    display: block;
                    padding: 20px 30px;
                }

                .sidebar a:hover {
                    background-color:rgb(77, 82, 232);
                
                }

                .content {
                    padding: 20px;
                    margin-top: 4%;
            
                }
        </style>

    </head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color:rgb(51, 155, 200);">
        <div class="container-fluid" >
                <a class="navbar-brand" href="#"><img src="./images/stack-of-books.png" alt="" style="width: 70%; height: auto;">
                Batch 100 Book Store 
                </a>
        
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup" >
      
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
                <div class="col-md-10 content">
                    <h1 class ="text-center mb-4"> Publishers List</h1>
                    
                    <table class ="table table-striped">
                        <thread>
                            <tr>
                                <td>Publisher ID</td>
                                <td>Publisher Name</td>
                                <td>Address</td>
                                <td>Phone</td>
                            </tr>
                        </thread>

                        <tbody>
                            <?php
                            if (isset($publishers))
                            {
                                foreach($publishers as $publisher)
                                {
                                    echo "<tr>
                                            <td>{$publisher['publisher_id']}</td>
                                            <td>{$publisher['publisher_name']}</td>
                                            <td>{$publisher['address']}</td>
                                            <td>{$publisher['phone']}</td>
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