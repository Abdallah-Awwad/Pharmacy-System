    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="add-customers">
            <h1>
                <span><?= $lang["Add customer"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <label for="customerName"><?= $lang["Name"] ?></label>
                        <input type="text" class="form-control mt-2" id="customerName" placeholder="<?= $lang["Customer name"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerGender"><?= $lang["Gender"] ?></label>
                        <select class="form-control mt-2" id="customerGender" required>
                            <option><?= $lang["Male"] ?></option>
                            <option><?= $lang["Female"] ?></option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerPhone"><?= $lang["Phone"] ?></label>
                        <input type="text" class="form-control mt-2" id="customerPhone" placeholder="<?= $lang["Customer phone"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerAddress"><?= $lang["Address"] ?></label>
                        <textarea class="form-control mt-2" id="customerAddress" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="addCustomer(); return false;">
                            <?= $lang["Submit"]?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addCustomer() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process' : 'addCustomer'
            }
            let inputs = document.querySelectorAll("input, textarea, select");
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjaxV2(bindValues, customersControllerURL, function (result) {
                if (result === "Success") {
                        $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">' + result + '</div>');
                        setTimeout(function() {
                            window.location.href = "customers_view";
                        }, 2000);
                } else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>