<?php
    if (isset($_SERVER['REQUEST_URI'])) {
        $pageTitle = explode('/', $_SERVER['REQUEST_URI']);
        $pageTitle = end($pageTitle);
    }
    else {
        $pageTitle = "Pharmacy System";
    }
    $pharmacyName = " | Pharmacy";
    switch ($pageTitle) {

        case "dashboard":
            $pageTitle = "Dashboard";
        break;

        case "invoice_create":
            $pageTitle = "Create invoice";
            break;

        case "invoices_all":
            $pageTitle = "All invoices";
            break;

        case "invoices_selling":
            $pageTitle = "Selling invoices";
            break;

        case "invoices_return":
            $pageTitle = "Return invoices";
            break;

        case "medicine_add":
            $pageTitle = "Add medicine";
            break;

        case "medicines_view":
            $pageTitle = "View medicine";
            break;

        case "inventory":
            $pageTitle = "Inventory";
            break;
        case "purchases_create":
            $pageTitle = "Create purchase";
            break;

        case "purchases_view":
            $pageTitle = "View purchase";
            break;

        case "expenses_add":
            $pageTitle = "Add expense";
            break;

        case "expenses_view":
            $pageTitle = "View expense";
            break;

        case "customers_add":
            $pageTitle = "Add customer";
            break;

        case "customers_view":
            $pageTitle = "View customer";
            break;

        case "employees_add":
            $pageTitle = "Add employee";
            break;

        case "employees_view":
            $pageTitle = "View employee";
            break;

        case "manufacturers_add":
            $pageTitle = "Add Manufacturer";
            break;

        case "manufacturers_view":
            $pageTitle = "View Manufacturer";
            break;

        default: 
            $pageTitle = "Pharmacy System";
            break;
    }
    if ($pageTitle != "Pharmacy System") {
        $pageTitle = $pageTitle . $pharmacyName;
    }