    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="manufacturers-add">
            <h1>
                <span><?= $lang["Manufacturer add"];?></span>
            </h1>
            <div class="frame-box card-body p-3">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="manufacturerName"><?= $lang["Name"];?></label>
                        <input type="text" class="form-control mt-2" name="manufacturerName" placeholder="<?= $lang["Manufacturer name"];?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturerAddress"><?= $lang["Address"];?></label>
                        <input type="tel" class="form-control mt-2" name="manufacturerAddress" placeholder="<?= $lang["Manufacturer address"];?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="manufacturerPhone"><?= $lang["Phone"];?></label>
                        <input type="tel" class="form-control mt-2" name="manufacturerPhone" placeholder="<?= $lang["Manufacturer phone"];?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="addManufacturer(); return false;"><?= $lang["Submit"];?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addManufacturer(){
            if (! $('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let bindValues = {
                'process':                  'addManufacturer',
                'manufacturerName':         $('[name="manufacturerName"]').val(),
                'manufacturerAddress':      $('[name="manufacturerAddress"]').val(),
                'manufacturerPhone':        $('[name="manufacturerPhone"]').val(),
            }
            requestAjax(bindValues, function(result){
                if (result === "Success") {
                    var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert">' +result+'</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "manufacturers_view";
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