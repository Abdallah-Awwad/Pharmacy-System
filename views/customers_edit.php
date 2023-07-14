    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of edit-customers -->
        <div class="edit-customers">
            <h1>
                <span><?= $lang["Edit customer"];?></span>
            </h1>
            <div class="frame-box card-body p-3 ">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="customerName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="customerName" value="<?= readCustomerData("name");?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerGender"> <?= $lang["Gender"];?> </label>
                        <select class="form-control mt-2" name="customerGender">
                            <option 
                                <?= readCustomerData("gender") == "Male" ? "Selected" : "";?>>Male
                            </option>
                            <option
                                <?= readCustomerData("gender") == "Female" ? "Selected" : "";?>>Female
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerPhone"><?= $lang["Phone"];?></label>
                        <input type="text" class="form-control mt-2" name="customerPhone" value="<?= readCustomerData("phone");?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerAddress"><?= $lang["Address"];?></label>
                        <textarea class="form-control mt-2" name="customerAddress" rows="4"><?= readCustomerData("address");?></textarea>
                    </div>
                    <div class="form-group">
                    <?php 
                        //check if form was submitted
                        if(isset($_POST['submitButton'])){ 
                            $name =  $_REQUEST['customerName'];
                            $gender = $_REQUEST['customerGender'];
                            $phone = $_REQUEST['customerPhone'];
                            $address = $_REQUEST['customerAddress'];
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
                    <!-- To remove the message after specific time seconds -->
                    <script>
                        setTimeout(function(){
                            document.getElementById("remove").style.display = "none";
                        }, 3000);
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
    <!-- End of edit-customers -->
    <!-- Retrieving the data from database -->
    <?php
        function readCustomerData($column) {
            // if (isset($_GET['edit'])) {
            include "../includes/php/dbconnection.php";
            $query = "SELECT * FROM customers WHERE id = :id LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $_GET['edit']); 
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $name = $result[$column];
                return $name;
            } else {
                echo "No record found";
            }
        }
    ?>
    <?php include "../includes/php/footer.php";?>