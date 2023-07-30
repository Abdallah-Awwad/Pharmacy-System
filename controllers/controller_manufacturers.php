<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/manufacturers.php";
    ini_set("log_errors", TRUE);
    ini_set("error_log", "errors.log");

    if ($_POST["process"] == "readAllManufacturers") {
        try {
            echo json_encode(createObject("Manufacturers", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("MA-0", $e);
        }
    }

    if ($_POST["process"] == "readManufacturer") {
        try {
            echo json_encode((createObject("Manufacturers", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("MA-1", $e);
        }        
    }
    
    if ($_POST["process"] == "addManufacturer") {
        if (empty($_POST["manufacturerName"])) {
            echo "Name can't be empty";
            return;
        }
        if (empty($_POST["manufacturerPhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["manufacturerPhone"]) && ! is_numeric($_POST["manufacturerPhone"])) {
            echo "invalid phone number";
            return;
        }
        try {
            createObject("Manufacturers", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("MA-2", $e);
        }
    }

    if ($_POST["process"] == "editManufacturer") {
        if (empty($_POST["manufacturerName"])) {
            echo "Name can't be empty";
            return;
        }
        if (empty($_POST["manufacturerPhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["manufacturerPhone"]) && ! is_numeric($_POST["manufacturerPhone"])) {
            echo "invalid phone number";
            return;
        }
        try {
            $result = createObject("Manufacturers", "update");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("MA-3", $e);
        }        
    }

    if ($_POST["process"] == "deleteManufacturer") {
        if (isset($_POST["manufacturerID"]) && ! is_numeric($_POST["manufacturerID"])) {
            echo "invalid input";
            return;
        }
        try {
            $result = createObject("Manufacturers", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("MA-4", $e);
        }
    }