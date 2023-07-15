    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of purchases-view -->
        <div class="purchases-view">
            <h1>
                <span><?= $lang["Create purchase invoice"];?></span>
            </h1>
            <!-- Start of invoice general info -->
            <form action="" method="POST">
                <div class="form-group mb-3 d-flex ">
                    <div class="d-flex col-4 align-items-center">
                        <label class=""  style="width: 15%;"><?= $lang["Item"];?></label>
                        <select class="form-control col-2" style="width: 70%;" id = "item" name="item" required>
                            <option selected>--</option>
                            <?php 
                                $itemsQuery = "SELECT `id`, `name` FROM `medicines` ORDER BY id";
                                $itemsStmt = $conn->prepare($itemsQuery);
                                $itemsStmt->execute();
                                $itemsStmt->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                                $itemsResult = $itemsStmt->fetchAll();
                                if ($itemsResult) {
                                    foreach($itemsResult as $itemRow) {
                                        echo "<option value='$itemRow->id'>$itemRow->id- $itemRow->name</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <label class="col-5"><?= $lang["Quantity"];?></label>
                        <input type="number" class="form-control w-25 col-2" id="quantity" name="quantity" value="1" required>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-end">
                        <label class="col-3"><?= $lang["Expiration Date"];?></label>
                        <input type="date" class="form-control w-50" id="expiration" name="expiration" value="" required>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex  ">
                    <div class="col-4 d-flex align-items-center">
                        <label class="col-3"><?= $lang["inv selling price"];?></label>
                        <input type="number" class="form-control w-25" min="1" step="any" id="sellingPrice" required/>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <label class="col-3"><?= $lang["inv purchase price"];?></label>
                        <input type="number" class="form-control w-25" min="1" step="any" id="purchasePrice" required/>
                    </div>
                    <div class="col-2 d-flex justify-content-end">
                        <button type="button" onclick="addProduct();" class="add-btn btn btn-primary" id="addItem" name="addItem"><?= $lang["Add item"];?></button>
                    </div>
                </div>

                <!-- End of invoice general info -->
                <!-- Start of items sets -->
                <div class="frame-box bg-white table-responsive" style="height: 400px;">
                    <table class="table table-bordered table-striped table-hover mb-0" id="tableInvoice">
                        <thead>
                            <tr>
                                <th><?= $lang["No."];?></th>
                                <th><?= $lang["Item ID"];?></th>
                                <th><?= $lang["Item name"];?></th>
                                <th><?= $lang["inv purchase price"];?></th>
                                <th><?= $lang["inv selling price"];?></th>
                                <th><?= $lang["Quantity"];?></th>
                                <th><?= $lang["Expiration Date"];?></th>
                                <th><?= $lang["Total"];?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex mt-2">
                    <div class="col-8"> 
                        <b>
                            <?= $lang["Total items"];?> <span class="count"> 0 </span>
                        </b>
                    </div>
                    <div class="col-2">
                        <b>
                            <?= $lang["Amount"];?>: 
                            $ <span class="amount">  0</span> 
                        </b>
                    </div>
                    <div class="col-2">
                        <!-- <input type="hidden" id="hiddenField" value="" name="products" /> -->
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="createInvoice(); return false;"><?= $lang["Submit"]?></button>
                    </div>
                </div>
            </form>
            <!-- End of items sets -->
        </div>
    </div>
    <script>
        var serial = 1;
        function addProduct(){
            var itemID = $("#item").val();
            var itemName = $("#item").find(":selected").text();
            itemName = itemName.split('- ');
            itemName = itemName[1];
            var itemQuantity = $("#quantity").val();
            var purchasePrice = $("#purchasePrice").val();
            var sellingPrice = $("#sellingPrice").val();
            var expiration = $("#expiration").val();
            // checking if the item not empty or quantity less than 1
            if(itemID == "--" || itemQuantity < 1) {
                return;
            }
            var row = '<tr>' +
                    '<td>'                      + serial +                          '</td>' +
                    '<td class="medicineID">'   + itemID +                          '</td>' +
                    '<td>'                      + itemName +                        '</td>' +
                    '<td class="purchasePrice">'+ purchasePrice +                   '</td>' +
                    '<td class="sellingPrice">' + sellingPrice +                    '</td>' +
                    '<td class="rowItemsCount">'+ itemQuantity +                    '</td>' +
                    '<td class="expiration">'   + expiration +                      '</td>' +
                    '<td class="rowTotal">'     + purchasePrice * itemQuantity +    '</td>' +
                '</tr>';
            $("table").append(row);
            updateTotals();
            serial++;
        }
        // To sum items count and amount 
        function updateTotals(){
            var x = document.querySelectorAll(".rowItemsCount");
            var itemsTotal = 0; 
            var amountTotal = 0; 
            for (i=0; i < x.length; i ++) {
                itemsTotal += parseInt(x[i].innerHTML);
            }
            document.querySelector(".count").innerHTML = itemsTotal;
            var y = document.querySelectorAll(".rowTotal");
            for (i=0; i < y.length; i ++) {
                amountTotal += parseInt(y[i].innerHTML);
            }
            document.querySelector(".amount").innerHTML = amountTotal;
        }
    </script>
    <script>
        function createInvoice(){
            // Checking if the table got products added. 
            if ($('#tableInvoice tr').length < 2) {return console.log("No products added");}
            // items' IDs and Quantity with the form 
            var products = [];
            $('#tableInvoice tr').each(function() {
                if ($(this).find(".medicineID").html()) {
                    let medicineID = parseInt($(this).find(".medicineID").html());
                    let quantity = parseInt($(this).find(".rowItemsCount").html());
                    let purchasePrice = parseInt($(this).find(".purchasePrice").html());
                    let sellingPrice = parseInt($(this).find(".sellingPrice").html());
                    let expiration = $(this).find(".expiration").html();
                    product = {
                        "medID": medicineID,
                        "purchasePrice": purchasePrice,
                        "sellingPrice": sellingPrice,
                        "expirationDate": expiration,
                        "quantity": quantity
                    };
                    products.push(product);
                }
            });            
            console.log(products);
            var invoiceForm = new FormData();
            var process = "purchaseInvoice";
            // Setting $_POST
            invoiceForm.append('process', process);
            invoiceForm.append('products', JSON.stringify(products));
            // ajax code to send data to controller.php 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // if there is a response ... show error message .. 
                    var result = xmlhttp.responseText;
                    if (result === "success"){
                        var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert"> Invoice made successfully.</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "purchases_create.php";
                        }, 2000);
                    }
                    else {
                        var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>'
                        $("form").append(errorMessage);
                    }
                }
            };
            xmlhttp.open("POST", "controller.php", true);
            xmlhttp.send(invoiceForm);
        }
    </script>
    <!-- End of purchases-view -->
    <?php include "../includes/php/footer.php";?>