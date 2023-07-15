    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="expenses-add">
            <h1>
                <span><?= $lang["Add expense"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="expenseName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseName" placeholder="<?= $lang["Expense name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseDescription"><?= $lang["Description"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseDescription" placeholder="<?= $lang["Expense description"];?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseAmount"><?= $lang["Amount"];?></label>
                        <input type="number" class="form-control mt-2 w-25" name="expenseAmount" placeholder="<?= $lang["Expense amount"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseCategory"><?= $lang["Category"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseCategory" placeholder="<?= $lang["Other"];?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="addExpense(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addExpense(){
            if (! $('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process':              'addExpense',
                'expenseName':          $('[name="expenseName"]').val(),
                'expenseDescription':   $('[name="expenseDescription"]').val(),
                'expenseAmount':        $('[name="expenseAmount"]').val(),
                'expenseCategory':      $('[name="expenseCategory"]').val(),
            }
            requestAjax(bindValues, function(result) {
                if (result === "success") {
                    var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result+'</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "expenses_view.php";
                        }, 2000);
                } 
                else {
                    var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>'
                    $("form").append(errorMessage);
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php";?>