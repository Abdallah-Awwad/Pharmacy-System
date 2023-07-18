    <div class="sidebar flex-shrink-3 p-3 " style="width: 220px;">
        <ul class="list-unstyled ps-0">
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed">
                    <a href="dashboard" class="link-light rounded"> 
                        <?php echo $lang["Dashboard"];?>  
                    </a>  
                </button>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Invoices-collapse" aria-expanded="false">
                    <?php echo $lang["Invoices"];?>  
                </button>
                <div class="collapse" id="Invoices-collapse" style="">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="invoice_create" class="link-light rounded">
                                <?php echo $lang["Create invoice"];?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_all" class="link-light rounded">
                                <?php echo $lang["All Invoices"];?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_selling" class="link-light rounded">
                                <?php echo $lang["Selling invoices"];?>
                            </a>
                        </li>
                        <li>
                            <a href="invoices_return" class="link-light rounded">
                                <?php echo $lang["Return invoices"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Medicines-collapse" aria-expanded="false">
                    <?php echo $lang["Medicines"];?>
                </button>
                <div class="collapse" id="Medicines-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="medicine_add" class="link-light rounded">
                                <?php echo $lang["Add medicine"];?>
                            </a>
                        </li>
                        <li>
                            <a href="medicines_view" class="link-light rounded">
                                <?php echo $lang["View medicines"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="inventory" class="link-light rounded">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Inventory-collapse" aria-expanded="false">
                        <?php echo $lang["Inventory"];?>  
                    </button>
                </a>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Purchases-collapse" aria-expanded="false">
                    <?php echo $lang["Purchases"];?>
                </button>
                <div class="collapse" id="Purchases-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="purchases_create" class="link-light rounded">
                                <?php echo $lang["Purchase create invoice"];?>
                            </a>
                        </li>
                        <li>
                            <a href="purchases_view" class="link-light rounded">
                                <?php echo $lang["View purchase invoices"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Expenses-collapse" aria-expanded="false">
                    <?php echo $lang["Expenses"];?>
                </button>
                <div class="collapse" id="Expenses-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="expenses_add" class="link-light rounded">
                                <?php echo $lang["Add expense"];?>
                            </a>
                        </li>
                        <li>
                            <a href="expenses_view" class="link-light rounded">
                                <?php echo $lang["View expenses"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Customers-collapse" aria-expanded="false">
                    <?php echo $lang["Customers"];?>
                </button>
                <div class="collapse" id="Customers-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="customers_add" class="link-light rounded">
                                <?php echo $lang["Add customer"];?>
                            </a>
                        </li>
                        <li>
                            <a href="customers_view" class="link-light rounded">
                                <?php echo $lang["View customers"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Employees-collapse" aria-expanded="false">
                    <?php echo $lang["Employees"];?>
                </button>
                <div class="collapse" id="Employees-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="employees_add" class="link-light rounded">
                                <?php echo $lang["Add employee"];?>
                            </a>
                        </li>
                        <li>
                            <a href="employees_view" class="link-light rounded">
                                <?php echo $lang["View employee"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Manufactures-collapse" aria-expanded="false">
                    <?php echo $lang["Manufacturers"];?>
                </button>
                <div class="collapse" id="Manufactures-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="manufacturers_add" class="link-light rounded">
                                <?php echo $lang["Add manufacturer"];?>
                            </a>
                        </li>
                        <li>
                            <a href="manufacturers_view" class="link-light rounded">
                                <?php echo $lang["View manufacturers"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Settings-collapse" aria-expanded="false">
                    <?php echo $lang["Settings"];?>
                </button>
                <div class="collapse" id="Settings-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="#" class="link-light rounded">
                                <?php echo $lang["Change theme"];?>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="link-light rounded">
                                <?php echo $lang["Reset system"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Profile-collapse" aria-expanded="false">
                    <?php echo $lang["Profile"];?>
                </button>
                <div class="collapse" id="Profile-collapse">
                    <ul class="btn-toggle-nav fw-normal pb-1 small">
                        <li>
                            <a href="#" class="link-light rounded">
                                <?php echo $lang["Profile information"];?>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="link-light rounded">
                                <?php echo $lang["Logout"];?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>