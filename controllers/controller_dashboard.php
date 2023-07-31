<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/dashboard.php";

    if ($_POST["process"] == "productsCount") {
        try {
            echo createObject("Dashboard", "productsCount")[0][0]["COUNT(*)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }

    if ($_POST["process"] == "customersCount") {
        try {
            echo createObject("Dashboard", "customersCount")[0][0]["COUNT(*)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }

    if ($_POST["process"] == "totalSalesToday") {
        try {
            echo createObject("Dashboard", "totalSalesToday")[0][0]["SUM(`total`)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }

    if ($_POST["process"] == "totalExpensesToday") {
        try {
            echo createObject("Dashboard", "totalExpensesToday")[0][0]["SUM(`amount`)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }

    if ($_POST["process"] == "totalReturnsToday") {
        try {
            echo createObject("Dashboard", "totalReturnsToday")[0][0]["SUM(`total`)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }

    if ($_POST["process"] == "nearExpiry") {
        try {
            echo createObject("Dashboard", "nearExpiry")[0][0]["COUNT(*)"];
        } catch (Exception $e) {
            errorMsgHandler("DAS-0", $e);
        }
    }