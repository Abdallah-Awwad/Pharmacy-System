    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="profile-register">
            <h1>
                <span><?= $lang["Create new profile"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <label for="profileName"><?= $lang["Name"] ?></label>
                        <input type="text" class="form-control mt-2" id="profileName" placeholder="<?= $lang["Profile name"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="profilePhone"><?= $lang["Phone"] ?></label>
                        <input type="tel" class="form-control mt-2" id="profilePhone" placeholder="<?= $lang["Profile phone"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="username"><?= $lang["Username"] ?></label>
                        <input type="text" class="form-control mt-2" id="username" placeholder="<?= $lang["Profile name"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password"><?= $lang["Password"] ?></label>
                        <input type="password" class="form-control mt-2" id="password" placeholder="<?= $lang["Profile password"] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role"><?= $lang["Role"] ?></label>
                        <select class="form-control mt-2" id="role" required>
                            <option value='<?= $lang["Administrator"] ?>'>
                                <?= $lang["Administrator"] ?>
                            </option>
                            <option value='<?= $lang["Pharmacy staff"] ?>'>
                                <?= $lang["Pharmacy staff"] ?>
                            </option>
                            <option value='<?= $lang["Cashier"] ?>'>
                                <?= $lang["Cashier"] ?>
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="addProfile(); return false;">
                            <?= $lang["Submit"]?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addProfile() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process' : 'addProfile'
            }
            let inputs = document.querySelectorAll("input, textarea, select");
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, profilesControllerURL, function (result) {
                if (result === "Success") {
                        $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">' + result + '</div>');
                        setTimeout(function() {
                            window.location.href = "profile_view";
                        }, 2000);
                } else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>