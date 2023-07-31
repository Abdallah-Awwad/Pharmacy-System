<?php 
    include "../includes/php/functions.php";

    class Medicines {
        
        function index() {
            $query = "SELECT medicines.id, medicines.name, manufacturers.name AS manufactory_name  -- fix name
                    FROM `medicines` 
                    JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id";
            return dbHandler($query);
        }

        function show() {
            $query = "SELECT medicines.*, manufacturers.name AS manufacture_name 
                    FROM `medicines` 
                    JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id
                    WHERE medicines.id = :id
                    LIMIT 1";
            return dbHandler($query, [':id' => $_POST['medicineID']]);
        }

        function remove() {
            $query = "DELETE FROM medicines WHERE id = :id";
            return dbHandler($query, [':id' => $_POST['medicineID']]);
        }
        
        function update() {
            $query = "UPDATE `medicines` 
                    SET `name`= :medName, 
                        `manufacture_id` = :manuID 
                    WHERE `id` = :id;";
            $queryInputs = [":id", ":medName", ":manuID"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function add() {
            $query = "INSERT INTO medicines (`name`, `manufacture_id`) VALUES (:name, :manuID)";
            $queryInputs = [":name", ":manuID"];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($_POST)[$key + 1];
            }
            return dbHandler($query, $array);
        }

        function getManufacturesInfo() {
            $query = "SELECT `id`, `name` FROM `manufacturers`";
            return dbHandler($query);
        }
    }