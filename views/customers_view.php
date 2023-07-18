    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="view-customers">
            <h1>
                <span><?= $lang["View customers"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchCustomers" placeholder="What you looking for? (search by name or phone)">
                <a href="customers_add">
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
                            dbHandler($query, PDO::FETCH_OBJ, $result);
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
                                            <a href="customers_edit?edit=<?= $row->id;?>" class="edit" title="<?= $lang["Edit"];?>" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a href="#" class="delete" value='<?= $row->id;?>' title="<?= $lang["Delete"];?>" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
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
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).on("click", ".delete", function(){
            let bindValues = {
                'process': 'deleteCustomer',
                'customerID': $(this).attr("value")
            }
            let selectedRow = $(this).parents("tr");
            requestAjax(bindValues, function(result){
                if (result === "Success") {selectedRow.remove();} 
                else {
                    var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>';
                    $("table").append(errorMessage);
                }
            });
        });
        $(document).ready(function() {
            liveSearch("searchCustomers", "tableCustomers", 1, 4);
        });
    </script>
    <?php include "../includes/php/footer.php";?>