    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="view-invoices">
            <h1>
                <span><?= $lang["View invoice"] ?></span>
            </h1>
            <div class="invoice-details">
                <div class="d-flex">
                    <div class="col-8">
                        <?= $lang["Invoice ID"] ?>: 
                        <span id="invoiceID"></span>
                    </div>
                    <div class="col-4">
                        <?= $lang["Invoice date"]?>: 
                        <span id='invoiceDate'></span>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-8">
                        <?= $lang["Cashier"] ?>: 
                        <span id='cashier'></span>
                    </div>
                    <div class="col-4">
                        <?= $lang["Customer name"] ?>:
                        <span id="customerName"></span>
                    </div>
                </div>
                <div>
                    <?= $lang["Invoice type"] ?>:
                    <span id="invoiceType"></span>
                </div>
            </div>
            <div class="frame-box table-responsive mt-2 mb-2">
                <table class="table table-bordered table-striped table-hover mb-0" id="tableCustomers">
                    <thead>
                        <tr>
                            <th><?= $lang["No."] ?></th>
                            <th><?= $lang["Item ID"] ?></th>
                            <th><?= $lang["Item name"] ?></th>
                            <th><?= $lang["Expiration date"] ?></th>
                            <th><?= $lang["Item Price"] ?></th>
                            <th><?= $lang["Quantity"] ?></th>
                            <th><?= $lang["Total"] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <div class="col-10"><b><?= $lang["Total items"] ?> : <span id="totalItems"></span></b></div>
                <div class="col-2"><b><?= $lang["Total"] ?> : $<span id="totalAmount"></span></b></div>
            </div>
        </div>
    </div>
    <script> 
        $(document).ready(function() {
            requestAjax({'process' : 'readInvoice', 'invoiceID' : (new URLSearchParams((new URL(window.location.href)).search)).get('id')}, function (result) {
                if (result == "[]") {
                    window.location.href = "dashboard";
                } else {
                    result = JSON.parse(result);
                    $('#invoiceID').text(result[0]['id']);
                    $('#invoiceDate').text(result[0]['issued_date']);
                    $('#cashier').text(result[0]['cashier']);
                    $('#customerName').text(result[0]['customer']);
                    $('#invoiceType').text(result[0]['bill_type']);
                    $('#totalItems').text(result[0]['items']);
                    $('#totalAmount').text(result[0]['total']);
                }
            });
            requestAjax({'process' : 'readInvoiceDetails', 'invoiceID' : (new URLSearchParams((new URL(window.location.href)).search)).get('id')}, function (result) {
                if (result == "[]") {
                    window.location.href = "dashboard";
                } else {
                    result = JSON.parse(result);
                    $.each(result, function (serial, value) {
                        let td = '';
                        for (i = 0; i < Object.values(value).length; i++) {
                            td += '<td>' + Object.values(value)[i] + '</td>';
                        }
                        $("table").append('<tr>' + '<td>' +(serial + 1)+ '</td>' + td + '</tr>');
                    });
                }
            });
        });
    </script>
    <?php include "../includes/php/footer.php" ?>