let dashboardControllerURL = "controllers/controller_dashboard";
let invoicesControllerURL = "controllers/controller_invoices";
let medicinesControllerURL = "controllers/controller_medicines";
let inventoryControllerURL = "controllers/controller_inventory";
let purchasesControllerURL = "controllers/controller_purchases";
let expensesControllerURL = "controllers/controller_expenses";
let customersControllerURL = "controllers/controller_customers";
let employeesControllerURL = "controllers/controller_employees";
let manufacturersControllerURL = "controllers/controller_manufacturers";
let settingsControllerURL = "controllers/controller_settings";
let profilesControllerURL = "controllers/controller_profiles";

function sorting() {
    $('.sort').DataTable( {
        paging: false,
        info: false,
        filter: false,
    });
}
$(document).ready(function() {
    sorting();
});
function liveSearch(searchBoxID, tableID, columnOneIndex, columnTwoIndex) {
    (document.getElementById(searchBoxID)).addEventListener("keyup", function() {
        let keyword = this.value.toUpperCase();
        let all_tr = (document.getElementById(tableID)).getElementsByTagName("tr");
        for (let i = 0; i < all_tr.length; i++) {
            let firstColumn = all_tr[i].getElementsByTagName("td")[columnOneIndex];
            let secondColumn = all_tr[i].getElementsByTagName("td")[columnTwoIndex];
            if (firstColumn && secondColumn) {
                if ((((firstColumn.textContent || firstColumn.innerText).toUpperCase()).indexOf(keyword) > -1) || (((secondColumn.textContent || secondColumn.innerText).toUpperCase()).indexOf(keyword) > -1)) {
                    all_tr[i].style.display = "";
                } else {
                    all_tr[i].style.display = "none";
                }
            }
        }
    })
}
function requestAjax(bindValues, path, callback) {
    let form = new FormData();
    for (let key in bindValues) {
        form.append(key, bindValues[key]);
    }
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let result = xmlhttp.responseText;
            callback(result);
        }
    };
    xmlhttp.open("POST", path, true);
    xmlhttp.send(form);
}