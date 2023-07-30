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

    // Start of Profile
    if ($_POST["process"] == "addProfile") {
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $query = "INSERT INTO members (`name`, `phone`, `username`, `password`, `role`) 
                VALUES (:name, :phone, :username, :password, :role)";
        $queryInputs = [":name", ":phone", ":username", ":password", ":role"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "editProfile") {
        // Checking if it's the last Admin
        if ($_POST["role"] != "Administrator") {
            dbHandler("SELECT COUNT(*) FROM members WHERE `role` = 'Administrator';", PDO::FETCH_ASSOC, $result);
            if ($result[0]['COUNT(*)'] == 1) {
                dbHandler("SELECT `role` FROM members WHERE `id` = :id;", PDO::FETCH_ASSOC, $result, [':id' => $_POST['profileID']]);
                if ($result[0]["role"] == "Administrator") {
                    echo "You can't delete the last Admin!";
                    return;
                }
            }
        }
        if (isset($_POST['newPassword'])) {
            unset($_POST['oldPassword']);
            $_POST['newPassword'] = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
        } else {
            unset($_POST['newPassword']);
        }
        $query = "UPDATE `members` 
                SET `name`= :name, 
                    `phone` = :phone, 
                    `phone` = :phone, 
                    `username` = :username, 
                    `password` = :password, 
                    `role` = :role
                WHERE `id` = :id;";
        $queryInputs = [":id", ":name", ":phone", ":username", ":password", ":role"];
        foreach ($queryInputs as $key => $value) {
            $array[$value] = array_values($_POST)[$key + 1];
        }
        dbHandlerAdd($query, $array);
    }
    if ($_POST["process"] == "readProfile") {
        $query = "SELECT * FROM `members` WHERE `id` = :id;";
        $array[':id'] = $_POST['profileID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "readAllProfiles") {
        dbHandler("SELECT `id`, `name`, `phone`, `username`, `role`, `created_at`, `updated_at`  FROM `members`", PDO::FETCH_OBJ, $result);
        if ($result == "Something Went wrong") {
            echo $result;
        } else {
            echo json_encode($result);
        }
    }
    if ($_POST["process"] == "deleteProfile") {
        // Checking if it's the last Admin
        dbHandler("SELECT COUNT(*) FROM members WHERE `role` = 'Administrator';", PDO::FETCH_ASSOC, $result);
        if ($result[0]['COUNT(*)'] == 1) {
            dbHandler("SELECT `role` FROM members WHERE `id` = :id;", PDO::FETCH_ASSOC, $result, [':id' => $_POST['profileID']]);
            if ($result[0]["role"] == "Administrator") {
                echo "You can't delete the last Admin!";
                return;
            }
        }
        dbHandlerAdd("DELETE FROM members WHERE id = :id", [':id' => $_POST['profileID']]);
    }
    // End of Profile