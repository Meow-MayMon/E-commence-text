<?php
    require_once "dbconnect.php";
    $sql ="select * from customer 
    where income >=30000
    order by income desc limit 20";

    try{

    $stmt = $conn->query($sql);
    $status  = $stmt->execute();
    
    if ($status)
    {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Batch 100 Book Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
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
    <div calss="container-fluid border bg-light"> 
        <div class="row">

            <div class="col-md-3 border bg-light">
                some links
            </div>
            <div class="col-md-9 bg-secondary">
                <table class = "table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gender</th>
                            <th>Income</th>
                            <th>Marital</th>
                            <th>Vehicales</th>
                            <th>Age</th>
                            <th>State</th>
                        </tr>;
                    </thead>
                    <tbody>
                        <?php
                        if(isset(($rows)))
                        {
                            foreach($rows as $row)
                            {
                                echo "<tr>
                                    <td>$row[custid]</td>
                                    <td>$row[sex]</td>
                                    <td>$row[income]</td>
                                    <td>$row[marital_stat]</td>
                                    <td>$row[num_vehicles]</td>
                                    <td>$row[age]</td>
                                    <td>$row[stat]</td>
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