    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="medicine-add">
            <h1>
                <span><?= $lang["Add medicine"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <label for="medicineName"><?= $lang["Name"] ?></label>
                        <input type="text" class="form-control mt-2" id="medicineName" placeholder="<?= $lang["Med medicine name"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturer"><?= $lang["Manufacturer"] ?></label>
                        <select class="form-control mt-2" id="manufacturer" required>
                            <option disabled selected hidden value="">--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="addMedicine(); return false;">
                            <?= $lang["Submit"] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        $(document).ready(function() {
            requestAjaxV2({'process' : 'readManufacturers'}, medicineControllerURL, function (result) {
                result = JSON.parse(result);
                if (result.length) {
                    $.each(result, function (index, manufacturer) {
                        if ($('#manufacturer option:selected').text() !== manufacturer.name) {
                            $('#manufacturer').append("<option value='" + manufacturer.id + "'>" + manufacturer.name + "</option>");
                        }
                    });
                } else {
                    $('#manufacturer').append("<option disabled value=''>Please add manufacturers first</option>");
                }
            });
        });
        function addMedicine() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'addMedicine'
            }
            let inputs = document.querySelectorAll("input, textarea, select");
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjaxV2(bindValues, medicineControllerURL, function (result) {
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