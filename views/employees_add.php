    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="employees-add">
            <h1>
                <span><?= $lang["Add employee"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="employeeName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="employeeName" placeholder="<?= $lang["Employee name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeePhone"><?= $lang["Phone"];?></label>
                        <input type="tel" class="form-control mt-2" name="employeePhone" placeholder="<?= $lang["Employee phone"];?>" required>
                    </div>
                    <div class="form-group mb-3 d-flex">
                        <div class="d-flex col-5 align-items-center">
                            <label for="employeeGender"><?= $lang["Employee gender"];?></label>
                            <select class="form-control ms-2 w-25" name="employeeGender" required>
                                <option><?= $lang["Male"];?></option>
                                <option><?= $lang["Female"];?></option>
                            </select>
                        </div>
                        <div class="d-flex col-6 align-items-center">
                            <label for="employeeAge"><?= $lang["Employee age"];?></label>
                            <input type="number" class="form-control ms-2 w-25" min="18" max="100" name="employeeAge" placeholder="<?= $lang["Employee age"];?>">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeeAddress"><?= $lang["Employee address"];?></label>
                        <input type="tel" class="form-control mt-2" name="employeeAddress" placeholder="<?= $lang["Employee address"];?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeeSalary"><?= $lang["Employee salary"];?></label>
                        <input type="number" class="form-control mt-2" name="employeeSalary" placeholder="<?= $lang["Employee salary"];?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="addEmployee(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addEmployee(){
            if (! $('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process':              'addEmployee',
                'employeeName':         $('[name="employeeName"]').val(),
                'employeePhone':        $('[name="employeePhone"]').val(),
                'employeeGender':       $('[name="employeeGender"]').val(),
                'employeeAge':          $('[name="employeeAge"]').val(),
                'employeeAddress':      $('[name="employeeAddress"]').val(),
                'employeeSalary':       $('[name="employeeSalary"]').val()
            }
            requestAjax(bindValues, function(result) {
                if (result === "Success") {
                    var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result+'</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "employees_view";
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