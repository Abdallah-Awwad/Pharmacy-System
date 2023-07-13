    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of view-customers -->
        <div class="view-customers">
            <h1>
                <span><?php echo $lang["View customers"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchCustomers" placeholder="What you looking for? (search by name or phone)">
                <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> Add New</button>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableCustomers">
                    <thead>
                        <tr>
                            <th><?php echo $lang["ID"];?></th>
                            <th><?php echo $lang["Customer name"];?></th>
                            <th><?php echo $lang["Gender"];?></th>
                            <th><?php echo $lang["Address"];?></th>
                            <th><?php echo $lang["Phone"];?></th>
                            <th><?php echo $lang["Actions"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM customers";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                            $result = $statement->fetchAll();
                            if ($result) {
                                foreach($result as $row) {
                        ?>
                                    <tr>
                                        <td><?= $row->id;?></td>
                                        <td><?= $row->name;?></td>
                                        <td><?= $row->gender;?></td>
                                        <td><?= $row->address;?></td>
                                        <td><?= $row->phone;?></td>
                                        <td>
                                            <a class="add" title="<?php echo $lang["Add"];?>" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                            <a href="edit_customers.php?edit=<?php echo $row->id;?>" class="edit" title="<?php echo $lang["Edit"];?>" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a href="view_customers.php?delete=<?php echo $row->id;?>" class="delete" title="<?php echo $lang["Delete"];?>" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
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
                                // header('Refresh: 0');
                                // exit();
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
            // console.log("DELETED");
            // $(".add-new").removeAttr("disabled");
        });
        // Calling live search function
        $(document).ready(function() {
            liveSearch("searchCustomers", "tableCustomers", 1, 4);
        });
    </script>
    <!-- End of view-customers -->
    <?php include "../includes/php/footer.php";?>