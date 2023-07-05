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
                <table class="table table-bordered table-striped table-hover" id="tableCustomers">
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
                                        <td><?= $row->id; ?></td>
                                        <td><?= $row->name; ?></td>
                                        <td><?= $row->gender; ?></td>
                                        <td><?= $row->address; ?></td>
                                        <td><?= $row->phone; ?></td>
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
                                // exit();
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
<!-- Start of Script to edit, add and delete in the front end -->
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();
	// Append table with add row form on add new button click
    $(".add-new").click(function(){
		$(this).attr("disabled", "disabled");
		var index = $("table tbody tr:last-child").index();
        var row = '<tr>' +
            '<td><input type="text" class="form-control" name="id" id="id"></td>' +
            '<td><input type="text" class="form-control" name="customerName" id="customerName"></td>' +
            '<td><input type="text" class="form-control" name="gender" id="gender"></td>' +
            '<td><input type="text" class="form-control" name="address" id="address"></td>' +
            '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
			'<td>' + actions + '</td>' +
        '</tr>';
    	$("table").append(row);		
		$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
	// Add row on add button click
	$(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('input[type="text"]');
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		if(!empty){
			input.each(function(){
				$(this).parent("td").html($(this).val());
			});			
			$(this).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");
		}		
    });
	// Edit row on edit button click
	$(document).on("click", ".edit", function(){		
        $(this).parents("tr").find("td:not(:last-child)").each(function(){
			$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
		});		
		$(this).parents("tr").find(".add, .edit").toggle();
		$(".add-new").attr("disabled", "disabled");
    });
	// Delete row on delete button click
	$(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
		$(".add-new").removeAttr("disabled");
    });
});
</script>
<!-- End of Script to edit, add and delete in the front end -->
<!-- Start of Script to retreive the rows from the db -->
<script>
    var searchCustomers = document.getElementById("searchCustomers");
    searchCustomers.addEventListener("keyup",function() {
        var keyword = this.value.toUpperCase();
        var customers = document.getElementById("tableCustomers");
        var all_tr = customers.getElementsByTagName("tr");
        for(var i=0; i<all_tr.length; i++) {
            var name_column = all_tr[i].getElementsByTagName("td")[1];
            var phone_column = all_tr[i].getElementsByTagName("td")[4];
            if(name_column && phone_column) {
                var name_value = name_column.textContent.toUpperCase() || name_column.innerText.toUpperCase();
                var email_value = phone_column.textContent.toUpperCase() || phone_column.innerText.toUpperCase();
                if((name_value.indexOf(keyword) > -1) || (email_value.indexOf(keyword) > -1)) {
                    all_tr[i].style.display = ""; // show
                }
                else {
                    all_tr[i].style.display = "none"; // hide
                }
            }
        }
    })
</script>
<!-- End of Script to retreive the rows from the db -->
<script>
$(document ).ready(function() {
    $('#tableCustomers').DataTable({
        paging: false,
        info: false,
        filter: false,
    });
});
</script>
<!-- End of sorting in Jquery -->
<!-- End of view-customers -->
<?php include "../includes/php/footer.php";?>