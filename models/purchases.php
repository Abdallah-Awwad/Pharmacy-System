<?php 
    include "../includes/php/functions.php";

    class Purchases {
        
        function index() {
            $query = "SELECT `inv_id`, `id`, `name`, `purchase_price`, `selling_price`, `expiration_date`, `quantity` FROM `stock`;";
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
            $products = json_decode($_POST['products']);
            $query = "INSERT INTO `inventory` (med_id, purchase_price, selling_price, expiration_date,  quantity)
                                VALUES (:medID, :purchasePrice, :sellingPrice, :expiration, :quantity);";
            $queryInputs = [":medID", ":purchasePrice", ":sellingPrice", ":expiration", ":quantity"];
            foreach($products as $product) {
                foreach ($queryInputs as $key => $value) {
                    $array[$value] = $product[$key];
                }
                dbHandler($query, $array);
            }
        }

        function getMedicinesInfo() {
            $query = "SELECT `id`, `name` FROM `medicines` ORDER BY id";
            return dbHandler($query);
        }

    }