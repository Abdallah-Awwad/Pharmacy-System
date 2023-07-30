<?php 
    include "../includes/php/functions.php";

    class Inventory {
        
        function index() {
            $query = "SELECT * FROM `stock`";
            return dbHandlerV2($query);
        }
    }