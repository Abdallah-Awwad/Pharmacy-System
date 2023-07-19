    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">
        <div class="expenses-view">
            <h1>
                <span><?= $lang["View expenses"];?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchExpenses" placeholder="What you looking for? (search by name or category)">
                <a href="expenses_add">
                    <button type="button" class="add-btn btn btn-info add-new"><i class="fa fa-plus"></i> <?= $lang["Add New"];?></button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableExpenses">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            let bindValues = {
                'process': 'readAllExpense'
            }
            requestAjax(bindValues, function(result){
                if (result == "[]"){
                    $("tbody").append('<tr> <td colspan="6"> <?= $lang["No Records Found"]?> </td> </tr>');
                }
                else{
                    result = JSON.parse(result);
                    $.each(result, function(serial, value){ 
                        let td = '';
                        for(i = 0; i < Object.values(value).length; i++){
                            td += '<td>' + Object.values(value)[i] + '</td>';
                            tr = '<tr>' + '</td>' + td + 
                                    '<td>' +
                                        "<a href='expenses_edit?edit="+value['id']+"' class='edit' title='<?=$lang['Edit']?>' data-toggle='tooltip'><i class='fa-solid fa-pen'></i></a>" + 
                                        "<a href= '#' value='"+value['id']+"' class='delete' title='<?= $lang['Delete']?>' data-toggle='tooltip'><i class='fa-solid fa-trash'></i></a>" + 
                                    '</td>' +
                                '</tr>';
                        }
                        $("tbody").append(tr);
                    });
                    $("table").addClass("sort");
                    sorting();
                }
            });
            liveSearch("searchExpenses", "tableExpenses", 1, 4);
        });
        $(document).on("click", ".delete", function(){
            let bindValues = {
                'process': 'deleteExpense',
                'expenseID': $(this).attr("value")
            }
            let selectedRow = $(this).parents("tr");
            requestAjax(bindValues, function(result){
                if (result === "success"){
                    selectedRow.remove();
                } 
                else {
                    $("table").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        });
    </script>
    <?php include "../includes/php/footer.php";?>