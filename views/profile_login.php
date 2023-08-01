<?php
    include "../languages/en.php";
    include "../includes/php/title.php";
    session_start();
    if (isset($_SESSION['id'])) {
        header('location:dashboard');
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
        <link rel="icon" href="imgs/drugs.png" type="image/x-icon">
        <link rel="stylesheet" href="includes/css/bootstrap.min.css">
        <link rel="stylesheet" href="includes/css/main.css">
    </head>
    <body>
        <div class="login-page">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card border-0 shadow rounded-3 my-5">
                            <div class="p-4 p-sm-5">
                                <h1 class="title card-title text-center mb-5"><?= $lang["Login"] ?></h1>
                                <form method="" action="" autocomplete="off">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Admin" required>
                                        <label for="username"><?= $lang["Username"] ?></label>
                                    </div>
                                    <div class="form-floating my-4">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        <label for="password"><?= $lang["Password"] ?></label>
                                    </div>
                                    <div class="d-grid mt-4 mb-4">
                                        <button class="btn add-btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="submit" id="submitButton" onclick="login(); return false;">
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
<script src="includes/js/jquery-3.5.1.min.js"></script>
<script src="includes/js/main.js"></script>
<script src="includes/js/jquery.dataTables.min.js"></script>
<script>
    let inputs = document.querySelectorAll("input, textarea, select");
    function login() {
        if (!$('form')[0].checkValidity()) {
            $('form')[0].reportValidity();
            return;
        }
        let bindValues = {
                'process': 'login'
            }
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
        requestAjax(bindValues, profilesControllerURL, function (result) {
            if (result === "Success") {
                window.location.href = " ";
            } else {
                $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
            }
        });
    }
</script>