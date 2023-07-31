<?php 
    include "../includes/php/functions.php";

    class Invoices {
        
        function index() {
            $query = "SELECT medicines.id, medicines.name, inventory.expiration_date, all_invoices.price, all_invoices.quantity, all_invoices.total
                        FROM all_invoices 
                        JOIN inventory ON all_invoices.inventory_id = inventory.id
                        JOIN medicines ON inventory.med_id = medicines.id
                        WHERE all_invoices.id = :id;";
            return dbHandler($query, [':id' => $_POST['invoiceID']]);
        }

        function show() {
            $query = 'SELECT invoice.id, invoice.issued_date, invoice.bill_type , customers.name AS "customer", employees.name AS "cashier", all_invoices_total.items AS "items", all_invoices_total.total AS "total"
                        FROM `invoice`
                        JOIN customers ON invoice.cus_id = customers.id
                        JOIN employees ON invoice.emp_id = employees.id
                        JOIN all_invoices_total ON invoice.id = all_invoices_total.id
                        WHERE invoice.id = :id
                        LIMIT 1;';
            return dbHandler($query, [':id' => $_POST['invoiceID']]);
        }

        function readAllInvoices() {
            $query = "SELECT * FROM `all_invoices_total`";
            return dbHandler($query);
        }
        
        function readSellingInvoices() {
            $query = "SELECT * FROM `all_invoices_total` WHERE type = 'sale'";
            return dbHandler($query);
        }
        
        function readReturnInvoices() {
            $query = "SELECT * FROM `all_invoices_total` WHERE type = 'return'";
            return dbHandler($query);
        }

        function readAllCustomersNames() {
            $query = "SELECT `id`, `name` FROM `customers`";
            return dbHandler($query);
        }
        
        function readAllCashierNames() {
            $query = "SELECT `id`, `name` FROM `employees`";
            return dbHandler($query);
        }
        
        function readAllItemsData() {
            $query = "SELECT `inv_id`, `name`, `selling_price`, `expiration_date`, `stock` FROM `stock`ORDER BY `name`;";
            return dbHandler($query);
        }

        function addProduct() {
            $query = "SELECT 
                            stock.inv_id, stock.id AS med_id, medicines.name, stock.expiration_date, stock.selling_price
                        FROM 
                            `stock` 
                        JOIN medicines ON stock.id = medicines.id
                        WHERE stock.inv_id = :id
                        LIMIT 1;";
            return dbHandler($query, [':id' => $_POST['itemID']]);
        }

        function checkAvailability() {
            foreach($_POST["products"] as $product) {
                $query = "SELECT `stock` FROM `stock` WHERE `inv_id` = :id LIMIT 1;";
                $result = dbHandler($query, [':id' => $product[0]])[0];
                if ($product[1] > $result[0]["stock"]) {
                    return "Not enough quantity for inventory ID: '$product[0]'";
                } else {
                    return true;
                }
            }
        }
        
        function createInvoice() {
            $query = "INSERT INTO invoice (cus_id, emp_id, bill_type) 
                        VALUES (:cus, :emp, :bill);";
            $queryInputs = [":cus", ":emp", ":bill"];
            $postInputs = [$_POST["customerID"], $_POST["cashierID"], $_POST["billType"]];
            foreach ($queryInputs as $key => $value) {
                $array[$value] = array_values($postInputs)[$key];
            }
            $invoiceID = dbHandler($query, $array, true)[2];

            foreach($_POST["products"] as $product) {
                $query = "INSERT INTO invoice_details (invoice_id, inventory_id, quantity) 
                            VALUES (:id, :inv_id, :quantity);";
                $queryInputs2 = [":id", ":inv_id", ":quantity"];
                $postInputs2 = [$invoiceID, $product[0], $product[1]];
                foreach ($queryInputs2 as $key => $value) {
                    $array2[$value] = array_values($postInputs2)[$key];
                }
                dbHandler($query, $array2);
            }
        }
    }