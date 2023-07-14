    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of add-customers -->
        <div class="add-customers">
            <h1>
                <span><?= $lang["Add customer"];?></span>
            </h1>
            <div class="frame-box card-body p-3 ">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="customerName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="customerName" placeholder="<?= $lang["Customer name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerGender"><?= $lang["Gender"];?></label>
                        <select class="form-control mt-2" name="customerGender">
                            <option><?= $lang["Male"];?></option>
                            <option><?= $lang["Female"];?></option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerPhone"><?= $lang["Phone"];?></label>
                        <input type="text" class="form-control mt-2" name="customerPhone" placeholder="<?= $lang["Customer phone"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerAddress"><?= $lang["Address"];?></label>
                        <textarea class="form-control mt-2" name="customerAddress" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                    <?php 
                        //check if form was submitted
                        if(isset($_POST['submitButton'])){ 
                            $name =  $_REQUEST['customerName'];
                            $gender = $_REQUEST['customerGender'];
                            $phone = $_REQUEST['customerPhone'];
                            $address = $_REQUEST['customerAddress'];

                            $sql="INSERT INTO customers (`name`, `gender`, `phone`, `address`)
                            VALUES
                            ('$name', '$gender', '$phone', '$address')";
                        
                            $conn->exec($sql);
                            if ($conn && $sql) {
                                echo '<div class="alert alert-success float-start p-2" id="remove" role="alert"> Record has been added.</div>';
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
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton"><?= $lang["Submit"]?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of add-customers -->
    <?php include "../includes/php/footer.php";?>