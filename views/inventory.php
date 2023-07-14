    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of inventory -->
        <div class="inventory">
            <h1>
                <span><?= $lang["Inventory"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control w-50" id="searchInventory" placeholder="What you looking for? (search by name or expiration date)">
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableInventory">
                    <thead>
                        <tr>
                            <th><?= $lang["inv inv ID"];?></th>
                            <th><?= $lang["inv med ID"];?></th>
                            <th><?= $lang["inv name"];?></th>
                            <th><?= $lang["inv purchase price"];?></th>
                            <th><?= $lang["inv selling price"];?></th>
                            <th><?= $lang["inv expiration date"];?></th>
                            <th><?= $lang["inv quantity"];?></th>
                            <th><?= $lang["inv sold"];?></th>
                            <th><?= $lang["inv returned"];?></th>
                            <th><?= $lang["inv stock"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `stock`";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); 
                            $result = $statement->fetchAll();
                            if ($result){
                                foreach($result as $row){
                                    echo "<tr>";
                                        echo "<td>$row->inv_id              </td>";
                                        echo "<td>$row->id                  </td>";
                                        echo "<td>$row->name                </td>";
                                        echo "<td>$row->purchase_price      </td>";
                                        echo "<td>$row->selling_price       </td>";
                                        echo "<td>$row->expiration_date     </td>";
                                        echo "<td>$row->quantity            </td>";
                                        echo "<td>$row->sold                </td>";
                                        echo "<td>$row->returned            </td>";
                                        echo "<td>$row->stock               </td>";
                                    echo "</tr>";
                                }
                            }
                            else {
                                echo "<tr>";
                                    echo "<td colspan=11>" . $lang["No Records Found"] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            liveSearch("searchInventory", "tableInventory", 2, 5);
        });
    </script>
    <!-- End of inventory -->
    <?php include "../includes/php/footer.php";?>