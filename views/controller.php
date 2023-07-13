<?php
    include "../includes/php/dbconnection.php";
    if(!isset($_POST["process"])) header("Location: dashboard.php"); ;
    if($_POST["process"] == "addProduct") {
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
    if($_POST["process"] == "createInvoice"){
        $products = json_decode($_POST['products']);
        $bill_type = $_POST['billType'];
        $customer =  $_POST['customerID'];
        $employee = $_POST['cashierID'];
        if (!is_numeric($employee)) {
            echo "Please choose Cashier";
            return;
        }
        // echo "$employee";
        // Checking if the items quantities available
        if ($bill_type == "Sale") {
            foreach ($products as $inv_id => $quantity) {
                $checkSql="SELECT `stock` FROM `stock` WHERE `inv_id` = :id LIMIT 1;";
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
        $lastInvoiceSql="SELECT id FROM `invoice` ORDER BY id DESC LIMIT 1;";
        $lasteInvoiceStmt = $conn->prepare($lastInvoiceSql);
        $lasteInvoiceStmt->execute();
        $lastInvoice = $lasteInvoiceStmt->fetch();
        $lastInvoice = $lastInvoice[0] + 1; 
        // Inserting the main invoice
        $addInvoiceSql="INSERT INTO invoice (id, cus_id, emp_id, bill_type) 
                VALUES (:id, :cus, :emp, :bill);";
        $addStmt = $conn->prepare($addInvoiceSql);
        $addStmt->bindValue(':id', $lastInvoice);
        $addStmt->bindValue(':cus', $customer);
        $addStmt->bindValue(':emp', $employee);
        $addStmt->bindValue(':bill', $bill_type);
        $addStmt->execute();
        // looping to add the products to the invoice
        foreach ($products as $inv_id => $quantity) {
            $addDetailsSql="INSERT INTO invoice_details (invoice_id, inventory_id, quantity) 
                            VALUES (:id, :inv_id, :quantity);";
            $addDetailsStmt = $conn->prepare($addDetailsSql);
            $addDetailsStmt->bindValue(':id', $lastInvoice);
            $addDetailsStmt->bindValue(':inv_id', $inv_id);
            $addDetailsStmt->bindValue(':quantity', $quantity);
            $addDetailsStmt->execute();
            if ($addStmt && $addDetailsStmt) {
            }
            else {
                echo 'Something wrong happend.';
            }
        }
        echo "Success!";
    }