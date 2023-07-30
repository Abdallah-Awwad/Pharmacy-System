<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/inventory.php";
    ini_set("log_errors", TRUE);
    ini_set("error_log", "errors.log");

    if ($_POST["process"] == "inventory") {
        try {
            echo json_encode(createObject("Inventory", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("INV-0", $e);
        }
    }