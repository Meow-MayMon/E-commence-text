<?php
    require_once "dbconnect.php";
    if(!isset($_SESSION))
    {
        session_start();
    }
    
    if(!isset($_SESSION)){
        session_start(); // to create session if not exist
    }
    
    function ispasswordstrong($password) {
        if(strlen($password) < 8){
            return false;
        }elseif(isstrong($password)){
            return true;
        }
    }
    
    function isstrong($password){
        $digitcount = 0;
        $capitalcount = 0;
        $speccount = 0;
        $lowercount = 0;
        foreach(str_split($password) as $char){
            if(is_numeric($char)){
                $digitcount++;
            }elseif(ctype_upper($char)){
                $capitalcount++;
            }elseif(ctype_lower($char)){
                $lowercount++;
            }elseif(ctype_punct($char)){
                $speccount++;
            }
        }
    
        if($digitcount >= 1 && $capitalcount >=1 && $speccount >= 1){
            return true;
        }else{
            return false;
        }
    }

    if(isset($_POST['signup']) && $_SERVER['REQUEST_METHOD']=="POST")
    {

        $username = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $phone= $_POST["phone"];
        $filename = $_FILES['profile']['name'];
        // store images
        $uploadPath = "profile/".$filename; 

        if ($password == $cpassword)
        { 
            if(ispasswordstrong($password))
            {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                //store uploaded files to destinated server in a specificed folder 
                move_uploaded_file($_FILES["profile"]["tmp_name"], $uploadPath);

            try
            {

                $sql ="insert into customer2 (username, password, email, phone, profile)
                 values (?, ? ,?, ? ,?)";
                 $stmt = $conn->prepare($sql);
                 $status = $stmt-> execute([$username, $password_hash, $email, $phone, $uploadPath]);

                 if($status)
                 { 
                    $_SESSION['signupSuccess']="Signup Success!!";
                    header("Location: customerLogin.php");
                 }

                }catch(PDOException $e)

                    {
                        echo $e-> getMessage();
                    }
                }
            
                else
                {
                    $password_err = "Password must contain at least one digit, one capital letter and one special char.";

                }

            }
            else
                {
                    $password_err ="Password must be at least 8 char long";
                }
        
    }

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up</title>
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
        background-color:rgb(171, 121, 211);
        

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
        
        padding-top: 60px;
        padding-left: 10px;
        padding-bottom: 60px;
      
        }
  </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color:rgb(6, 165, 233);">
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
    

            <div calss ="col-md-10 col-sm12 px-5">
                <a><h4 class="bg-secondary text-center"> Sign Up </h4> </a>
            </div>
            <!-- Main Content --> 
            <!--<div class="col-md-10 content"> <div class="col-md-10 col-sm-12 px-5"> -->
            <!--    <div calss="ph-3"><a href="insertBook.php" class="btn btn-outline-dark">Add new Book</a></div> -->
            
            <form method="post" action ="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                  <div class ="row mb-3">

                          <div class="col-lg-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name">    
                        </div>

                        <div class="col-lg-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">    
                        </div>
                  </div>

                  <div class ="row mb-3">
                        <div class="col-lg-6">
                            <label for="cpassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="cpassword">    
                        </div>

                        <div class="col-lg-6">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password">    
                        </div>
                </div>
                  
                        
                    <div class ="row mb-3">

                        <div class ="col-lg-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="phone" class="form-control" name="phone">   

                        </div>

                        <div class ="col-lg-6">
                            <label for="profile" class="form-label">Select Your Profile Photo</label>
                            <input type="file" class="form-control" name="profile">    
                        </div> 

                    </div>

    
                    <button type="submit" class="btn btn-outline-dark" name="signup" >Sign Up</button>
                </form>
                            
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>