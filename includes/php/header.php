<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header('location:profile_login');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../languages/en.php" ?>
    <?php include "title.php" ?>
    <meta charset="UTF-8">
    <meta name="description" content="Pharmacy system using native PHP">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="icon" href="imgs/drugs.png" type="image/x-icon">
    <!-- CSS Files -->
    <link rel="stylesheet" href="includes/css/all.min.css">
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/main.css">
    <!-- For sorting table -->
    <link rel="stylesheet" href="includes/css/dataTables.bootstrap4.min.css">
    <script src="includes/js/jquery-3.5.1.min.js"></script>
    <!-- SweetAlert -->
    <link rel="stylesheet" href="includes/css/sweet-alert.min.css">
    <script src="includes/js/sweet-alert.min.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="pharmacy-brand">
                <a href="dashboard" class="text-decoration-none">
                    <h1>Pharmacy</h1>
                </a>
            </div>
            <div>
                <span><?= $_SESSION['name'] ?></span>
            </div>
        </div>
    </nav>
  <?php include "sidebar.php" ?>
  <?php include "dbConnection.php" ?>
  <?php include "functions.php" ?>