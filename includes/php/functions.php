<?php
    ini_set("log_errors", TRUE);
    ini_set("error_log", "errors.log");
    
    function dbHandler($query, $array2D = NULL, $lastID = false) {
        include "dbConnection.php";
        $stmt = $conn->prepare($query);
        if ($array2D != NULL) {
            foreach ($array2D as $bind => $value) {
                $stmt->bindValue($bind, $value); 
            }
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $rowCount = $stmt->rowCount();
        if ($lastID != false) {
            $lastInsertId = $conn->lastInsertId();
            $conn = NULL;
            return [$result, $rowCount, $lastInsertId];
        }
        $conn = NULL;
        return [$result, $rowCount];
    }

    function createObject($className, $methodName) {
        $obj = new $className();
        $obj = $obj->$methodName();
        return $obj;
    }

    function errorMsgHandler($errorCode, $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "Duplicated entry";
        } elseif ($e->errorInfo[1] == 1452) {
            echo "Unknown inputs value";            
        } else {
            echo "Unfortunately an issue happened! Error code: $errorCode";
            error_log($e->getMessage());
            error_log("_________________________________________________________________");
        }
    }