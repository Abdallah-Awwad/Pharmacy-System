    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="edit-customers">
            <h1>
                <span><?= $lang["Edit customer"];?></span>
            </h1>
        <?php
            $query = "SELECT * FROM `customers` WHERE `id` = :id;";
            $array[':id'] = $_GET['edit'];
            dbHandler($query, PDO::FETCH_OBJ, $result, $array);
        ?>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="customerName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="customerName" value="<?= $result[0]->name;?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerGender"> <?= $lang["Gender"];?> </label>
                        <select class="form-control mt-2" name="customerGender">
                            <option 
                                <?= $result[0]->gender == "Male" ? "Selected" : "";?>>Male
                            </option>
                            <option
                                <?= $result[0]->gender == "Female" ? "Selected" : "";?>>Female
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerPhone"><?= $lang["Phone"];?></label>
                        <input type="text" class="form-control mt-2" name="customerPhone" value="<?= $result[0]->phone;?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerAddress"><?= $lang["Address"];?></label>
                        <textarea class="form-control mt-2" name="customerAddress" rows="4"><?= $result[0]->address;?></textarea>
                    </div>
                    <div class="form-group">
                    <?php 
                        if(isset($_POST['submitButton'])){ 
                            $name =  $_POST['customerName'];
                            $gender = $_POST['customerGender'];
                            $phone = $_POST['customerPhone'];
                            $address = $_POST['customerAddress'];
                            $id = $_GET['edit'];
                            if (empty($address)) $address = NULL;
                            $sql= "UPDATE customers SET `name` = :name , `gender` = :gender , `phone` = :phone, `address` = :address WHERE id = :id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(':name', $name); 
                            $stmt->bindValue(':gender', $gender); 
                            $stmt->bindValue(':phone', $phone); 
                            $stmt->bindValue(':address', $address); 
                            $stmt->bindValue(':id', $id); 
                            $stmt->execute();
                            if ($conn && $stmt) {
                                echo '<div class="alert alert-success float-start p-2" id="remove" role="alert"> Record has been updated.</div>';
                            }
                            else {
                                echo '<div class="alert alert-danger float-start p-2" id="remove" role="alert"> Something went wrong.</div>';
                            }
                    ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = "customers_view";
                            }, 2000);
                        </script>
                    <?php
                        }
                        else {
                        }
                    ?>
                        <button type="submit" class="add-btn btn btn-primary float-end " name="submitButton">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "../includes/php/footer.php";?>