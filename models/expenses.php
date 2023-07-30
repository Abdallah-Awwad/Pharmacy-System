<?php 
    include "../includes/php/functions.php";

    class Expenses {
        
        function index() {
            $query = "SELECT * FROM `expenses`";
            return dbHandlerV2($query);
        }

        function show() {
            $query = "SELECT * FROM `expenses` WHERE `id` = :id;";
            return dbHandlerV2($query, [':id' => $_POST['expenseID']]);
        }

        function remove() {
            $query = "DELETE FROM expenses WHERE id = :id";
            return dbHandlerV2($query, [':id' => $_POST['expenseID']]);
        }
        
        function update() {
            $query = "UPDATE `expenses` 
                        SET `name`          = :expenseName, 
                            `description`   = :descr,
                            `amount`        = :amount,
                            `category`      = :category
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":expenseName", ":descr", ":amount", ":category"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandlerV2($query, $array);
        }

        function add() {
            $query = "INSERT INTO `expenses` (`name`, `description`, `amount`, `category`) VALUES (:name, :desc, :amount, :category)";
            $queryInputs = [":name", ":desc", ":amount", ":category"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandlerV2($query, $array);
        }
    }