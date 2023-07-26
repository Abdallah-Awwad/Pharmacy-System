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

        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            $conn = NULL;
            if ($stmt->rowCount() > 0) {
                return $result;
            } else {
                return "No records changed";
            }
         } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return "Duplicated entry";
            } else {
                return "Something wrong happened";
            }
         }
    }

    function createObject($className, $methodName, $encode = FALSE) {
        $obj = new $className();
        $obj = $obj->$methodName();

        if ($encode == FALSE) {
            if ($obj == "Duplicated entry") {
                echo $obj;
            } elseif ($obj == "No records changed") {
                echo $obj;
            } elseif ($obj) {
                echo "Something wrong happened";
            } else {
                echo "Success";
            }
        } else {
            echo json_encode($obj);
        }
    }