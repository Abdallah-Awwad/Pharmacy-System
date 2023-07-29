    <div class="sidebar flex-shrink-3 p-3 " style="width: 220px;">
        <ul class="list-unstyled ps-0">
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed">
                    <a href="dashboard" class="link-light rounded"> 
                        <?= $lang["Dashboard"] ?>
                    </a>  
                </button>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Invoices-collapse" aria-expanded="false">
                    <?= $lang["Invoices"] ?>  
                </button>
                <div class="collapse" id="Invoices-collapse" style="">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="invoice_create" class="link-light rounded">
                                <?= $lang["Create invoice"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_all" class="link-light rounded">
                                <?= $lang["All Invoices"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_selling" class="link-light rounded">
                                <?= $lang["Selling invoices"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_return" class="link-light rounded">
                                <?= $lang["Return invoices"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Medicines-collapse" aria-expanded="false">
                    <?= $lang["Medicines"] ?>
                </button>
                <div class="collapse" id="Medicines-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="medicines_add" class="link-light rounded">
                                <?= $lang["Add medicine"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="medicines_view" class="link-light rounded">
                                <?= $lang["View medicines"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="inventory" class="link-light rounded">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Inventory-collapse" aria-expanded="false">
                        <?= $lang["Inventory"] ?>
                    </button>
                </a>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Purchases-collapse" aria-expanded="false">
                    <?= $lang["Purchases"] ?>
                </button>
                <div class="collapse" id="Purchases-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="purchases_create" class="link-light rounded">
                                <?= $lang["Purchase create invoice"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="purchases_view" class="link-light rounded">
                                <?= $lang["View purchase invoices"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Expenses-collapse" aria-expanded="false">
                    <?= $lang["Expenses"] ?>
                </button>
                <div class="collapse" id="Expenses-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="expenses_add" class="link-light rounded">
                                <?= $lang["Add expense"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="expenses_view" class="link-light rounded">
                                <?= $lang["View expenses"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Customers-collapse" aria-expanded="false">
                    <?= $lang["Customers"] ?>
                </button>
                <div class="collapse" id="Customers-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="customers_add" class="link-light rounded">
                                <?= $lang["Add customer"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="customers_view" class="link-light rounded">
                                <?= $lang["View customers"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Employees-collapse" aria-expanded="false">
                    <?= $lang["Employees"] ?>
                </button>
                <div class="collapse" id="Employees-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="employees_add" class="link-light rounded">
                                <?= $lang["Add employee"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="employees_view" class="link-light rounded">
                                <?= $lang["View employee"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Manufactures-collapse" aria-expanded="false">
                    <?= $lang["Manufacturers"] ?>
                </button>
                <div class="collapse" id="Manufactures-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="manufacturers_add" class="link-light rounded">
                                <?= $lang["Add manufacturer"] ?>
                            </a>
                        </li>
                        <li>
                            <a href="manufacturers_view" class="link-light rounded">
                                <?= $lang["View manufacturers"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Settings-collapse" aria-expanded="false">
                    <?= $lang["Settings"] ?>
                </button>
                <div class="collapse" id="Settings-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="#" class="link-light rounded">
                                <?= $lang["Change theme"] ?>
                            </a>
                        </li>
                        <li>
                            <a id="databaseSwal" href="#" class="link-light rounded">
                                <?= $lang["Reset database"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Profile-collapse" aria-expanded="false">
                    <?= $lang["Profile"] ?>
                </button>
                <div class="collapse" id="Profile-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>       
                            <a href="profile_register" class="link-light rounded">
                                <?= $lang["Create new profile"] ?>
                            </a>                     
                        </li>
                        <li>       
                            <a href="profile_view" class="link-light rounded">
                                <?= $lang["View all profiles"] ?>
                            </a>                     
                        </li>
                        <li>                            
                            <a href="profile_logout" class="link-light rounded">
                                <?= $lang["Logout"] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <script>
        $(document).ready(function () {
            $('#databaseSwal').on("click", function () {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: false,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            requestAjaxV2({'process' : 'truncateDB'}, settingsControllerURL, function (result) {
                                if (result === "Success") {
                                    swal("Deleted!", "Your database sucessfully deleted", "success");
                                    setTimeout(function() {
                                        window.location.href = "dashboard";
                                    }, 2000);

                                } else {
                                    swal("Error", "Something wrong happened", "error");
                                }
                            });
                            
                        } 
                    }
                );
            });
        });
    </script>