    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of add-customers -->
        <div class="add-customers">
            <h1>
                <span><?= $lang["Create invoice"];?></span>
            </h1>
            <!-- Start of invoice general info -->
            <form action="" method="POST">
                <div class="form-group mb-3 d-flex ">
                    <div class="d-flex col-5 align-items-center">
                        <label class="" for="customerName" style="width: 15%;"><?= $lang["Customer"];?></label>
                        <select class="form-control col-2" style="width: 70%;" name="customerName">
                            <!-- <option value="0"><?= $lang["Cash"];?></option> -->
                            <?php 
                                $customerQuery = "SELECT `id`, `name` FROM `customers`";
                                $customerStmt = $conn->prepare($customerQuery);
                                $customerStmt->execute();
                                $customerStmt->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                                $cusResult = $customerStmt->fetchAll();
                                if ($cusResult) {
                                    foreach($cusResult as $row) {                                        
                                        echo "<option value='$row->id'>$row->name</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="d-flex col-4 align-items-center">
                        <label class="col-2"><?= $lang["Cashier"];?></label>
                        <select class="form-control col-2 w-50" name="cashier">
                            <option selected>--</option>
                            <?php 
                                $cashierQuery = "SELECT `id`, `name` FROM `employees`";
                                $cashierStmt = $conn->prepare($cashierQuery);
                                $cashierStmt->execute();
                                $cashierStmt->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                                $cashierResult = $cashierStmt->fetchAll();
                                if ($cashierResult){
                                    foreach($cashierResult as $row) {
                                        echo "<option value='$row->id'>$row->name</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="d-flex col-4 align-items-center">
                        <label class="col-2"><?= $lang["Type"];?></label>
                        <select class="form-control w-50" name="billType">
                            <option><?= $lang["Sale"];?></option>
                            <option><?= $lang["Return"];?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex ">
                    <div class="d-flex col-5 align-items-center">
                        <label class=""  style="width: 15%;"><?= $lang["Item"];?></label>
                        <select class="form-control col-2" style="width: 70%;" id = "item" name="item">
                            <option selected>--</option>
                            <?php 
                                $itemsQuery = "SELECT 
                                                `inv_id`, `name`, `selling_price`, `expiration_date`, `stock` 
                                            FROM `stock`
                                            ORDER BY `name`;";
                                $itemsStmt = $conn->prepare($itemsQuery);
                                $itemsStmt->execute();
                                $itemsStmt->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                                $itemsResult = $itemsStmt->fetchAll();
                                if ($itemsResult) {
                                    foreach($itemsResult as $itemRow) {
                                        echo "<option value='$itemRow->inv_id'>$itemRow->inv_id- $itemRow->name / $itemRow->expiration_date ($itemRow->stock) / $itemRow->selling_price$</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <label class="col-2"><?= $lang["Quantity"];?></label>
                        <input type="number" class="form-control w-25 col-2" id="quantity" name="quantity" value="1" required>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button type="button" onclick="addProduct();" class="add-btn btn btn-primary" style="margin-right: 38px;" id="addItem" name="addItem"><?= $lang["Add item"];?></button>
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
                                <th><?= $lang["Inventory ID"];?></th>
                                <th><?= $lang["Item name"];?></th>
                                <th><?= $lang["Price"];?></th>
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
        var serial = 0;
        function addProduct(){
            var itemID = $("#item").val();
            var itemQuantity = $("#quantity").val();
            // Checking if the item already added in the invoice
            let existBefore = document.querySelectorAll(".InventoryID");
            if (existBefore.length > 0) {
                for (let i = 0; i < existBefore.length; i++) {
                    if (existBefore[i].innerHTML == itemID) {
                        let quntatity = document.querySelectorAll(".rowItemsCount");
                        let rowTotal = document.querySelectorAll(".rowTotal");
                        let rowPrice = document.querySelectorAll(".rowPrice");
                        quntatity[i].innerHTML = parseInt(quntatity[i].innerHTML) + parseInt(itemQuantity);
                        rowTotal[i].innerHTML = parseInt(quntatity[i].innerHTML) * parseInt(rowPrice[i].innerHTML);
                        updateTotals();
                        return;
                    }
                }
            }
            // checking if the item not empty or quantity less than 1
            if(itemID == "--" || itemQuantity < 1) {
                return;
            }
            var formData = new FormData();
            var process = "addProduct";
            // Setting $_POST
            formData.append('process', process);
            formData.append('itemID', itemID);
            // ajax code to send data to controller.php 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                    result = JSON.parse(result);
                    $(document).ready(function(){
                        var row = '<tr>' +
                            '<td>'                      + serial +                              '</td>' +
                            '<td>'                      + result.med_id +                       '</td>' +
                            '<td class="InventoryID">'  + result.inv_id +                           '</td>' +
                            '<td>'                      + result.name +                         '</td>' +
                            '<td class="rowPrice">'     + result.selling_price +                '</td>' +
                            '<td class="rowItemsCount">'+ itemQuantity +                        '</td>' +
                            '<td>'                      + result.expiration_date +              '</td>' +
                            '<td class="rowTotal">'     + result.selling_price * itemQuantity + '</td>' +
                        '</tr>';
                        $("table").append(row);
                        updateTotals();
                    });
                }
            };
            xmlhttp.open("POST", "controller", true);
            xmlhttp.send(formData);
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
            var customerID = $('[name="customerName"]').val();
            var cashierID = $('[name="cashier"]').val();
            var billType = $('[name="billType"]').val();
            // items' IDs and Quantity with the form 
            var products = {};
            $('#tableInvoice tr').each(function() {
                if ($(this).find(".InventoryID").html()) {
                    let x = parseInt($(this).find(".InventoryID").html());
                    let y = parseInt($(this).find(".rowItemsCount").html());
                    products[x] = y;
                }
            });            
            var invoiceForm = new FormData();
            var process = "createInvoice";
            // Setting $_POST
            invoiceForm.append('process', process);
            invoiceForm.append('customerID', customerID);
            invoiceForm.append('cashierID', cashierID);
            invoiceForm.append('billType', billType);
            invoiceForm.append('products', JSON.stringify(products));
            // ajax code to send data to controller 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // if there is a response ... show error message .. 
                    var result = xmlhttp.responseText;
                    if (result === "Success!"){
                        var success = '<div class="alert alert-success float-start p-2" id="remove" role="alert"> Invoice made successfully.</div>'
                        $("form").append(success);
                        setTimeout(function(){
                            window.location.href = "invoice_create";
                        }, 2000);
                    }
                    else {
                        var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>'
                        $("form").append(errorMessage);
                    }
                }
            };
            xmlhttp.open("POST", "controller", true);
            xmlhttp.send(invoiceForm);
        }
    </script>
    <!-- End of add-customers -->
    <?php include "../includes/php/footer.php";?>