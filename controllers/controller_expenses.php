<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/expenses.php";
    ini_set("log_errors", TRUE);
    ini_set("error_log", "errors.log");

    if ($_POST["process"] == "readAllExpense") {
        try {
            echo json_encode(createObject("Expenses", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("EX-0", $e);
        }
    }

    if ($_POST["process"] == "readExpense") {
        try {
            echo json_encode((createObject("Expenses", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("EX-1", $e);
        }        
    }

    if ($_POST["process"] == "readManufacturers") {
        print_r(json_encode((createObject("Expenses", "getManufacturesInfo"))[0]));
    }
    
    if ($_POST["process"] == "addExpense") {
        if (empty($_POST["expenseName"])) {
            echo "Expense name can't be empty";
            return;
        }
        if (empty($_POST["expenseAmount"])) {
            echo "Amount name can't be empty";
            return;
        }
        if (! empty($_POST["expenseAmount"]) && ! is_numeric($_POST["expenseAmount"])) {
            echo "invalid amount input";
            return;
        }
        if (empty($_POST["expenseCategory"])) {
            echo "Category can't be empty";
            return;
        }
        try {
            createObject("Expenses", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("EX-2", $e);
        }
    }

    if ($_POST["process"] == "editExpense") {
        if (empty($_POST["expenseName"])) {
            echo "Expense name can't be empty";
            return;
        }
        if (empty($_POST["expenseAmount"])) {
            echo "Amount name can't be empty";
            return;
        }
        if (! empty($_POST["expenseAmount"]) && ! is_numeric($_POST["expenseAmount"])) {
            echo "invalid amount input";
            return;
        }
        if (empty($_POST["expenseCategory"])) {
            echo "Category can't be empty";
            return;
        }
        try {
            $result = createObject("Expenses", "update");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("EX-3", $e);
        }        
    }

    if ($_POST["process"] == "deleteExpense") {
        if (isset($_POST["expenseID"]) && ! is_numeric($_POST["expenseID"])) {
            echo "invalid input";
            return;
        }
        try {
            $result = createObject("Expenses", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("EX-4", $e);
        }
    }