<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/purchases.php";

    if ($_POST["process"] == "readAllPurchases") {
        try {
            echo json_encode(createObject("Purchases", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("PU-0", $e);
        }
    }

    if ($_POST["process"] == "readAllMedicinesNames") {
        try {
            echo json_encode((createObject("Purchases", "getMedicinesInfo")[0]));
        } catch (Exception $e) {
            errorMsgHandler("PU-1", $e);
        }        
    }
    
    if ($_POST["process"] == "createPurchaseInvoice") {
        try {
            createObject("Purchases", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("PU-2", $e);
        }
    }