<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/settings.php";

    if ($_POST["process"] == "truncateDB") {
        echo $result = createObject("Settings", "truncate");
    }