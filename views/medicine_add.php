    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="medicine-add">
            <h1>
                <span><?= $lang["Add medicine"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="medicineName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="medicineName" placeholder="<?= $lang["Med medicine name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufactureName"><?= $lang["Manufacture"];?></label>
                        <select class="form-control mt-2" name="manufactureName" required>
                            <option value="0" disabled Selected>--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="addMedicine(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        $(document).ready(function() {
            let bindValues = {
                'process': 'readManufactures'
            }
            requestAjax(bindValues, function(result){
                result = JSON.parse(result);
                $.each(result, function(index, manufacture){ 
                    var key = manufacture.id;
                    var value = manufacture.name;
                    if ($('[name="manufactureName"] option:selected').text() !== value) {
                        var x = "<option value='"+key+"'>"+value+"</option>";
                        $('[name="manufactureName"]').append(x);
                    }
                });
            });
        });
        function addMedicine(){
            if (! $('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process':      'addMedicine',
                'medName':      $('[name="medicineName"]').val(),
                'manuID':       $('[name="manufactureName"] option:selected').val()
            }
            requestAjax(bindValues, function(result){
                if (result === "success"){
                    var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result+'</div>'
                    $("form").append(success);
                    setTimeout(function(){
                        window.location.href = "medicines_view";
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