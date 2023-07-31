<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/settings.php";

    if ($_POST["process"] == "truncateDB") {
        try {
            $result = createObject("Settings", "truncate");
            echo $result;
        } catch (Exception $e) {
            echo errorMsgHandler("SET-0", $e);
        }
    }