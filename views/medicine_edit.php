    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="edit-medicine">
            <h1>
                <span><?= $lang["Edit medicine"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="">
                    <div class="form-group mb-3">
                        <input type="hidden" id="medicineID" required>
                        <label for="medicineName"><?= $lang["Med name"];?></label>
                        <input type="text" class="form-control mt-2" id="medicineName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacture"><?= $lang["Manufacture"];?></label>
                        <select class="form-control mt-2" id="manufacture"></select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="editMedicine(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        let inputs = document.querySelectorAll("input, textarea, select");
        $(document).ready(function(){
            let bindValues ={
                'process': 'readMedicine',
                'medicineID': (new URLSearchParams((new URL(window.location.href)).search)).get('edit')
            }
            requestAjax(bindValues, function(result){
                if (result == "[]"){
                    window.location.href = "dashboard";
                }
                else {
                    result = JSON.parse(result);
                    $('#medicineID').val(result["id"]);
                    $('#medicineName').val(result["name"]);
                    $('#manufacture').append("<option Selected value='"+result["manufacture_id"]+"'>" +result["manufacture_name"]+ "</option>");
                }
            });            
        });
        $(document).ready(function(){
            let bindValues ={
                'process': 'readManufactures'
            }
            requestAjax(bindValues, function(result){
                if (result == "[]"){
                    window.location.href = "dashboard";
                }
                else {
                    result = JSON.parse(result);
                    $.each(result, function(index, manufacture){ 
                        let key = manufacture.id;
                        let value = manufacture.name;
                        if ($('#manufacture option:selected').text() !== value){
                            let x = "<option value='"+key+"'>"+value+"</option>";
                            $('#manufacture').append(x);
                        }
                    });
                }
            });
        });
        function editMedicine(){
            if (!$('form')[0].checkValidity()){
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process': 'editMedicine'
            }
            for (let i = 0; i < inputs.length; i++){
                bindValues[inputs[i].id] = inputs[i].value;
            }
            requestAjax(bindValues, function(result){
                if (result === "Success"){
                    $("form").append('<div class="alert alert-success float-start p-2" id="remove" role="alert">'+result+'</div>');
                    setTimeout(function(){
                        window.location.href = "medicines_view";
                    }, 2000);
                }
                else {
                    $("form").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">'+result+'</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php";?>