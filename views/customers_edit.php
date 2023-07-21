    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="edit-customers">
            <h1>
                <span><?= $lang["Edit customer"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="customerID" required>
                        <label for="customerName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" id="customerName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerGender"> <?= $lang["Gender"];?> </label>
                        <select class="form-control mt-2" id="customerGender">
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerPhone"><?= $lang["Phone"];?></label>
                        <input type="text" class="form-control mt-2" id="customerPhone" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="customerAddress"><?= $lang["Address"];?></label>
                        <textarea class="form-control mt-2" id="customerAddress" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editCustomer(); return false;">
                            <?= $lang["Submit"];?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        let inputs = document.querySelectorAll("input, textarea, select");
        $(document).ready(function() {
            let bindValues = {
                'process' : 'readCustomer',
                'customerID' : (new URLSearchParams((new URL(window.location.href)).search)).get('edit')
            }
            requestAjax(bindValues, function (result) {
                if (result == "[]") {
                    window.location.href = "dashboard";
                } else {
                    result = JSON.parse(result);
                    for (let i = 0; i < Object.values(result[0]).length; i++) {
                        inputs[i].value = Object.values(result[0])[i];
                    }
                }
            });
        });
        function editCustomer() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process' : 'editCustomer'
            }
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, function (result) {
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