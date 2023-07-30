    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="edit-expenses">
            <h1>
                <span><?= $lang["Expense Edit Expense"] ?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="expenseID" required>
                        <label for="expenseName"><?= $lang["Med name"] ?></label>
                        <input type="text" class="form-control mt-2" id="expenseName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseDescription"><?= $lang["Description"] ?></label>
                        <input type="text" class="form-control mt-2" id="expenseDescription">
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseAmount"><?= $lang["Amount"] ?></label>
                        <input type="number" class="form-control mt-2 w-25" id="expenseAmount" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseCategory"><?= $lang["Category"] ?></label>
                        <input type="text" class="form-control mt-2" id="expenseCategory" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editExpense(); return false;">
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
            requestAjaxV2({'process' : 'readExpense', 'expenseID' : (new URLSearchParams((new URL(window.location.href)).search)).get('edit')}, expensesControllerURL, function (result) {
                result = JSON.parse(result);
                if (result.length) {
                    for (let i = 0; i < Object.values(result[0]).length; i++) {
                        inputs[i].value = Object.values(result[0])[i];
                    }
                } else {
                    window.location.href = "dashboard";
                }
            });
        });
    </script>
    <script>
        function editExpense() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process' : 'editExpense'
            }
            for (let i = 0; i < inputs.length; i++) {
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjaxV2(bindValues, expensesControllerURL, function (result) {
                if (result === "Success") {
                    $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">' + result + '</div>');
                    setTimeout(function() {
                        window.location.href = "expenses_view";
                    }, 2000);
                } else {
                        $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>