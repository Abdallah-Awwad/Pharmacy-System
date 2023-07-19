<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../languages/en.php";?>
    <?php include "title.php";?>
    <meta charset="UTF-8">
    <link rel="icon" href="../imgs/drugs.png" type="image/x-icon">
    <meta name="description" content="Pharmacy system using native PHP">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <!-- Adding CSS Files -->
    <link rel="stylesheet" href="../includes/css/all.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/main.css">
    <!-- For sorting table -->
    <link rel="stylesheet" href="../includes/css/cdn.datatables.net_1.10.22_css_dataTables.bootstrap4.min.css">
    <!-- Adding Jquery for sorting tables  -->
    <script src="../includes/js/jquery-3.5.1.min.js"></script>
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
                <span>Testing</span>
            </div>
        </div>
    </nav>
  <?php include "../includes/php/sidebar.php";?>
  <?php include "../includes/php/dbconnection.php";?>
  <?php include "../includes/php/functions.php";?>