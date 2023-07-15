    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="edit-expenses">
            <h1>
                <span><?= $lang["Expense Edit Expense"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="expenseName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseName"required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseDescription"><?= $lang["Description"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseDescription">
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseAmount"><?= $lang["Amount"];?></label>
                        <input type="number" class="form-control mt-2 w-25" name="expenseAmount"required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expenseCategory"><?= $lang["Category"];?></label>
                        <input type="text" class="form-control mt-2" name="expenseCategory" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="editExpense(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        var expenseID = (new URLSearchParams((new URL(window.location.href)).search)).get('edit');
        $(document).ready(function() {
            let bindValues = {
                'process': 'readExpense',
                'expenseID': expenseID
            }
            requestAjax(bindValues, function(result){
                if (result == "Something Went wrong[]"){window.location.href = "dashboard.php";}
                else {
                    result = JSON.parse(result);
                    $('[name="expenseName"]').val(result[0]["name"]);
                    $('[name="expenseDescription"]').val(result[0]["description"]);
                    $('[name="expenseAmount"]').val(result[0]["amount"]);
                    $('[name="expenseCategory"]').val(result[0]["category"]);
                }
            });            
        });
    </script>
    <script>
        function editExpense(){
            if (! $('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process':              'editExpense',
                'expenseID':            expenseID,
                'expenseName':          $('[name="expenseName"]').val(),
                'expenseDescription':   $('[name="expenseDescription"]').val(),
                'expenseAmount':        $('[name="expenseAmount"]').val(),
                'expenseCategory':      $('[name="expenseCategory"]').val()
            }
            requestAjax(bindValues, function(result){
                if (result === "Success"){
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