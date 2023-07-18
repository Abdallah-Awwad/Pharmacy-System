<?php
    include "../includes/php/dbconnection.php";
    include "../includes/php/functions.php";
    if(!isset($_POST["process"])) header("Location: dashboard");
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
    // Start of medicine 
    if($_POST["process"] == "readMedicine"){
        $query = "SELECT medicines.*, manufacturers.name AS manufacture_name 
                    FROM `medicines` 
                    JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id
                    WHERE medicines.id = :id
                    LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $_POST['medicineID']); 
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo json_encode($result, 1);
        } else {
            echo "No record found";
        }
    }
    if($_POST["process"] == "readManufactures"){
        $query2 = "SELECT `id`, `name` FROM `manufacturers`";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        if ($result2) {
            echo json_encode($result2, 1);
        } else {
            echo "No record found";
        }
    }
    if($_POST["process"] == "editMedicine"){
        $query="UPDATE `medicines` 
                SET `name`= :medName, 
                    `manufacture_id` = :manuID 
                WHERE `id` = :id;";
        $queryInputs = [":id", ":medName", ":manuID"];
        foreach ($queryInputs as $key => $value){
        $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "deleteMedicine"){
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
    if($_POST["process"] == "addMedicine"){
        $query = "INSERT INTO medicines (`name`, `manufacture_id`) VALUES (:name, :manuID)";
        $queryInputs = [":name", ":manuID"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of medicine
    // Start of purchase 
    if($_POST["process"] == "purchaseInvoice") {
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
            $productResult = $productStatement->fetch();
        }
        if($productStatement) {
            echo "success";
        }
        else {
            echo "Something went wrong.";
        }
    }
    // End of purchase 
    // Start of expenses
    if($_POST["process"] == "deleteExpense"){
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
    if($_POST["process"] == "addExpense"){
        $query = "INSERT INTO `expenses` (`name`, `description`, `amount`, `category`) VALUES (:name, :desc, :amount, :category)";
        $queryInputs = [":name", ":desc", ":amount", ":category"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "readExpense"){
        $query = "SELECT * FROM `expenses` WHERE `id` = :id;";
        $array[':id'] = $_POST['expenseID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {echo $result;}
        else {echo json_encode($result);}
    }
    if($_POST["process"] == "editExpense"){
        $query="UPDATE `expenses` 
                        SET `name`          = :expenseName, 
                            `description`   = :descr,
                            `amount`        = :amount,
                            `category`      = :category
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":expenseName", ":descr", ":amount", ":category"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of expenses
    // Start of customers 
    if($_POST["process"] == "deleteCustomer"){
        $query = "DELETE FROM customers WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        $x = dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "addCustomer"){
        $query = "INSERT INTO customers (`name`, `gender`, `phone`, `address`) 
                VALUES (:name, :gender, :phone, :address)";
        $queryInputs = [":name", ":gender", ":phone", ":address"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "readCustomer"){
        $query = "SELECT * FROM `customers` WHERE `id` = :id;";
        $array[':id'] = $_POST['customerID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {echo $result;}
        else {echo json_encode($result);}
    }
    if($_POST["process"] == "editCustomer"){
        $query="UPDATE customers SET `name` = :name , `gender` = :gender , `phone` = :phone, `address` = :address WHERE id = :id";
        $queryInputs = [":id", ":name", ":gender", ":phone", ":address"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of customers 
    // Start of employees
    if($_POST["process"] == "deleteEmployee"){
        $query = "DELETE FROM employees WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        $x = dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "addEmployee"){
        $query = "INSERT INTO `employees` (`name`, `phone`, `gender`, `age`, `address`,`salary`) VALUES (:name, :phone, :gender, :age, :address ,:salary)";
        $queryInputs = [":name", ":phone", ":gender", ":age", ":address", ":salary"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "readEmployee"){
        $query = "SELECT * FROM `employees` WHERE `id` = :id;";
        $array[':id'] = $_POST['employeeID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {echo $result;}
        else {echo json_encode($result);}
    }
    if($_POST["process"] == "editEmployee"){
        $query="UPDATE `employees` 
                        SET `name`          = :name, 
                            `phone`         = :phone,
                            `gender`        = :gender,
                            `age`           = :age,
                            `address`       = :address,
                            `salary`        = :salary
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":name", ":phone", ":gender", ":age", ":address", ":salary"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of employees
    // Start of manufacturer
    if($_POST["process"] == "deleteManufacturer"){
        $query = "DELETE FROM manufacturers WHERE id = :id";
        $queryInputs = [":id"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        $x = dbHandlerAdd($query, $array);
    }    
    if($_POST["process"] == "addManufacturer"){
        $query = "INSERT INTO `manufacturers` (`name`, `address`, `phone`) VALUES (:name, :address, :phone)";
        $queryInputs = [":name", ":address", ":phone"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    if($_POST["process"] == "readManufacturer"){
        $query = "SELECT * FROM `manufacturers` WHERE `id` = :id;";
        $array[':id'] = $_POST['manufacturerID'];
        dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        if ($result == "Something Went wrong") {echo $result;}
        else {echo json_encode($result);}
    }
    if($_POST["process"] == "editManufacturer"){
        $query="UPDATE `manufacturers` 
                        SET `name`          = :name, 
                            `address`       = :address,
                            `phone`         = :phone
                        WHERE `id`          = :id;";
        $queryInputs = [":id", ":name", ":address", ":phone"];
        foreach ($queryInputs as $key => $value){
            $array[$value] = array_values($_POST)[$key+1];
        }
        dbHandlerAdd($query, $array);
    }
    // End of manufacturer