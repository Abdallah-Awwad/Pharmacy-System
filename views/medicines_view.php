    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="view-medicines">
            <h1>
                <span><?= $lang["View medicines"] ?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchMedicines" placeholder="What you looking for? (search by name or manufactory)">
                <a href="medicines_add">
                    <button type="button" class="add-btn btn btn-info add-new ">
                        <i class="fa fa-plus"></i> <?= $lang["Add New"] ?>
                    </button>
                </a>
            </div>
            <div class="frame-div frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableMedicines">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"] ?></th>
                            <th><?= $lang["Name"] ?></th>
                            <th><?= $lang["Manufacturer"] ?></th>
                            <th><?= $lang["Actions"] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            requestAjaxV2({'process' : 'readAllMedicines'}, medicinesControllerURL, function (result) {
                result = JSON.parse(result);
                if (result.length) {
                    $.each(result, function (key, value) {
                        let td = '';
                        for (i = 0; i < Object.values(value).length; i++) {
                            td += '<td>' + Object.values(value)[i] + '</td>';
                        }
                        tr = '<tr>' + '</td>' + td + 
                                '<td>' +
                                    "<a href='medicines_edit?edit=" + value['id'] + "' class='edit' title='<?=$lang['Edit']?>' data-toggle='tooltip'><i class='fa-solid fa-pen'></i></a>" + 
                                    "<a href= '#' value='" + value['id'] + "' class='delete' title='<?= $lang['Delete']?>' data-toggle='tooltip'><i class='fa-solid fa-trash'></i></a>" + 
                                '</td>' +
                            '</tr>';
                        $("tbody").append(tr);
                    });
                    $("table").addClass("sort");
                    sorting();
                } else {
                    $("tbody").append('<tr> <td colspan="4"> <?= $lang["No Records Found"]?> </td> </tr>');
                }
            });
            liveSearch("searchMedicines", "tableMedicines", 1, 2);
        });
        $(document).on("click", ".delete", function() {
            let selectedRow = $(this).parents("tr");
            requestAjaxV2({'process' : 'deleteMedicine', 'medicineID' : $(this).attr("value")}, medicinesControllerURL, function (result) {
                if (result === "Success") {
                    selectedRow.remove();
                } else {
                    $(".frame-div").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        });
    </script>
    <?php include "../includes/php/footer.php" ?>