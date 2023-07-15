// Start of sorting in Jquery 
$(document).ready(function() {
    $('.sort').DataTable({
        paging: false,
        info: false,
        filter: false,
    });
});
// End of sorting in Jquery
// Start of searching function 
function liveSearch(searchBoxID, tableID, columnOneIndex, columnTwoIndex) {
    var searchBox = document.getElementById(searchBoxID);
    searchBox.addEventListener("keyup",function() {
        var keyword = this.value.toUpperCase();
        var table = document.getElementById(tableID);
        var all_tr = table.getElementsByTagName("tr");
        for(var i=0; i<all_tr.length; i++) {
            var firstColumn = all_tr[i].getElementsByTagName("td")[columnOneIndex];
            var secondColumn = all_tr[i].getElementsByTagName("td")[columnTwoIndex];
            if(firstColumn && secondColumn) {
                var firstColumnValue = firstColumn.textContent.toUpperCase() || firstColumn.innerText.toUpperCase();
                var secondColumnValue = secondColumn.textContent.toUpperCase() || secondColumn.innerText.toUpperCase();
                if((firstColumnValue.indexOf(keyword) > -1) || (secondColumnValue.indexOf(keyword) > -1)) {
                    all_tr[i].style.display = ""; // show
                }
                else {
                    all_tr[i].style.display = "none"; // hide
                }
            }
        }
    })
}
// End of searching function 
// Start of Ajax request function 
function requestAjax(bindValues, callback) {
    let Form = new FormData();
    for (let key in bindValues) {
        Form.append(key, bindValues[key]);
    }
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let result = xmlhttp.responseText;
            callback(result);
        }
    };
    xmlhttp.open("POST", "controller.php", true);
    xmlhttp.send(Form);
}
// End of Ajax request function 