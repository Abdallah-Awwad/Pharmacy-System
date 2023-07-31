<?php 
    if (!isset($_POST["process"])) header("Location: ..");
    include "../models/profiles.php";

    if ($_POST["process"] == "login") {
        $errors[] = "";
        if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $_POST['username'] = trim($_POST['username']);
            $_POST['password'] = trim($_POST['password']);
            try {
                $result = createObject("Profiles", "login")[0];
                if (! empty($result)) {
                    if (password_verify($_POST['password'], $result[0]["password"])) {
                        unset($result[0]->password);
                        session_start();
                        $_SESSION = (array) $result[0];
                        echo "Success";
                    } else {
                        echo $errors[] = "Wrong Username or Password";
                    }
                } else {
                    echo $errors[] = "Wrong Username or Password";
                }
            } catch (Exception $e) {
                echo errorMsgHandler("PRO-0", $e);
            }
        } else {
            echo $errors[] = "Username and Password are required";	
        }
    }

    if ($_POST["process"] == "logout") {
        try {
            createObject("Profiles", "logout");
            echo "Success";
        } catch (Exception $e) {
            echo errorMsgHandler("PRO-1", $e);
        }
    }

    if ($_POST["process"] == "readAllProfiles") {
        try {
            echo json_encode(createObject("Profiles", "index")[0]);
        } catch (Exception $e) {
            errorMsgHandler("PRO-2", $e);
        }
    }

    if ($_POST["process"] == "readProfile") {
        try {
            echo json_encode((createObject("Profiles", "show")[0]));
        } catch (Exception $e) {
            errorMsgHandler("PRO-3", $e);
        }        
    }

    if ($_POST["process"] == "addProfile") {
        if (empty($_POST["profileName"])) {
            echo "Profile name can't be empty";
            return;
        }
        if (! isset($_POST["profilePhone"])) {
            echo "Phone can't be empty";
            return;
        }
        if (isset($_POST["profilePhone"]) && empty($_POST["profilePhone"])) {
            echo "Please enter phone number";
            return;
        }
        if (! is_numeric($_POST["profilePhone"])) {
            echo "Please enter valid phone number";
            return;
        }
        if (empty($_POST["username"])) {
            echo "Username can't be empty";
            return;
        }
        if (empty($_POST["password"])) {
            echo "Password can't be empty";
            return;
        }
        if (empty($_POST["role"])) {
            echo "Please select a profile's role";
            return;
        }
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        try {
            createObject("Profiles", "add");
            echo "Success";
        } catch (Exception $e) {
            errorMsgHandler("PRO-4", $e);
        }
    }

    if ($_POST["process"] == "editProfile") {
        try {
            $result = createObject("Profiles", "canRemove");
            if ($result == "You can't delete the last Admin!") {
                echo $result;
                return;
            }
            if (empty($_POST["profileName"])) {
                echo "Profile name can't be empty";
                return;
            }
            if (! isset($_POST["profilePhone"])) {
                echo "Phone can't be empty";
                return;
            }
            if (isset($_POST["profilePhone"]) && empty($_POST["profilePhone"])) {
                echo "Please enter phone number";
                return;
            }
            if (! is_numeric($_POST["profilePhone"])) {
                echo "Please enter valid phone number";
                return;
            }
            if (empty($_POST["username"])) {
                echo "Username can't be empty";
                return;
            }
            if (empty($_POST["role"])) {
                echo "Please select a profile's role";
                return;
            }
            if (isset($_POST['newPassword'])) {
                unset($_POST['oldPassword']);
                $_POST['newPassword'] = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
            } else {
                unset($_POST['newPassword']);
            }
            $result = createObject("Profiles", "update");
            if (isset($result[1]) && $result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("PRO-5", $e);
        }
    }

    if ($_POST["process"] == "deleteProfile") {
        try {
            $result = createObject("Profiles", "canRemove");
            if ($result == "You can't delete the last Admin!") {
                echo $result;
                return;
            }
            $result = createObject("Profiles", "remove");
            if ($result[1] > 0) {
                echo "Success";
            } else {
                echo "No records changed";
            }
        } catch (Exception $e) {
            errorMsgHandler("PRO-6", $e);
        }
    }