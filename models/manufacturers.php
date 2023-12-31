<?php 
    include "../includes/php/functions.php";

    class Manufacturers {
        
        function index() {
            $query = "SELECT * FROM `manufacturers`";
            return dbHandler($query);
        }

        function show() {
            $query = "SELECT * FROM `manufacturers` WHERE `id` = :id;";
            return dbHandler($query, [':id' => $_POST['manufacturerID']]);
        }

        function remove() {
            $query = "DELETE FROM manufacturers WHERE id = :id";
            return dbHandler($query, [':id' => $_POST['manufacturerID']]);
        }
        
        function update() {
            $query = "UPDATE `manufacturers` 
                        SET `name`          = :name, 
                            `address`       = :address,
                            `phone`         = :phone
                        WHERE `id`          = :id;";
            $queryInputs = [":id", ":name", ":address", ":phone"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function add() {
            $query = "INSERT INTO `manufacturers` (`name`, `address`, `phone`) VALUES (:name, :address, :phone)";
            $queryInputs = [":name", ":address", ":phone"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }
    }