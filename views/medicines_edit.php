    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="edit-medicine">
            <h1>
                <span><?= $lang["Edit medicine"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="medicineID" required>
                        <label for="medicineName"><?= $lang["Med name"] ?></label>
                        <input type="text" class="form-control mt-2" id="medicineName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturer"><?= $lang["Manufacturer"] ?></label>
                        <select class="form-control mt-2" id="manufacturer"></select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editMedicine(); return false;">
                            <?= $lang["Submit"] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        let inputs = document.querySelectorAll("input, textarea, select");
        $(document).ready(function() {
            bindValues = {'process' : 'readMedicine', 
                            'medicineID': (new URLSearchParams((new URL(window.location.href)).search)).get('edit')};
            requestAjax(bindValues, medicinesControllerURL, function (result) {
                result = JSON.parse(result);
                if (result.length) {
                    $('#medicineID').val(result[0]["id"]);
                    $('#medicineName').val(result[0]["name"]);
                    $('#manufacturer').append("<option Selected value='" + result[0]["manufacture_id"] + "'>" + result[0]["manufacture_name"] + "</option>");
                } else {
                    window.location.href = "dashboard";
                }
            });
        });
        $(document).ready(function() {
            requestAjax({'process': 'readManufacturers'}, medicinesControllerURL, function (result) {
                result = JSON.parse(result);
                if (result.length) {
                    $.each(result, function (key, manufacturer) { 
                        if ($('#manufacturer option:selected').text() !== manufacturer.name) {
                            $('#manufacturer').append("<option value='" + manufacturer.id + "'>" + manufacturer.name + "</option>");
                        }
                    });
                } else {
                    window.location.href = "dashboard";
                }
            });
        });
        function editMedicine() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'editMedicine'
            }
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, medicinesControllerURL, function (result) {
                if (result === "Success") {
                    $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">' + result + '</div>');
                    setTimeout(function() {
                        window.location.href = "medicines_view";
                    }, 2000);
                } else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>