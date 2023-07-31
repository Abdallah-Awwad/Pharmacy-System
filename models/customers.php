<?php 
    include "../includes/php/functions.php";

    class Customers {
        
        function index() {
            $query = "SELECT * FROM `customers`";
            return dbHandler($query);
        }

        function show() {
            $query = "SELECT * FROM `customers` WHERE `id` = :id;";
            return dbHandler($query, [':id' => $_POST['customerID']]);
        }

        function remove() {
            $query = "DELETE FROM customers WHERE id = :id";
            return dbHandler($query, [':id' => $_POST['customerID']]);
        }
        
        function update() {
            $query = "UPDATE customers SET `name` = :name , `gender` = :gender , `phone` = :phone, `address` = :address WHERE id = :id";
            $queryInputs = [":id", ":name", ":gender", ":phone", ":address"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function add() {
            $query = "INSERT INTO customers (`name`, `gender`, `phone`, `address`) 
                        VALUES (:name, :gender, :phone, :address)";
            $queryInputs = [":name", ":gender", ":phone", ":address"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }
    }