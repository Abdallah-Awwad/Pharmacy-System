<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/customers.php";
    ini_set("log_errors", TRUE);
    ini_set("error_log", "errors.log");

    if ($_POST["process"] == "readAllCustomers") {
        try {
            echo json_encode(createObject("Customers", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("CU-0", $e);
        }
    }

    if ($_POST["process"] == "readCustomer") {
        try {
            echo json_encode((createObject("Customers", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("CU-1", $e);
        }        
    }
    
    if ($_POST["process"] == "addCustomer") {
        if (empty($_POST["customerName"])) {
            echo "Customer name can't be empty";
            return;
        }
        if (empty($_POST["customerGender"])) {
            echo "Gender can't be empty";
            return;
        }
        if (empty($_POST["customerPhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["customerPhone"]) && ! is_numeric($_POST["customerPhone"])) {
            echo "invalid amount input";
            return;
        }
        try {
            createObject("Customers", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("CU-2", $e);
        }
    }

    if ($_POST["process"] == "editCustomer") {
        if (empty($_POST["customerName"])) {
            echo "Customer name can't be empty";
            return;
        }
        if (empty($_POST["customerGender"])) {
            echo "Gender can't be empty";
            return;
        }
        if (empty($_POST["customerPhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["customerPhone"]) && ! is_numeric($_POST["customerPhone"])) {
            echo "invalid amount input";
            return;
        }
        try {
            $result = createObject("Customers", "update");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("CU-3", $e);
        }        
    }

    if ($_POST["process"] == "deleteCustomer") {
        if (isset($_POST["expenseID"]) && ! is_numeric($_POST["expenseID"])) {
            echo "invalid input";
            return;
        }
        try {
            $result = createObject("Customers", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("CU-4", $e);
        }
    }