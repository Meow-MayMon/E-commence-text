<?php
    require_once "dbconnect.php";

    if(!isset($_SESSION)){
        session_start();
    }

if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (strlen($password) > 7) {
        try {
            $sql = "SELECT password from customer2 where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($info) {
                $password_hash = $info["password"];
                
                if (password_verify($password, $password_hash)) {
                    $_SESSION['cloginSuccess'] = "Login Success";
                    $_SESSION['cemail'] = $email;
                    $_SESSION['is_logged_in'] = true;
                    header("Location: viewCustomerBooks.php");
                } else {
                    $password_err = "Email or password does not exist";
                }
            } else {
                $password_err = "Email or password does not exist";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        } // end catch
    } // str len if end
    else {
        $password_err = "Email or password might be wrong";
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
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            max-width: 450px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .form-control {
            border-radius: 25px;
        }

        .btn-primary {
            border-radius: 25px;
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .logo {
            display: block;
            margin: 0 auto 15px auto;
            width: 80px;
            height: auto;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .form-footer a {
            text-decoration: none;
            color: #007bff;
        }

        .form-footer a:hover {
            text-decoration: underline;
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
        <div class="row">
            <div class="col-md-10">
                <h4 class="p-20">Login</h4>
                <!-- <a href="insertbook.php" class="text-decoration-none bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Add New Book</a> -->
                <form method="POST" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <?php if (isset($password_err)) {
                        echo "<span class='alert alert-danger'>$password_err</span>";
                    } ?>
                    <div class="mb-3 col-lg-4">

                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
            </div>

            <div class="row">
                <div class="mb-3 col-lg-4">

                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <button type="submit" name="login" class="btn btn-primary text-sm">Login</button>
                <p>
                    If you are not a member, you can
                    <a href="customerSignup.php">
                        Sign Up
                    </a>
                    here
                </p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>