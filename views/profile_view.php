    <?php include "../includes/php/header.php" ?>
    <div class="main-page" id="mainPage">
        <div class="view-profile">
            <h1>
                <span><?= $lang["View all profiles"] ?></span>
            </h1>
            <div class="d-flex justify-content-between align-items-start">
                <input type="text" class="search form-control" id="searchProfile" placeholder="What you looking for? (search by username or phone)">
                <a href="profile_register">
                    <button type="button" class="add-btn btn btn-info add-new ">
                        <i class="fa fa-plus"></i> <?= $lang["Add New"] ?>
                    </button>
                </a>
            </div>
            <div class="frame-box card-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableProfile">
                    <thead>
                        <tr>
                            <th><?= $lang["ID"] ?></th>
                            <th><?= $lang["Name"] ?></th>
                            <th><?= $lang["Phone"] ?></th>
                            <th><?= $lang["Username"] ?></th>
                            <th><?= $lang["Role"] ?></th>
                            <th><?= $lang["Created at"] ?></th>
                            <th><?= $lang["Last update"] ?></th>
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
            requestAjax({'process' : 'readAllProfiles'}, function (result) {
                if (result == "[]") {
                    $("tbody").append('<tr> <td colspan="8"> <?= $lang["No Records Found"]?> </td> </tr>');
                } else {
                    result = JSON.parse(result);
                    $.each(result, function (key, value) {
                        let td = '';
                        for (i = 0; i < Object.values(value).length; i++) {
                            td += '<td>' + Object.values(value)[i] + '</td>';
                        }
                        tr = '<tr>' + '</td>' + td + 
                                '<td>' +
                                    "<a href='profile_edit?edit=" + value['id'] + "' class='edit' title='<?=$lang['Edit']?>' data-toggle='tooltip'><i class='fa-solid fa-pen'></i></a>" + 
                                    "<a href= '#' value='" + value['id'] + "' class='delete' title='<?= $lang['Delete']?>' data-toggle='tooltip'><i class='fa-solid fa-trash'></i></a>" + 
                                '</td>' +
                            '</tr>';
                        $("tbody").append(tr);
                    });
                    $("table").addClass("sort");
                    sorting();
                }
            });
            liveSearch("searchProfile", "tableProfile", 2, 3);
        });
        $(document).on("click", ".delete", function() {
            let selectedRow = $(this).parents("tr");
            requestAjax({'process' : 'deleteProfile', 'profileID' : $(this).attr("value")}, function (result) {
                console.log(result);
                if (result === "Success") {
                    selectedRow.remove();
                } else {
                    $("table").append('<div class="alert alert-danger float-start p-2" id="remove" role="alert">' + result + '</div>');
                }
            });
        });
    </script>
    <?php include "../includes/php/footer.php" ?>