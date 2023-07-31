<?php 
    include "../includes/php/functions.php";

    class Profiles {
        
        function login() {
            $query = "SELECT * FROM members WHERE username = :username";
            return dbHandler($query,  [':username' => $_POST['username']]);
        }

        function logout() {
            session_start();
            if (isset($_SESSION)) {
                session_destroy();
                return;
            }
        }

        function index() {
            $query = "SELECT `id`, `name`, `phone`, `username`, `role`, `created_at`, `updated_at` FROM `members`";
            return dbHandler($query);
        }

        function show() {
            $query = "SELECT * FROM `members` WHERE `id` = :id;";
            return dbHandler($query, [':id' => $_POST['profileID']]);
        }

        function canRemove() {
            $query = "SELECT COUNT(*) FROM `members` WHERE `role` = 'Administrator';";
            $result = dbHandler($query)[0][0];
            if ($result["COUNT(*)"] == 1) {
                $query = "SELECT `role` FROM `members` WHERE `id` = :id;";
                $result = dbHandler($query, [':id' => $_POST['profileID']])[0];
                if ($result[0]["role"] == "Administrator") {
                    return "You can't delete the last Admin!";
                }
            }
        }

        function remove() {
            $query = "DELETE FROM members WHERE id = :id";
            return dbHandler($query, [':id' => $_POST['profileID']]);
        }

        function update() {
            $query = "UPDATE `members` 
                SET `name`= :name, 
                    `phone` = :phone, 
                    `phone` = :phone, 
                    `username` = :username, 
                    `password` = :password, 
                    `role` = :role
                WHERE `id` = :id;";
            $queryInputs = [":id", ":name", ":phone", ":username", ":password", ":role"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function add() {
            $query = "INSERT INTO members (`name`, `phone`, `username`, `password`, `role`) 
                        VALUES (:name, :phone, :username, :password, :role)";
            $queryInputs = [":name", ":phone", ":username", ":password", ":role"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }
    }