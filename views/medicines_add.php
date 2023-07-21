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
                        <label for="manufacture"><?= $lang["Manufacture"] ?></label>
                        <select class="form-control mt-2" id="manufacture" required>
                            <option value="0" disabled Selected>--</option>
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
            requestAjax({'process' : 'readManufactures'}, function (result) {
                result = JSON.parse(result);
                $.each(result, function (index, manufacture) {
                    if ($('#manufacture option:selected').text() !== manufacture.name) {
                        $('#manufacture').append("<option value='" + manufacture.id + "'>" + manufacture.name + "</option>");
                    }
                });
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
            requestAjax(bindValues, function (result) {
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