    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="dashboard">
            <h1>
                <span><?= $lang["Dashboard"] ?></span>
            </h1>
            <div class="statistics row text-center">
                <div class="col sales">
                    <div class="number">
                        <span id="totalSales">0.00</span>
                    </div>
                    <div class="description">
                        <?= $lang["Today total sales"] ?>
                    </div>
                    <div class="more-info">
                        <a href="invoices_selling">
                            <span>
                                <?= $lang["More info"] ?> <i class="fa-solid <?= $lang["fa-circle-arrow-right"] ?>"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col expenses">
                    <div class="number">
                        <span id="totalExpenses">0.00</span>
                    </div>
                    <div class="description">
                        <?= $lang["Today total expenses"] ?>
                    </div>
                    <div class="more-info">
                        <a href="expenses_view">
                            <span>
                                <?= $lang["More info"] ?> <i class="fa-solid <?= $lang["fa-circle-arrow-right"] ?>"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col returns">
                    <div class="number">
                        <span id="totalReturns">0.00</span>
                    </div>
                    <div class="description">
                        <?= $lang["Today total returns"] ?>
                    </div>
                    <div class="more-info"> 
                        <a href="invoices_return">
                            <span>
                                <?= $lang["More info"] ?> <i class="fa-solid <?= $lang["fa-circle-arrow-right"] ?>"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col expiry">
                    <div class="number">
                        <span id="nearExpiry">0</span>
                    </div>
                    <div class="description">
                        <?= $lang["Near expiry products"] ?>
                    </div>
                    <div class="more-info">
                        <a href="inventory">
                            <span>
                                <?= $lang["More info"] ?> <i class="fa-solid <?= $lang["fa-circle-arrow-right"] ?>"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="shortcuts row justify-content-around">
                <a href="" style="pointer-events: none;" class="col-5">
                    <div>
                        <h2><?= $lang["Quick Stats"] ?></h2>
                        <p>
                            - <?= $lang["Number of products"] ?> 
                            <span id="products">0.00</span>
                        </p>
                        <p>
                            - <?= $lang["Number of customers"] ?>
                            <span id="customers">0</span>
                        </p>
                    </div>
                </a>
                <a href="invoice_create" class="col-5">
                    <div>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="col-6 text-center">
                                <h2><?= $lang["Make invoice"];?></h2>
                            </div>
                            <div class="col">
                        </div>
                        <img src="imgs/invoice.svg" class="img-fluid rounded mx-auto d-block" alt="payment image" width="200">
                        </div>
                    </div>

                </a>
                <a href="purchases_create" class="col-5">
                    <div>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="col-6 text-center">
                                <h2><?= $lang["Update the stock"];?></h2>
                            </div>
                            <div class="col">
                        </div>
                        <img src="imgs/barcode.svg" class="img-fluid rounded mx-auto d-block" alt="barcode image" width="150">
                        </div>
                    </div>
                </a>
                <a href="medicines_add" class="col-5">
                    <div>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="col-6 text-center">
                                <h2><?= $lang["Add a new medicine"];?></h2>
                            </div>
                            <div class="col">
                        </div>
                        <img src="imgs/medicine.svg" class="img-fluid rounded mx-auto d-block" alt="medicine image" width="150">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            requestAjax({'process' : 'productsCount'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#products").text(result);
                }
            });
            requestAjax({'process' : 'customersCount'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#customers").text(result);
                }
            });
            requestAjax({'process' : 'totalSalesToday'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#totalSales").text(result);
                }
            });
            requestAjax({'process' : 'totalExpensesToday'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#totalExpenses").text(result);
                }
            });
            requestAjax({'process' : 'totalReturnsToday'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#totalReturns").text(result);
                }
            });
            requestAjax({'process' : 'nearExpiry'}, dashboardControllerURL, function (result) {
                if (result.length) {
                    $("#nearExpiry").text(result);
                }
            });
        });

    </script>
    <?php include "../includes/php/footer.php" ?>   