    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="edit-medicine">
            <h1>
                <span><?= $lang["Edit medicine"];?></span>
            </h1>
            <div class="frame-box card-body p-3 ">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="medicineName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" name="medicineName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufactureName"><?= $lang["Manufacture"];?></label>
                        <select class="form-control mt-2" name="manufactureName"></select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="editMedicine(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Start of Retrieving the data from database -->
    <script> 
    var editValue = "";
        $(document).ready(function() {
            // Form to read medicine data
            var readMedicineForm = new FormData();
            var process = "readMedicine";
            // To retreive the GET value from the URL 
            var url = new URL(window.location.href);
            var searchParams = new URLSearchParams(url.search);
            editValue = searchParams.get('edit');
            // Setting $_POST
            readMedicineForm.append('process', process);
            readMedicineForm.append('medicineID', editValue);
            // ajax code to send data to controller.php 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    // if there is a response ... show error message .. 
                    var result = xmlhttp.responseText;
                    if (result === "No record found"){window.location.href = "dashboard.php";}
                    result = JSON. parse(result);
                    $('[name="medicineName"]').val(result["name"]);
                    var manuName = result["manufacture_name"];
                    var manuValue = result["manufacture_id"];
                    var x = "<option Selected value='"+manuValue+"'>" + manuName + "</option>";
                    $('[name="manufactureName"]').append(x);
                }
            };
            xmlhttp.open("POST", "controller.php", true);
            xmlhttp.send(readMedicineForm);
            // Form to read all manufactures names 
            var readManufacturesForm = new FormData();
            var process = "readManufactures";
            readManufacturesForm.append('process', process);
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function(){
                if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                    var result2 = xmlhttp2.responseText;
                    result2 = JSON.parse(result2);
                    $.each(result2, function(index, manufacture){ 
                        var key = manufacture.id;
                        var value = manufacture.name;
                        if ($('[name="manufactureName"] option:selected').text() !== value) {
                            var x = "<option value='"+key+"'>"+value+"</option>";
                            $('[name="manufactureName"]').append(x);
                        }
                    });
                }
            };
            xmlhttp2.open("POST", "controller.php", true);
            xmlhttp2.send(readManufacturesForm);
        });
    </script>
    <!-- End of Retrieving the data from database -->
    <!-- Start of updating data -->
    <script>
        function editMedicine(){
            var newName = $('[name="medicineName"]').val();
            var newManufacture = $('[name="manufactureName"] option:selected').val();
            console.log(newManufacture);
            // Form to edit medicine 
            var editMedicineForm = new FormData();
            var process = "editMedicine";
            editMedicineForm.append('process', process);
            editMedicineForm.append('medName', newName);
            editMedicineForm.append('medID', editValue);
            editMedicineForm.append('manuID', newManufacture);
            var xmlhttp3 = new XMLHttpRequest();
            xmlhttp3.onreadystatechange = function(){
                if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
                    var result3 = xmlhttp3.responseText;
                    if (result3 === "Success"){
                        var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result3+'</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "medicines_view.php";
                        }, 2000);
                    }
                    else {
                        var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result3 + '</div>'
                        $("form").append(errorMessage);
                    }
                }
            };
            xmlhttp3.open("POST", "controller.php", true);
            xmlhttp3.send(editMedicineForm);
        }
    </script>
    <!-- End of updating data -->
    <?php include "../includes/php/footer.php";?>