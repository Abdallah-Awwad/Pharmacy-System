    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="all_invoices">
        <!-- Start of view-customers -->
        <div class="return-invoices">
            <h1>
                <span><?= $lang["Return"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchInvoice" placeholder="What you looking for? (search by ID or Date)">
                <a href="invoice_create.php">
                    <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> Add New</button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableInvoices">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"];?></th>
                            <th><?= $lang["Type"];?></th>
                            <th><?= $lang["Date"];?></th>
                            <th><?= $lang["Items"];?></th>
                            <th><?= $lang["Total"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `all_invoices_total` WHERE type = 'return'";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                            $result = $statement->fetchAll();
                            if ($result) {
                                foreach($result as $row) {
                        ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= $row->type; ?></td>
                                        <td><?= $row->date; ?></td>
                                        <td><?= $row->items; ?></td>
                                        <td><?= $row->total; ?></td>
                                    </tr>
                        <?php
                                }
                            }
                            else {
                        ?>
                                <tr>
                                    <td colspan="6">No Records Found</td>
                                </tr>
                        <?php
                            }
                            // To delete from the Database
                            if (isset($_GET['delete'])) {
                                include_once "../includes/php/header.php";
                                $delete = "DELETE FROM customers WHERE id =" . $_GET['delete'];
                                $conn->exec($delete);
                                // header('Location: dashboard.php');
                                // exit();
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            liveSearch("searchInvoice", "tableInvoices", 0, 2);
        });
    </script>
    <!-- End of view-customers -->
    <?php include "../includes/php/footer.php";?>