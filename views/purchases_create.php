    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="purchases-view">
            <h1>
                <span><?= $lang["Create purchase invoice"] ?></span>
            </h1>
            <form action="" method="">
                <div class="form-group mb-3 d-flex ">
                    <div class="d-flex col-4 align-items-center">
                        <label class="" for="item" style="width: 15%;"><?= $lang["Item"] ?></label>
                        <select class="form-control col-2" style="width: 70%;" id="item" required>
                            <option selected>--</option>
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <label class="col-5" for="quantity"><?= $lang["Quantity"] ?></label>
                        <input type="number" class="form-control w-25 col-2" id="quantity" value="1" required>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-end">
                        <label class="col-3" for="expiration"><?= $lang["Expiration Date"] ?></label>
                        <input type="date" class="form-control w-50" id="expiration" value="" required>
                    </div>
                </div>

                <div class="form-group mb-3 d-flex  ">
                    <div class="col-4 d-flex align-items-center">
                        <label class="col-3" for="sellingPrice"><?= $lang["inv selling price"] ?></label>
                        <input type="number" class="form-control w-25" min="1" step="any" id="sellingPrice" required/>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <label class="col-3" for="purchasePrice"><?= $lang["inv purchase price"] ?></label>
                        <input type="number" class="form-control w-25" min="1" step="any" id="purchasePrice" required/>
                    </div>
                    <div class="col-2 d-flex justify-content-end">
                        <button type="button" onclick="addProduct();" class="add-btn btn btn-primary" id="addItem">
                            <?= $lang["Add item"] ?>
                        </button>
                    </div>
                </div>

                <div class="frame-box bg-white table-responsive" style="height: 400px;">
                    <table class="table table-bordered table-striped table-hover mb-0" id="tableInvoice">
                        <thead>
                            <tr>
                                <th><?= $lang["No."] ?></th>
                                <th><?= $lang["Item ID"] ?></th>
                                <th><?= $lang["Item name"] ?></th>
                                <th><?= $lang["inv purchase price"] ?></th>
                                <th><?= $lang["inv selling price"] ?></th>
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
                        <button type="submit" class="add-btn btn btn-primary float-end" name="submitButton" onclick="createInvoice(); return false;">
                            <?= $lang["Submit"]?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            requestAjax({'process' : 'readAllMedicinesNames'}, function (result) {
                if (result != "[]") {
                    result = JSON.parse(result);
                    $.each(result, function (serial) { 
                        $("#item").append('<option value="' + result[serial]["id"] + '">' + result[serial]["id"] + "- " + result[serial]["name"] + '</option>');
                    });
                }
            });
        })
        let serial = 1;
        function addProduct() {
            if (!$('form')[0].checkValidity()) {
                $('form')[0].reportValidity();
                return;
            }
            let itemID = $("#item").val();
            let itemQuantity = $("#quantity").val();
            let purchasePrice = $("#purchasePrice").val();
            if (itemID == "--" || itemQuantity < 1) {
                return;
            }
            let row = '<tr>' +
                    '<td>'                      + serial +                                                  '</td>' +
                    '<td class="medicineID">'   + itemID +                                                  '</td>' +
                    '<td>'                      + (($("#item").find(":selected").text()).split('- '))[1] +  '</td>' +
                    '<td class="purchasePrice">'+ purchasePrice +                                           '</td>' +
                    '<td class="sellingPrice">' + $("#sellingPrice").val() +                                '</td>' +
                    '<td class="rowItemsCount">'+ itemQuantity +                                            '</td>' +
                    '<td class="expiration">'   + $("#expiration").val() +                                  '</td>' +
                    '<td class="rowTotal">'     + purchasePrice * itemQuantity +                            '</td>' +
                '</tr>';
            $("table").append(row);
            updateTotals();
            serial++;
        }
        function updateTotals() {
            let itemsCount = document.querySelectorAll(".rowItemsCount");
            let invoiceTotalQuantity = 0; 
            let invoiceTotalAmount = 0; 
            for (i=0; i < itemsCount.length; i ++) {
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
            let products = [];
            $('#tableInvoice tr').each(function() {
                if ($(this).find(".medicineID").html()) {
                    product = {
                        "medID": parseInt($(this).find(".medicineID").html()),
                        "purchasePrice": parseInt($(this).find(".purchasePrice").html()),
                        "sellingPrice": parseInt($(this).find(".sellingPrice").html()),
                        "expirationDate": $(this).find(".expiration").html(),
                        "quantity": parseInt($(this).find(".rowItemsCount").html())
                    };
                }
            });            
            products.push(product);
            requestAjax({'process'  : 'purchaseInvoice',
                        'products'  : JSON.stringify(products)}, function (result) {
                if (result === "success") {
                    $("form").append('<div class="alert alert-success float-start p-2"id="remove" role="alert"> Invoice made successfully.</div>');
                    setTimeout(function() {
                        window.location.href = "purchases_create";
                    }, 2000);
                } else {
                    $("form").append('<div class="alert alert-danger float-start p-2"id="remove"role="alert">' + result + '</div>');
                }
            });
        }
    </script>
    <?php include "../includes/php/footer.php" ?>