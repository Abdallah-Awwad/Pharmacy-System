    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="all_invoices">
        <div class="all-invoices">
            <h1>
                <span><?= $lang["All Invoices"] ?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchInvoice" placeholder="What you looking for? (search by ID or Date)">
                <a href="invoice_create">
                    <button type="button" class="add-btn btn btn-info add-new">
                        <i class="fa fa-plus"></i> <?= $lang["Add New"] ?>
                    </button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableInvoices">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"] ?></th>
                            <th><?= $lang["Date"] ?></th>
                            <th><?= $lang["Type"] ?></th>
                            <th><?= $lang["Items"] ?></th>
                            <th><?= $lang["Total"] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            requestAjax({'process' : 'readAllInvoices'}, function (result) {
                if (result == "[]") {
                    $("tbody").append('<tr> <td colspan="6"><?= $lang["No Records Found"] ?></td> </tr>');
                } else {
                    result = JSON.parse(result);
                    $.each(result, function (serial, value) {
                        let td = '';
                        for (i = 0; i < Object.values(value).length; i++) {
                            td += '<td>' + Object.values(value)[i] + '</td>';
                        }
                        $("tbody").append('<tr onclick=window.location.href="invoice_view?id=' + value["id"] + '"> </td>' + td + '</tr>');
                    });
                    $("table").addClass("sort");
                    sorting();
                }
            });
            liveSearch("searchInvoice", "tableInvoices", 0, 2);
        });
    </script>
    <?php include "../includes/php/footer.php" ?>