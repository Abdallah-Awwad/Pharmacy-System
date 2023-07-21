    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="manufacturers-add">
            <h1>
                <span><?= $lang["Manufacturer add"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <label for="manufacturerName"><?= $lang["Name"] ?></label>
                        <input type="text" class="form-control mt-2" id="manufacturerName" placeholder="<?= $lang["Manufacturer name"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturerAddress"><?= $lang["Address"] ?></label>
                        <input type="tel" class="form-control mt-2" id="manufacturerAddress" placeholder="<?= $lang["Manufacturer address"] ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturerPhone"><?= $lang["Phone"] ?></label>
                        <input type="tel" class="form-control mt-2" id="manufacturerPhone" placeholder="<?= $lang["Manufacturer phone"] ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="addManufacturer(); return false;">
                            <?= $lang["Submit"] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addManufacturer() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'addManufacturer'
            }
            let inputs = document.querySelectorAll("input, textarea, select");
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, function (result) {
                if (result === "Success") {
                        $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">' + result + '</div>');
                        setTimeout(function() {
                            window.location.href = "manufacturers_view";
                        }, 2000);
                } else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>