    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="purchases-view">
            <h1>
                <span><?= $lang["Purchase view invoices"] ?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text"class="search form-control w-50"id="searchInventory"placeholder="What you looking for? (search by name or expiration date)">
                <a href="purchases_create">
                    <button type="button"class="add-btn btn btn-info add-new">
                        <i class="fa fa-plus"></i> <?= $lang["Add New"] ?>
                    </button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover"id="tableInventory">
                    <thead>
                        <tr>
                            <th><?= $lang["inv inv ID"] ?></th>
                            <th><?= $lang["inv med ID"] ?></th>
                            <th><?= $lang["inv name"] ?></th>
                            <th><?= $lang["inv purchase price"] ?></th>
                            <th><?= $lang["inv selling price"] ?></th>
                            <th><?= $lang["inv expiration date"] ?></th>
                            <th><?= $lang["inv quantity"] ?></th>
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
            requestAjax({'process' : 'readPurchases'}, function (result) {
                if (result == "[]") {
                    $("tbody").append('<tr> <td colspan="11"><?= $lang["No Records Found"] ?></td> </tr>');
                } else {
                    result = JSON.parse(result);
                    $.each(result, function (key, value) { 
                        let td = '';
                        for (i = 0; i < Object.values(value).length; i++) {
                            td += '<td>' + Object.values(value)[i] + '</td>';
                        }
                        $("tbody").append('<tr>' + td + '</tr>');
                    });
                    $("table").addClass("sort");
                    sorting();
                }
            });
            liveSearch("searchInventory", "tableInventory", 2, 5);
        });
    </script>
    <?php include "../includes/php/footer.php" ?>