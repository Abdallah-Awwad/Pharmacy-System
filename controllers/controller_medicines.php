<?php 
    include "../models/medicines.php";
    if (!isset($_POST["process"])) header("Location: dashboard");

    if ($_POST["process"] == "readAllMedicines") {
        createObject("Medicines", "index", TRUE);
    }

    if ($_POST["process"] == "readMedicine") {
        createObject("Medicines", "show", TRUE);
    }

    if ($_POST["process"] == "readManufacturers") {
        createObject("Medicines", "getManufacturesInfo", TRUE);
    }
    
    if ($_POST["process"] == "addMedicine") {
        $error = [];
        
        if (empty($_POST["medicineName"])) {
            $error[] = "Medicine name can't be empty";
        }
        
        if (! isset($_POST["manufacturer"])) {
            $error[] = "No manufacturer selected";
        }
        
        if (isset($_POST["manufacturer"]) && ! is_numeric($_POST["manufacturer"])) {
            $error[] = "Please enter manufacturer name";
        }

        if (! empty($error)) {
            return print_r(json_encode($error));
        }

        createObject("Medicines", "add");
    }

    if ($_POST["process"] == "editMedicine") {

        $result = createObject("Medicines", "update");

        if ($result == "Something wrong happened") {
            echo "No records changed";
        }
    }

    if ($_POST["process"] == "deleteMedicine") {

        if (isset($_POST["medicineID"]) && ! is_numeric($_POST["medicineID"])) {
            return "invalid input";
        }

        createObject("Medicines", "remove");
    }