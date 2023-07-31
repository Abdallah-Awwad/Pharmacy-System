<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/employees.php";

    if ($_POST["process"] == "readAllEmployees") {
        try {
            echo json_encode(createObject("Employees", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("EM-0", $e);
        }
    }

    if ($_POST["process"] == "readEmployee") {
        try {
            echo json_encode((createObject("Employees", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("EM-1", $e);
        }        
    }
    
    if ($_POST["process"] == "addEmployee") {
        if (empty($_POST["employeeName"])) {
            echo "Employee name can't be empty";
            return;
        }
        if (empty($_POST["employeePhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["employeePhone"]) && ! is_numeric($_POST["employeePhone"])) {
            echo "invalid phone number";
            return;
        }
        if (empty($_POST["employeeGender"])) {
            echo "Gender can't be empty";
            return;
        }
        if (! empty($_POST["employeeAge"]) && ! is_numeric($_POST["employeeAge"])) {
            echo "invalid age input";
            return;
        }
        if (empty($_POST["employeeSalary"])) {
            echo "Salary can't be empty";
            return;
        }
        if (! empty($_POST["employeeSalary"]) && ! is_numeric($_POST["employeeSalary"])) {
            echo "invalid Salary input";
            return;
        }
        if (! empty($_POST["employeeSalary"]) && ($_POST["employeeSalary"]) < 0) {
            echo "Salary can't be less than zero";
            return;
        }
        try {
            createObject("Employees", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("EM-2", $e);
        }
    }

    if ($_POST["process"] == "editEmployee") {
        if (empty($_POST["employeeName"])) {
            echo "Employee name can't be empty";
            return;
        }
        if (empty($_POST["employeePhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (! empty($_POST["employeePhone"]) && ! is_numeric($_POST["employeePhone"])) {
            echo "invalid phone number";
            return;
        }
        if (empty($_POST["employeeGender"])) {
            echo "Gender can't be empty";
            return;
        }
        if (! empty($_POST["employeeAge"]) && ! is_numeric($_POST["employeeAge"])) {
            echo "invalid age input";
            return;
        }
        if (empty($_POST["employeeSalary"])) {
            echo "Salary can't be empty";
            return;
        }
        if (! empty($_POST["employeeSalary"]) && ! is_numeric($_POST["employeeSalary"])) {
            echo "invalid Salary input";
            return;
        }
        if (! empty($_POST["employeeSalary"]) && ($_POST["employeeSalary"]) < 0) {
            echo "Salary can't be less than zero";
            return;
        }
        try {
            $result = createObject("Employees", "update");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("EM-3", $e);
        }        
    }

    if ($_POST["process"] == "deleteEmployee") {
        if (isset($_POST["employeeID"]) && ! is_numeric($_POST["employeeID"])) {
            echo "invalid input";
            return;
        }
        try {
            $result = createObject("Employees", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("EM-4", $e);
        }
    }