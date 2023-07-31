<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/inventory.php";

    if ($_POST["process"] == "inventory") {
        try {
            echo json_encode(createObject("Inventory", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("INV-0", $e);
        }
    }