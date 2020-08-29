<?php
$host = 'localhost';
$user = 'root';
$password = '';

$dbName = 'register';


try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbName",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo "Error to connect for database";
}



if (isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

$notesOnPage = 3;



$from = ($page - 1) * $notesOnPage;

$sql = "SELECT * FROM users LIMIT $from,$notesOnPage";

$arr = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

 


$sql = "SELECT COUNT(*) as count  FROM users";
$count = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
$count = $count['count'];

$pagesCount = ceil($count  / $notesOnPage);




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pagination</title>
</head>
<body>

<div class="container mt-4">
    <div class="card-deck">
        <?php
        foreach ($arr as $value){ ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?=$value['login'] ?></h5>
                    <p class="card-text">User Name: <?=$value['name'] ?> </p>
                    <p class="card-text">User Password: <small class="text-muted"><?=$value['password'] ?></small></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-4">
            <?php

            if ($page > 1){
                $isPrev = '';
            } else {
                $isPrev = 'disabled';
            }

            $prev = $page - 1;
            echo  "<li class=\"page-item $isPrev\"><a class=\"page-link\" href=\"?page=$prev\" tabindex=\"-1\" aria-disabled=\"true\">Previous</a></li>";


            for ($i = 1; $i <= $pagesCount; $i++){
                if ($i == $page) {
                $class = 'active';
                }  else {
                $class = '';
                }
                echo "<li class=\"page-item $class\"><a class=\"page-link \" href=\"?page=$i\">$i</a></li>";
            }


            if ($page < $pagesCount ){
                $isNext = '';
            } else {
                $isNext = 'disabled';
            }

            $next = $page + 1;
            echo  "<li class=\"page-item $isNext\"><a class=\"page-link\" href=\"?page=$next\" tabindex=\"-1\" aria-disabled=\"true\">Next</a></li>";

            ?>

        </ul>
    </nav>
</div>

</body>
</html>



