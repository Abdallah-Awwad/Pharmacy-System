    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <!-- Start of view-medicines -->
        <div class="view-medicines">
            <h1>
                <span><?= $lang["View medicines"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchMedicines" placeholder="What you looking for? (search by name or manufactory)">
                <a href="medicine_add">
                    <button type="button" class="add-btn btn btn-info add-new "><i class="fa fa-plus"></i> <?= $lang["Add New"];?></button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover sort" id="tableMedicines">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"];?></th>
                            <th><?= $lang["Name"];?></th>
                            <th><?= $lang["Manufacture"];?></th>
                            <th><?= $lang["Actions"];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT medicines.id, medicines.name, manufacturers.name AS manufactory_name FROM `medicines` JOIN `manufacturers` ON medicines.manufacture_id = manufacturers.id";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $statement->setFetchMode(PDO::FETCH_OBJ); 
                            $result = $statement->fetchAll();
                            if ($result){
                                foreach($result as $row){
                                    echo "<tr>";
                                        echo "<td>$row->id</td>";
                                        echo "<td>$row->name</td>";
                                        echo "<td>$row->manufactory_name</td>";
                                        echo "<td>";
                                            echo "<a href='medicine_edit?edit=".$row->id."' class='edit' title='".$lang["Edit"]."' data-toggle='tooltip'><i class='fa-solid fa-pen'></i></a>";
                                            echo "<a href= '#' value='".$row->id."' class='delete' title='".$lang["Delete"]."' data-toggle='tooltip'><i class='fa-solid fa-trash'></i></a>";
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
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var medDelete = $(this).attr("value");
            $(this).parents("tr").remove();
            var deleteMedicineForm = new FormData();
            var process = "deleteMedicine";
            deleteMedicineForm.append('process', process);
            deleteMedicineForm.append('medicineID', medDelete);
            // ajax code to send data to controller.php 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    // if there is a response ... show error message .. 
                    var result = xmlhttp.responseText;
                    if (result === "success"){}
                    else {
                        var errorMessage = '<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>'
                        $("table").append(errorMessage);
                    }
                }
            };
            xmlhttp.open("POST", "controller", true);
            xmlhttp.send(deleteMedicineForm);
        });
        $(document).ready(function() {
            liveSearch("searchMedicines", "tableMedicines", 1, 2);
        });
    </script>
    <?php include "../includes/php/footer.php";?>