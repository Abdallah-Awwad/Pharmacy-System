<?php
    include "../includes/php/dbConnection.php";
    include "../languages/en.php";
    include "../includes/php/title.php";
    session_start();
    if (isset($_SESSION['id'])) {
        header('location:dashboard');
    }
    if (isset($_POST['submit'])) {
        if (isset($_POST['username'],$_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
                $query = "SELECT * FROM members WHERE username = :username";
                $stmt = $conn->prepare($query);
                $params = ['username'=>$username];
                $stmt->execute($params);
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $result['password'])) {
                        unset($result['password']);
                        $_SESSION = $result;
                        header('location:dashboard');
                        exit();
                    } else {
                        $errors[] = "Wrong Username or Password";
                    }
                } else {
                    $errors[] = "Wrong Username or Password";
                }
        } else {
            $errors[] = "Username and Password are required";	
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Pharmacy system using native PHP">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $pageTitle ?></title>
        <link rel="icon" href="../imgs/drugs.png" type="image/x-icon">
        <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
        <link rel="stylesheet" href="../includes/css/main.css">
    </head>
    <body>
        <div class="login-page">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card border-0 shadow rounded-3 my-5">
                            <div class="p-4 p-sm-5">
                                <h1 class="title card-title text-center mb-5"><?= $lang["Login"] ?></h1>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'];?>" autocomplete="off">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Admin">
                                        <label for="username"><?= $lang["Username"] ?></label>
                                    </div>
                                    <div class="form-floating my-4">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        <label for="password"><?= $lang["Password"] ?></label>
                                    </div>
                                    <?php 
                                        if (isset($errors) && count($errors) > 0) {
                                            foreach ($errors as $error_msg) {
                                                echo '<div class="alert alert-danger">'.$error_msg.'</div>';
                                            }
                                        }
                                    ?>
                                    <div class="d-grid mt-4">
                                        <button class="btn add-btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="submit">
                                            <?= $lang["Login"] ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>