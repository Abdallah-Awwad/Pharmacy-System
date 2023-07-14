    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of view-customers -->
        <div class="view-customers">
            <h1>
                <span><?= $lang["View customers"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchCustomers" placeholder="What you looking for? (search by name or phone)">
                <a href="customers_add.php">
                    <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> <?= $lang["Add New"];?></button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableCustomers">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"];?></th>
                            <th><?= $lang["Customer name"];?></th>
                            <th><?= $lang["Gender"];?></th>
                            <th><?= $lang["Address"];?></th>
                            <th><?= $lang["Phone"];?></th>
                            <th><?= $lang["Actions"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `customers`";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); 
                            $result = $statement->fetchAll();
                            if ($result){
                                foreach($result as $row){
                        ?>
                                    <tr>
                                        <td><?= $row->id;?></td>
                                        <td><?= $row->name;?></td>
                                        <td><?= $row->gender;?></td>
                                        <td><?= $row->address;?></td>
                                        <td><?= $row->phone;?></td>
                                        <td>
                                            <a class="add" title="<?= $lang["Add"];?>" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                            <a href="customers_edit.php?edit=<?= $row->id;?>" class="edit" title="<?= $lang["Edit"];?>" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a href="customers_view.php?delete=<?= $row->id;?>" class="delete" title="<?= $lang["Delete"];?>" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                            else {
                        ?>
                                <tr>
                                    <td colspan="6"><?= $lang["No Records Found"];?></td>
                                </tr>
                        <?php
                            }
                            // To delete from the Database
                            if (isset($_GET['delete'])){
                                include_once "../includes/php/header.php";
                                $delete = "DELETE FROM customers WHERE id =" . $_GET['delete'];
                                $conn->exec($delete);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            $(this).parents("tr").remove();
        });
        // Calling live search function
        $(document).ready(function() {
            liveSearch("searchCustomers", "tableCustomers", 1, 4);
        });
    </script>
    <!-- End of view-customers -->
    <?php include "../includes/php/footer.php";?>