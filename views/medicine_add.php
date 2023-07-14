    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of medicine-add -->
        <div class="medicine-add">
            <h1>
                <span><?= $lang["Add medicine"];?></span>
            </h1>
            <div class="frame-box card-body p-3 ">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="medicineName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" name="medicineName" placeholder="<?= $lang["Manufacture"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufactureName"><?= $lang["Manufacture"];?></label>
                        <select class="form-control mt-2" name="manufactureName" required>
                            <option value="0" disabled Selected>--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="addMedicine(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of medicine-add -->
    <!-- Start of Retrieving all manufactures from database -->
    <script> 
        $(document).ready(function() {
            var readManufacturesForm = new FormData();
            var process = "readManufactures";
            readManufacturesForm.append('process', process);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                    result = JSON.parse(result);
                    $.each(result, function(index, manufacture){ 
                        var key = manufacture.id;
                        var value = manufacture.name;
                        if ($('[name="manufactureName"] option:selected').text() !== value) {
                            var x = "<option value='"+key+"'>"+value+"</option>";
                            $('[name="manufactureName"]').append(x);
                        }
                    });
                }
            };
            xmlhttp.open("POST", "controller.php", true);
            xmlhttp.send(readManufacturesForm);
        });
    </script>
    <!-- End of Retrieving all manufactures from database -->
    <!-- Start of updating data -->
    <script>
        function addMedicine(){
            var newName = $('[name="medicineName"]').val();
            var newManufacture = $('[name="manufactureName"] option:selected').val();
            // Form to add new medicine 
            var addMedicineForm = new FormData();
            var process = "addMedicine";
            addMedicineForm.append('process', process);
            addMedicineForm.append('medName', newName);
            addMedicineForm.append('manuID', newManufacture);
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function(){
                if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                    var result2 = xmlhttp2.responseText;
                    if (result2 === "success"){
                        var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result2+'</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "medicines_view.php";
                        }, 2000);
                    }
                    else {
                        var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result2 + '</div>'
                        $("form").append(errorMessage);
                    }
                }
            };
            xmlhttp2.open("POST", "controller.php", true);
            xmlhttp2.send(addMedicineForm);
        }
    </script>
    <!-- End of updating data -->
    <?php include "../includes/php/footer.php";?>