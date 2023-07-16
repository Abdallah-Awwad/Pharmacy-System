    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="employees-view">
            <h1>
                <span><?= $lang["View Employee"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchEmployees" placeholder="What you looking for? (search by name or phone)">
                <a href="employees_add.php">
                    <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> <?= $lang["Add New"];?></button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableEmployees">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"];?></th>
                            <th><?= $lang["Name"];?></th>
                            <th><?= $lang["Phone"];?></th>
                            <th><?= $lang["Gender"];?></th>
                            <th><?= $lang["Age"];?></th>
                            <th><?= $lang["Address"];?></th>
                            <th><?= $lang["Salary"];?></th>
                            <th><?= $lang["Actions"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `employees`";
                            dbHandler($query, PDO::FETCH_OBJ, $result);
                            if ($result){
                                foreach($result as $row){
                                    echo "<tr>";
                                        echo "<td>$row->id</td>";
                                        echo "<td>$row->name</td>";
                                        echo "<td>$row->phone</td>";
                                        echo "<td>$row->gender</td>";
                                        echo "<td>$row->age</td>";
                                        echo "<td>$row->address</td>";
                                        echo "<td>$row->salary</td>";
                                        echo "<td>";
                                            echo "<a href='employees_edit.php?edit=".$row->id."' class='edit' title='".$lang["Edit"]."' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>";
                                            echo "<a href= '#' value='".$row->id."' class='delete' title='".$lang["Delete"]."' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            else {
                                echo "<tr>";
                                    echo "<td colspan='4'>" . $lang["No Records Found"] . "</td>";
                                echo "</tr>";
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
                'process': 'deleteExpense',
                'expenseID': $(this).attr("value")
            }
            requestAjax(bindValues, function(result){
                if (result === "success") {
                    $(this).parents("tr").remove();
                } 
                else {
                    var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>';
                    $("table").append(errorMessage);
                }
            });
        });
        $(document).ready(function() {
            liveSearch("searchEmployees", "tableEmployees", 1, 2);
        });
    </script>
    <!-- End of employees-view -->
    <?php include "../includes/php/footer.php";?>