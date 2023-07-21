<?php
    include "../includes/php/dbConnection.php";
    include "../includes/php/functions.php";

    if (!isset($_POST["process"])) header("Location: dashboard");

    // Start of invoice
    if ($_POST["process"] == "readAllCustomersNames") {
        dbHandler("SELECT `id`, `name` FROM `customers`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllCashierNames") {
        dbHandler("SELECT `id`, `name` FROM `employees`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllItemsData") {
        dbHandler("SELECT `inv_id`, `name`, `selling_price`, `expiration_date`, `stock` FROM `stock`ORDER BY `name`;", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "addProduct2") {
        $query = "SELECT 
                    stock.inv_id, stock.id AS med_id, medicines.name, stock.expiration_date, stock.selling_price
                FROM 
                    `stock` 
                JOIN medicines ON stock.id = medicines.id
                WHERE stock.inv_id = :id
                LIMIT 1;";
        $array[":id"] = $_POST["itemID"];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "addProduct") {
        $productQuery = "SELECT 
                            stock.inv_id, stock.id AS med_id, medicines.name, stock.expiration_date, stock.selling_price
                        FROM 
                            `stock` 
                        JOIN medicines ON stock.id = medicines.id
                        WHERE stock.inv_id = :id
                        LIMIT 1;";
        $productStatement = $conn->prepare($productQuery);
        $productStatement->bindValue(':id', $_POST["itemID"]);
        $productStatement->execute();
        $productStatement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
        $productResult = $productStatement->fetch();
        echo json_encode($productResult, 1);
    }
    //check if form was submitted
    if ($_POST["process"] == "createInvoice") {
        $products = json_decode($_POST['products']);
        $bill_type = $_POST['billType'];
        $customer =  $_POST['customerID'];
        $employee = $_POST['cashierID'];
        if (!is_numeric($employee)) {
            echo "Please choose Cashier";
            return;
        }
        // Checking if the items quantities available
        if ($bill_type == "Sale") {
            foreach ($products as $inv_id => $quantity) {
                $checkSql = "SELECT `stock` FROM `stock` WHERE `inv_id` = :id LIMIT 1;";
                $statement = $conn->prepare($checkSql);
                $statement->bindValue(':id', $inv_id);
                $statement->execute();
                $result = $statement->fetch();
                if ($quantity > $result[0]) {
                    echo "Not enough quantity '$inv_id'";
                    return;
                }
            }
        }
        // detecting the ID of the last invoice of the Database
        $lastInvoiceSql = "SELECT id FROM `invoice` ORDER BY id DESC LIMIT 1;";
        $lastInvoiceStmt = $conn->prepare($lastInvoiceSql);
        $lastInvoiceStmt->execute();
        $lastInvoice = $lastInvoiceStmt->fetch();
        $lastInvoice = $lastInvoice[0] + 1; 
        // Inserting the main invoice
        $addInvoiceSql = "INSERT INTO invoice (id, cus_id, emp_id, bill_type) 
                VALUES (:id, :cus, :emp, :bill);";
        $addStmt = $conn->prepare($addInvoiceSql);
        $addStmt->bindValue(':id', $lastInvoice);
        $addStmt->bindValue(':cus', $customer);
        $addStmt->bindValue(':emp', $employee);
        $addStmt->bindValue(':bill', $bill_type);
        $addStmt->execute();
        // looping to add the products to the invoice
        foreach ($products as $inv_id => $quantity) {
            $addDetailsSql = "INSERT INTO invoice_details (invoice_id, inventory_id, quantity) 
                            VALUES (:id, :inv_id, :quantity);";
            $addDetailsStmt = $conn->prepare($addDetailsSql);
            $addDetailsStmt->bindValue(':id', $lastInvoice);
            $addDetailsStmt->bindValue(':inv_id', $inv_id);
            $addDetailsStmt->bindValue(':quantity', $quantity);
            $addDetailsStmt->execute();
            if ($addStmt && $addDetailsStmt) {
            } else {
                echo 'Something wrong happened.';
            }
        }
        echo "Success!";
    }
    if ($_POST["process"] == "readInvoiceDetails") {
        $query = "SELECT medicines.id, medicines.name, inventory.expiration_date, all_invoices.price, all_invoices.quantity, all_invoices.total
                FROM all_invoices 
                JOIN inventory ON all_invoices.inventory_id = inventory.id
                JOIN medicines ON inventory.med_id = medicines.id
                WHERE all_invoices.id = :id;";
        $array[':id'] = $_POST['invoiceID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readInvoice") {
        $query = 'SELECT invoice.id, invoice.issued_date, invoice.bill_type , customers.name AS "customer", employees.name AS "cashier", all_invoices_total.items AS "items", all_invoices_total.total AS "total"
                    FROM `invoice`
                    JOIN customers ON invoice.cus_id = customers.id
                    JOIN employees ON invoice.emp_id = employees.id
                    JOIN all_invoices_total ON invoice.id = all_invoices_total.id
                    WHERE invoice.id = :id
                    LIMIT 1;';
        $array[':id'] = $_POST['invoiceID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllInvoices") {
        $query = "SELECT * FROM `all_invoices_total`";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readReturnInvoices") {
        $query = "SELECT * FROM `all_invoices_total` WHERE type = 'return'";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readSellingInvoices") {
        $query = "SELECT * FROM `all_invoices_total` WHERE type = 'sale'";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    // End of invoice

    // Start of medicine 
    if ($_POST["process"] == "readMedicine") {
        $query = "SELECT medicines.*, manufacturers.name AS manufacture_name 
                    FROM `medicines` 
                    JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id
                    WHERE medicines.id = :id
                    LIMIT 1";
        dbHandler($query, PDO::FETCH_OBJ, $result, [':id' => $_POST['medicineID']]);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readManufactures") {
        dbHandler("SELECT `id`, `name` FROM `manufacturers`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "editMedicine") {
        $query = "UPDATE `medicines` 
                SET `name`= :medName, 
                    `manufacture_id` = :manuID 
                WHERE `id` = :id;";
        $queryInputs = [":id", ":medName", ":manuID"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "deleteMedicine") {
        $query = "DELETE FROM medicines WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $_POST['medicineID']); 
        $stmt->execute();
        if ($stmt) {
            echo "success";
        } else {
            echo "Something Went wrong";
        }
    }
    if ($_POST["process"] == "addMedicine") {
        $query = "INSERT INTO medicines (`name`, `manufacture_id`) VALUES (:name, :manuID)";
        $queryInputs = [":name", ":manuID"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readAllMedicines") {
        dbHandler("SELECT medicines.id, medicines.name, manufacturers.name AS manufactory_name 
                    FROM `medicines` 
                    JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    // End of medicine

    // Start of purchase 
    if ($_POST["process"] == "purchaseInvoice") {
        $products = json_decode($_POST['products']);
        foreach($products as $product) {
            $productQuery = "INSERT INTO `inventory` (med_id, purchase_price, selling_price, expiration_date,  quantity)
                                VALUES (:medID, :purchasePrice, :sellingPrice, :expiration, :quantity);";
            $productStatement = $conn->prepare($productQuery);
            $productStatement->bindValue(':medID', $product->medID);
            $productStatement->bindValue(':purchasePrice', $product->purchasePrice);
            $productStatement->bindValue(':sellingPrice', $product->sellingPrice);
            $productStatement->bindValue(':expiration', $product->expirationDate);
            $productStatement->bindValue(':quantity', $product->quantity);
            $productStatement->execute();
            if ($productStatement) {
            } else {
                echo "Something went wrong.";
            }
        }
        echo "success";
    }
    if ($_POST["process"] == "readPurchases") {
        $query = "SELECT `inv_id`, `id`, `name`, `purchase_price`, `selling_price`, `expiration_date`, `quantity` FROM `stock`;";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllMedicinesNames") {
        dbHandler("SELECT `id`, `name` FROM `medicines` ORDER BY id", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    // End of purchase 

    // Start of expenses
    if ($_POST["process"] == "deleteExpense") {
        $query = "DELETE FROM expenses WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $_POST['expenseID']); 
        $stmt->execute();
        if ($stmt) {
            echo "success";
        } else {
            echo "Something Went wrong";
        }
    }
    if ($_POST["process"] == "addExpense") {
        $query = "INSERT INTO `expenses` (`name`, `description`, `amount`, `category`) VALUES (:name, :desc, :amount, :category)";
        $queryInputs = [":name", ":desc", ":amount", ":category"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readExpense") {
        $query = "SELECT * FROM `expenses` WHERE `id` = :id;";
        $array[':id'] = $_POST['expenseID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllExpense") {
        $query = "SELECT * FROM `expenses`";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "editExpense") {
        $query = "UPDATE `expenses` 
                        SET `name`          = :expenseName, 
                            `description`   = :descr,
                            `amount`        = :amount,
                            `category`      = :category
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":expenseName", ":descr", ":amount", ":category"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of expenses

    // Start of customers 
    if ($_POST["process"] == "deleteCustomer") {
        $query = "DELETE FROM customers WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "addCustomer") {
        $query = "INSERT INTO customers (`name`, `gender`, `phone`, `address`) 
                VALUES (:name, :gender, :phone, :address)";
        $queryInputs = [":name", ":gender", ":phone", ":address"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readCustomer") {
        $query = "SELECT * FROM `customers` WHERE `id` = :id;";
        $array[':id'] = $_POST['customerID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllCustomers") {
        $query = "SELECT * FROM `customers`";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "editCustomer") {
        $query = "UPDATE customers SET `name` = :name , `gender` = :gender , `phone` = :phone, `address` = :address WHERE id = :id";
        $queryInputs = [":id", ":name", ":gender", ":phone", ":address"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of customers 

    // Start of employees
    if ($_POST["process"] == "deleteEmployee") {
        $query = "DELETE FROM employees WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        $x = dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "addEmployee") {
        $query = "INSERT INTO `employees` (`name`, `phone`, `gender`, `age`, `address`,`salary`) VALUES (:name, :phone, :gender, :age, :address ,:salary)";
        $queryInputs = [":name", ":phone", ":gender", ":age", ":address", ":salary"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readEmployee") {
        $query = "SELECT * FROM `employees` WHERE `id` = :id;";
        $array[':id'] = $_POST['employeeID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllEmployees") {
        $query = "SELECT * FROM `employees`";
        dbHandler($query, PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "editEmployee") {
        $query = "UPDATE `employees` 
                        SET `name`          = :name, 
                            `phone`         = :phone,
                            `gender`        = :gender,
                            `age`           = :age,
                            `address`       = :address,
                            `salary`        = :salary
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":name", ":phone", ":gender", ":age", ":address", ":salary"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of employees

    // Start of manufacturer
    if ($_POST["process"] == "deleteManufacturer") {
        $query = "DELETE FROM manufacturers WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }    
    if ($_POST["process"] == "addManufacturer") {
        $query = "INSERT INTO `manufacturers` (`name`, `address`, `phone`) VALUES (:name, :address, :phone)";
        $queryInputs = [":name", ":address", ":phone"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readManufacturer") {
        $query = "SELECT * FROM `manufacturers` WHERE `id` = :id;";
        $array[':id'] = $_POST['manufacturerID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllManufacturers") {
        dbHandler("SELECT * FROM `manufacturers`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "editManufacturer") {
        $query = "UPDATE `manufacturers` 
                        SET `name`          = :name, 
                            `address`       = :address,
                            `phone`         = :phone
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":name", ":address", ":phone"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of manufacturer

    // Start of Inventory
    if ($_POST["process"] == "inventory") {
        dbHandler("SELECT * FROM `stock`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    // End of Inventory