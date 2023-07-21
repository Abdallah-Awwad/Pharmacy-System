    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="add-customers">
            <h1>
                <span><?= $lang["Create invoice"] ?></span>
            </h1>
            <form action="" method="">
                <div class="form-group mb-3 d-flex">
                    <div class="d-flex col-5 align-items-center">
                        <label for="customer" style="width: 15%;"><?= $lang["Customer"] ?></label>
                        <select class="form-control col-2" style="width: 70%;" id="customer">
                        </select>
                    </div>
                    <div class="d-flex col-4 align-items-center">
                        <label class="col-2" for="cashier"><?= $lang["Cashier"] ?></label>
                        <select class="form-control col-2 w-50" id="cashier">
                            <option selected>--</option>
                        </select>
                    </div>
                    <div class="d-flex col-4 align-items-center">
                        <label class="col-2" for="billType"><?= $lang["Type"] ?></label>
                        <select class="form-control w-50" id="billType">
                            <option><?= $lang["Sale"] ?></option>
                            <option><?= $lang["Return"] ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="d-flex col-5 align-items-center">
                        <label class="" for="item" style="width: 15%;"><?= $lang["Item"] ?></label>
                        <select class="form-control col-2" style="width:70%;" id="item">
                            <option selected>--</option>
                        </select>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <label class="col-2" for="quantity"><?= $lang["Quantity"] ?></label>
                        <input type="number" class="form-control w-25 col-2" id="quantity" value="1" required>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button type="button" onclick="addProduct();" class="add-btn btn btn-primary" style="margin-right:38px;" id="addItem">
                            <?= $lang["Add item"] ?>
                        </button>
                    </div>
                </div>
                <div class="frame-box bg-white table-responsive" style="height:400px;">
                    <table class="table table-bordered table-striped table-hover mb-0" id="tableInvoice">
                        <thead>
                            <tr>
                                <th><?= $lang["No."] ?></th>
                                <th><?= $lang["Item ID"] ?></th>
                                <th><?= $lang["Inventory ID"] ?></th>
                                <th><?= $lang["Item name"] ?></th>
                                <th><?= $lang["Price"] ?></th>
                                <th><?= $lang["Quantity"] ?></th>
                                <th><?= $lang["Expiration Date"] ?></th>
                                <th><?= $lang["Total"] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex mt-2">
                    <div class="col-8"> 
                        <b>
                            <?= $lang["Total items"] ?> <span class="count"> 0 </span>
                        </b>
                    </div>
                    <div class="col-2">
                        <b>
                            <?= $lang["Amount"] ?>: 
                            $ <span class="amount">  0</span> 
                        </b>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="add-btn btn btn-primary float-end" id="submitButton" onclick="createInvoice(); return false;">
                            <?= $lang["Submit"] ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            requestAjax({'process' : 'readAllCustomersNames'}, function (result) {
                if (result != "[]") {
                    result = JSON.parse(result);
                    $.each(result, function (serial) {
                        $("#customer").append('<option value="' + result[serial]["id"] + '">' + result[serial]["name"] + '</option>');
                    });
                }
            });
            requestAjax({'process' : 'readAllCashierNames'}, function (result) {
                if (result != "[]") {
                    result = JSON.parse(result);
                    $.each(result,function (serial) {
                        $("#cashier").append('<option value="' + result[serial]["id"] + '">' + result[serial]["name"] + '</option>');
                    });
                }
            });
            requestAjax({'process' : 'readAllItemsData'}, function (result) {
                if (result != "[]") {
                    result = JSON.parse(result);
                    $.each(result, function (serial) { 
                        $("#item").append('<option value="' + result[serial]["inv_id"] + '">'
                            + result[serial]["inv_id"] + '- '
                            + result[serial]["name"] + ' / '
                            + result[serial]["expiration_date"] + ' ('
                            + result[serial]["stock"] + ') / $'
                            + result[serial]["selling_price"]
                        + '</option>');
                    });
                }
            });
        })
        let serial = 1;
        function addProduct() {
            let itemID = $("#item").val();
            let itemQuantity = $("#quantity").val();
            let existBefore = document.querySelectorAll(".InventoryID");
            if (existBefore.length>0) {
                for (let i = 0; i < existBefore.length; i++) {
                    if (existBefore[i].innerHTML == itemID) {
                        let quantity = document.querySelectorAll(".rowItemsCount");
                        let rowTotal = document.querySelectorAll(".rowTotal");
                        let rowPrice = document.querySelectorAll(".rowPrice");
                        quantity[i].innerHTML = parseInt(quantity[i].innerHTML) + parseInt(itemQuantity);
                        rowTotal[i].innerHTML = parseInt(quantity[i].innerHTML) * parseInt(rowPrice[i].innerHTML);
                        updateTotals();
                        return;
                    }
                }
            }
            if (itemID == "--"|| itemQuantity < 1) {
                return;
            }
            requestAjax({'process' : 'addProduct2', 'itemID' : itemID}, function (result) {
                if (result != "[]") {
                    result = JSON.parse(result);
                    let row = '<tr>' +
                        '<td>'                      + serial +                                      '</td>' +
                        '<td>'                      + result[0]["med_id"] +                         '</td>' +
                        '<td class="InventoryID">'  + result[0]["inv_id"] +                         '</td>' +
                        '<td>'                      + result[0]["name"] +                           '</td>' +
                        '<td class="rowPrice">'     + result[0]["selling_price"] +                  '</td>' +
                        '<td class="rowItemsCount">'+ itemQuantity +                                '</td>' +
                        '<td>'                      + result[0]["expiration_date"] +                '</td>' +
                        '<td class="rowTotal">'     + result[0]["selling_price"] * itemQuantity +   '</td>' +
                    '</tr>';
                    $("table").append(row);
                    updateTotals();
                    serial++;
                }
            });
        }
        
        function updateTotals() {
            let itemsCount = document.querySelectorAll(".rowItemsCount");
            let invoiceTotalQuantity = 0; 
            let invoiceTotalAmount = 0; 

            for (i = 0; i < itemsCount.length; i++) {
                invoiceTotalQuantity += parseInt(itemsCount[i].innerHTML);
            }
            document.querySelector(".count").innerHTML = invoiceTotalQuantity;

            let rowTotalAmount = document.querySelectorAll(".rowTotal");
            for (i = 0; i < rowTotalAmount.length; i++) {
                invoiceTotalAmount += parseInt(rowTotalAmount[i].innerHTML);
            }
            document.querySelector(".amount").innerHTML = invoiceTotalAmount;
        }

        function createInvoice() {
            if ($('#tableInvoice tr').length < 2) {
                return console.log("No products added");
            }
            let products = {};
            $('#tableInvoice tr').each(function() {
                if ($(this).find(".InventoryID").html()) {
                    products[parseInt($(this).find(".InventoryID").html())] = parseInt($(this).find(".rowItemsCount").html());
                }
            });            
            requestAjax({'process'  : 'createInvoice',
                        'customerID': $('#customer').val(),
                        'cashierID' : $('#cashier').val(),
                        'billType'  : $('#billType').val(),
                        'products'  : JSON.stringify(products)}, function (result) {
                            if (result === "Success!") {
                                $("form").append('<div class="alert alert-success float-start p-2"id="remove" role="alert"> Invoice made successfully.</div>');
                                setTimeout(function() {
                                    window.location.href = "invoice_create";
                                }, 2000);
                            } else {
                                $("form").append('<div class="alert alert-danger float-start p-2"id="remove"role="alert">' + result + '</div>');
                            }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>