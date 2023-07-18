    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="expenses-view">
            <h1>
                <span><?= $lang["View expenses"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchExpenses" placeholder="What you looking for? (search by name or category)">
                <a href="expenses_add">
                    <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> <?= $lang["Add New"];?></button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableExpenses">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"];?></th>
                            <th><?= $lang["Name"];?></th>
                            <th><?= $lang["Description"];?></th>
                            <th><?= $lang["Amount"];?></th>
                            <th><?= $lang["Category"];?></th>
                            <th><?= $lang["Actions"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `expenses`";
                            dbHandler($query, PDO::FETCH_OBJ, $result);
                            if ($result){
                                foreach($result as $row){
                                    echo "<tr>";
                                        echo "<td>$row->id</td>";
                                        echo "<td>$row->name</td>";
                                        echo "<td>$row->description</td>";
                                        echo "<td>$row->amount</td>";
                                        echo "<td>$row->category</td>";
                                        echo "<td>";
                                            echo "<a href='expenses_edit?edit=".$row->id."' class='edit' title='".$lang["Edit"]."' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>";
                                            echo "<a href= '#' value='".$row->id."' class='delete' title='".$lang["Delete"]."' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            else {
                                echo "<tr>";
                                    echo "<td colspan='6'>" . $lang["No Records Found"] . "</td>";
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
            let selectedRow = $(this).parents("tr");
            requestAjax(bindValues, function(result){
                if (result === "success") {selectedRow.remove();} 
                else {
                    var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>';
                    $("table").append(errorMessage);
                }
            });
        });
        $(document).ready(function() {
            liveSearch("searchExpenses", "tableExpenses", 1, 4);
        });
    </script>
    <?php include "../includes/php/footer.php";?>