    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of view-invoice -->
        <div class="view-invoices">
            <h1>
                <span><?= $lang["View invoice"];?></span>
            </h1>
            <?php
                $titleQuery = 'SELECT invoice.id, invoice.issued_date, invoice.bill_type , customers.name AS "customer", employees.name AS "cashier", all_invoices_total.items AS "items", all_invoices_total.total AS "total"
                            FROM `invoice`
                            JOIN customers ON invoice.cus_id = customers.id
                            JOIN employees ON invoice.emp_id = employees.id
                            JOIN all_invoices_total ON invoice.id = all_invoices_total.id
                            WHERE invoice.id = :id
                            LIMIT 1;';
                $titleQueryStatement = $conn->prepare($titleQuery);
                $titleQueryStatement->bindValue(':id', $_GET['id']); 
                $titleQueryStatement->execute();
                $titleQueryStatement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                $titleResult = $titleQueryStatement->fetch();
            ?>
            <div class="invoice-details">
                <div class="d-flex">
                    <div class="col-8"><?= $lang["Invoice ID"] . ": " . $titleResult->id;?> </div>
                    <div class="col-4"><?= $lang["Invoice date"] . ": " . $titleResult->issued_date;?> </div>
                </div>
                <div class="d-flex">
                    <div class="col-8"><?= $lang["Cashier"] . ": " . $titleResult->cashier;?> </div>
                    <div class="col-4"><?= $lang["Customer name"] . ": " . $titleResult->customer;?> </div>
                </div>
                <div><?= $lang["Invoice Type"] . ": " . $titleResult->bill_type;?> </div>
            </div>

            <div class="frame-box table-responsive mt-2 mb-2">
                <table class="table table-bordered table-striped table-hover mb-0" id="tableCustomers">
                    <thead>
                        <tr>
                            <th><?= $lang["No."];?></th>
                            <th><?= $lang["Item ID"];?></th>
                            <th><?= $lang["Item name"];?></th>
                            <th><?= $lang["Exipiration date"];?></th>
                            <th><?= $lang["Item Price"];?></th>
                            <th><?= $lang["Quantity"];?></th>
                            <th><?= $lang["Total"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT medicines.id, medicines.name, inventory.expiration_date, all_invoices.price, all_invoices.quantity, all_invoices.total
                            FROM all_invoices 
                            JOIN inventory ON all_invoices.inventory_id = inventory.id
                            JOIN medicines ON inventory.med_id = medicines.id
                            WHERE all_invoices.id = :id;";
                            $statement = $conn->prepare($query);
                            $statement->bindValue(':id', $_GET['id']); 
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                            $result = $statement->fetchAll();
                            if ($result) {
                                $serial = 1;
                                foreach($result as $row) {
                        ?>
                                    <tr>
                                        <td><?= $serial;?></td>
                                        <td><?= $row->id;?></td>
                                        <td><?= $row->name;?></td>
                                        <td><?= $row->expiration_date;?></td>
                                        <td><?= $row->price;?></td>
                                        <td><?= $row->quantity;?></td>
                                        <td><?= $row->total;?></td>
                                    </tr>
                        <?php
                                    $serial++;
                                }
                            }
                            else {
                        ?>
                                <tr>
                                    <td colspan="7">No Records Found</td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <div class="col-10"><?= $lang["Total items"] . ": " . $titleResult->items;?> </div>
                <div class="col-2"><b> <?= $lang["Total"] . ": ". $titleResult->total . " $</b>";?> </div>
            </div>
        </div>
    </div>
    <!-- End of view-invoice -->
    <?php include "../includes/php/footer.php";?>