<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/invoices.php";

    if ($_POST["process"] == "readInvoiceDetails") {
        try {
            echo json_encode(createObject("Invoices", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("INV-0", $e);
        }
    }

    if ($_POST["process"] == "readInvoice") {
        try {
            echo json_encode((createObject("Invoices", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-1", $e);
        }        
    }

    if ($_POST["process"] == "readAllInvoices") {
        try {
            echo json_encode((createObject("Invoices", "readAllInvoices")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-2", $e);
        }        
    }

    if ($_POST["process"] == "readSellingInvoices") {
        try {
            echo json_encode((createObject("Invoices", "readSellingInvoices")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-3", $e);
        }        
    }

    if ($_POST["process"] == "readReturnInvoices") {
        try {
            echo json_encode((createObject("Invoices", "readReturnInvoices")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-4", $e);
        }        
    }
    
    if ($_POST["process"] == "readAllCustomersNames") {
        try {
            echo json_encode((createObject("Invoices", "readAllCustomersNames")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-5", $e);
        }        
    }

    if ($_POST["process"] == "readAllCashierNames") {
        try {
            echo json_encode((createObject("Invoices", "readAllCashierNames")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-6", $e);
        }        
    }

    if ($_POST["process"] == "readAllItemsData") {
        try {
            echo json_encode((createObject("Invoices", "readAllItemsData")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-7", $e);
        }        
    }

    if ($_POST["process"] == "addProduct") {
        try {
            echo json_encode((createObject("Invoices", "addProduct")[0]));
        } catch (Exception $e) {
            errorMsgHandler("INV-8", $e);
        }        
    }
    
    if ($_POST["process"] == "createInvoice") {
        try {
            $_POST["products"] = json_decode($_POST["products"]);
            if ($_POST["billType"] == "Sale") {
                $result = createObject("Invoices", "checkAvailability");
                if ($result !== true) {
                    echo $result;
                    return;
                }
            }
            createObject("Invoices", "createInvoice");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("INV-9", $e);
        }        
    }