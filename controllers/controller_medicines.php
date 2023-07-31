<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/medicines.php";

    if ($_POST["process"] == "readAllMedicines") {
        try {
            echo json_encode(createObject("Medicines", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("MEC-0", $e);
        }
    }

    if ($_POST["process"] == "readMedicine") {
        try {
            echo json_encode((createObject("Medicines", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("MEC-1", $e);
        }
    }

    if ($_POST["process"] == "readManufacturers") {
        try {
            echo json_encode((createObject("Medicines", "getManufacturesInfo")[0]));
        } catch (Exception $e) {
            errorMsgHandler("MEC-5", $e);
        }
    }
    
    if ($_POST["process"] == "addMedicine") {
        if (empty($_POST["medicineName"])) {
            echo "Medicine name can't be empty";
            return;
        }
        if (! isset($_POST["manufacturer"])) {
            echo "No manufacturer selected";
            return;
        }
        if (isset($_POST["manufacturer"]) && empty($_POST["manufacturer"])) {
            echo "Please enter manufacturer name";
            return;
        }
        try {
            createObject("Medicines", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("MEC-2", $e);
        }
    }

    if ($_POST["process"] == "editMedicine") {
        if (empty($_POST["medicineName"])) {
            echo "Medicine name can't be empty";
            return;
        }
        if (empty($_POST["manufacturer"])) {
            echo "Manufacturer can't be empty";
            return;
        }
        try {
            $result = createObject("Medicines", "update");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("MEC-3", $e);
        }        
    }

    if ($_POST["process"] == "deleteMedicine") {

        if (isset($_POST["medicineID"]) && ! is_numeric($_POST["medicineID"])) {
            echo "invalid input";
            return;
        }
        try {
            $result = createObject("Medicines", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("MEC-4", $e);
        }
    }