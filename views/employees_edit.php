    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
    <div class="employees-add">
            <h1>
                <span><?= $lang["Employee edit"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="employeeID" required>
                        <label for="employeeName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" id="employeeName" placeholder="<?= $lang["Employee name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeePhone"><?= $lang["Employee phone"];?></label>
                        <input type="tel" class="form-control mt-2" id="employeePhone" placeholder="<?= $lang["Employee phone"];?>" required>
                    </div>
                    <div class="form-group mb-3 d-flex">
                        <div class="d-flex col-5 align-items-center">
                            <label for="employeeGender"><?= $lang["Employee gender"];?></label>
                            <select class="form-control ms-2 w-25" id="employeeGender" required>
                                <option><?= $lang["Male"];?></option>
                                <option><?= $lang["Female"];?></option>
                            </select>
                        </div>
                        <div class="d-flex col-6 align-items-center">
                            <label for="employeeAge"><?= $lang["Employee age"];?></label>
                            <input type="number" class="form-control ms-2 w-25" id="employeeAge" placeholder="<?= $lang["Employee age"];?>">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeeAddress"><?= $lang["Employee address"];?></label>
                        <input type="tel" class="form-control mt-2" id="employeeAddress" placeholder="<?= $lang["Employee address"];?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="employeeSalary"><?= $lang["Employee salary"];?></label>
                        <input type="number" class="form-control mt-2" id="employeeSalary" placeholder="<?= $lang["Employee salary"];?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editEmployee(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        let inputs = document.querySelectorAll("input, textarea, select");
        $(document).ready(function(){
            let bindValues = {
                'process': 'readEmployee',
                'employeeID': (new URLSearchParams((new URL(window.location.href)).search)).get('edit')
            }
            requestAjax(bindValues, function(result){
                if (result == "[]"){
                    window.location.href = "dashboard";
                }
                else{
                    result = JSON.parse(result);
                    for (let i = 0; i < Object.values(result[0]).length; i++){
                        inputs[i].value = Object.values(result[0])[i];
                    }
                }
            });            
        });
        function editEmployee(){
            if (!$('form')[0].checkValidity()){
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'editEmployee'
            }
            for (let i = 0; i < inputs.length; i++){
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, function(result){
                if (result === "Success"){
                    $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">'+result+'</div>');
                    setTimeout(function(){
                        window.location.href = "employees_view";
                    }, 2000);
                }
                else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">'+result+'</div>');
                }
            });                            
        }
    </script>
    <?php include "../includes/php/footer.php";?>