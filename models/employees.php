<?php 
    include "../includes/php/functions.php";

    class Employees {
        
        function index() {
            $query = "SELECT * FROM `employees`";
            return dbHandler($query);
        }

        function show() {
            $query = "SELECT * FROM `employees` WHERE `id` = :id;";
            return dbHandler($query, [':id' => $_POST['employeeID']]);
        }

        function remove() {
            $query = "DELETE FROM employees WHERE id = :id";
            return dbHandler($query, [':id' => $_POST['employeeID']]);
        }
        
        function update() {
            $query = "UPDATE `employees` 
                        SET `name`          = :name, 
                            `phone`         = :phone,
                            `gender`        = :gender,
                            `age`           = :age,
                            `address`       = :address,
                            `salary`        = :salary
                        WHERE `id`          = :id;";
            $queryInputs = [":id", ":name", ":phone", ":gender", ":age", ":address", ":salary"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function add() {
            $query = "INSERT INTO `employees` (`name`, `phone`, `gender`, `age`, `address`,`salary`) VALUES (:name, :phone, :gender, :age, :address ,:salary)";
            $queryInputs = [":name", ":phone", ":gender", ":age", ":address", ":salary"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }
    }