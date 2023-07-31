<?php 
    include "../includes/php/functions.php";

    class Dashboard {
        
        function productsCount() {
            $query = "SELECT COUNT(*) FROM `medicines`;";
            return dbHandler($query);
        }

        function customersCount() {
            $query = "SELECT COUNT(*) FROM `customers`;";
            return dbHandler($query);
        }

        function totalSalesToday() {
            $query = "SELECT SUM(`total`) FROM `all_invoices_total` WHERE DATE(`date`) = CURDATE() AND type = 'Sale';";
            return dbHandler($query);
        }

        function totalReturnsToday() {
            $query = "SELECT SUM(`total`) FROM `all_invoices_total` WHERE DATE(`date`) = CURDATE() AND type = 'Return';";
            return dbHandler($query);
        }

        function totalExpensesToday() {
            $query = "SELECT SUM(`amount`) FROM `expenses` WHERE DATE(`date`) = CURDATE();";
            return dbHandler($query);
        }

        function nearExpiry() {
            $query = "SELECT COUNT(*) FROM `stock` WHERE `expiration_date` BETWEEN CURDATE() AND CURDATE() + INTERVAL 6 MONTH;";
            return dbHandler($query);
        }

    }