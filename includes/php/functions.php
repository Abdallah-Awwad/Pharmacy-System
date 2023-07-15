<?php
    // Select query 
    function dbHandler($query, $fetchMode, &$result, $array2D = NULL){ 
        include "dbconnection.php";
        $stmt = $conn->prepare($query);
        if ($array2D != NULL) {
            foreach ($array2D as $bind => $value) {
                $stmt->bindValue($bind, $value); 
            }
        }
        $stmt->execute();
        $stmt->setFetchMode($fetchMode);
        $result = $stmt->fetchAll();
        if (!$result) {
            echo "Something Went wrong";
        }
        $conn = NULL;
    }
    function dbHandlerAdd($query, $array2D){
        include "dbconnection.php";
        $stmt = $conn->prepare($query);
        foreach ($array2D as $bind => $value) {
            $stmt->bindValue($bind, $value); 
        }
        $stmt->execute();
        if ($stmt) {echo "Success";} 
        else {echo "Something Went wrong";}
        $conn = NULL;
    }