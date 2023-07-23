    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="edit-profile">
            <h1>
                <span><?= $lang["Edit profile"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="profileID" required>
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
                        <input type="hidden" class="form-control" id="oldPassword">
                        <label for="newPassword"><?= $lang["Password"] ?></label>
                        <input type="password" class="form-control mt-2" id="newPassword" placeholder="<?= $lang["Leave blank"] ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="role"><?= $lang["Role"] ?></label>
                        <select class="form-control mt-2" id="role" required>
                            <option <?= $lang["Administrator"] ?>>
                                <?= $lang["Administrator"] ?>
                            </option>
                            <option <?= $lang["Pharmacy staff"] ?>>
                                <?= $lang["Pharmacy staff"] ?>
                            </option>
                            <option <?= $lang["Cashier"] ?>>
                                <?= $lang["Cashier"] ?>
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editProfile(); return false;">
                            <?= $lang["Submit"]?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        let inputs = document.querySelectorAll("input, textarea, select");
        $(document).ready(function() {
            requestAjax({'process' : 'readProfile', 'profileID': (new URLSearchParams((new URL(window.location.href)).search)).get('edit')}, function (result) {
                if (result == "[]") {
                    window.location.href = "dashboard";
                } else {
                    result = JSON.parse(result);
                    $('#profileID').val(result[0]["id"]);
                    $('#profileName').val(result[0]["name"]);
                    $('#profilePhone').val(result[0]["phone"]);
                    $('#username').val(result[0]["username"]);
                    $('#oldPassword').val(result[0]["password"]);
                    $('#role').val(result[0]["role"]);
                }
            });
        });
        function editProfile() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'editProfile'
            }
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            bindValues['newPassword'] == "" ? delete bindValues['newPassword'] : delete bindValues['oldPassword'];
            requestAjax(bindValues, function (result) {
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