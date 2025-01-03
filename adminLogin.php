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
            $sql = "SELECT password from admin where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($info) {
                $password_hash = $info["password"];
                if (password_verify($password, $password_hash)) {
                    $_SESSION['adminloginSuccess'] = "Login Success";
                    $_SESSION['isLoggedIn'] = true;
                    header("Location: viewBooks.php");
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: cornflowerblue; color: white">
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
        </div>
        </div>
    </div>
    </nav>
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 border" style="background-color: #BFECFF;" >
                <div class="navbar-nav ps-3">
                    <?php if(isset($_SESSION['isLoggedIn'])) { ?>
                        <a class="nav-link"  href="viewBooks.php">view Books</a>
                        <a class="nav-link" href="viewAuthors.php">View Authors</a>
                        <a class="nav-link" href="viewPublishers.php">View Publisher</a>
                    <?php } ?>
                </div>

            </div>
    
            <div class="col-md-10">
                <h4 class="p-20">Admin Login</h4>
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