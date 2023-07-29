<?php
    function dbHandler($query, $fetchMode, &$result, $array2D = NULL) {
        include "dbConnection.php";
        $stmt = $conn->prepare($query);
        if ($array2D != NULL) {
            foreach ($array2D as $bind => $value) {
                $stmt->bindValue($bind, $value); 
            }
        }
        $stmt->execute();
        $stmt->setFetchMode($fetchMode);
        $result = $stmt->fetchAll();
        $conn = NULL;
    }
    function dbHandlerAdd($query, $array2D) {
        include "dbConnection.php";
        $stmt = $conn->prepare($query);
        foreach ($array2D as $bind => $value) {
            $stmt->bindValue($bind, $value);
        }
        $stmt->execute();
        if ($stmt) {
            echo "Success";
        }
        $conn = NULL;
    }

    function dbHandlerV2($query, $array2D = NULL) {
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
        $conn = NULL;
        $rowCount = $stmt->rowCount();
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