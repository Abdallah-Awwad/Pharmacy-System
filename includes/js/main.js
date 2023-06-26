
// var searchCustomers = document.getElementById("searchCustomers");

// searchCustomers.addEventListener("keyup",function(){
//     var keyword = this.value.toUpperCase();
//     var customers = document.getElementById("tableCustomers");
//     var all_tr = customers.getElementsByTagName("tr");
//     for(var i=0; i<all_tr.length; i++){
//             var name_column = all_tr[i].getElementsByTagName("td")[1];
//             var phone_column = all_tr[i].getElementsByTagName("td")[4];
//             if(name_column && phone_column){
//                 var name_value = name_column.textContent.toUpperCase() || name_column.innerText.toUpperCase();
//                 var email_value = phone_column.textContent.toUpperCase() || phone_column.innerText.toUpperCase();
// 				if((name_value.indexOf(keyword) > -1) || (email_value.indexOf(keyword) > -1)){
//                     all_tr[i].style.display = ""; // show
//                 }else{
//                     all_tr[i].style.display = "none"; // hide
//                 }
//             }
//         }
// })










// single column
// var searchBox_1 = document.getElementById("searchBox-1");
// searchBox_1.addEventListener("keyup", function(){
// 	var keyword = this.value;
// 	keyword = keyword.toUpperCase();
// 		var table_1 = document.getElementById("table-1");
// 		var all_tr = table_1.getElementsByTagName("tr");
// 		for(var i=0; i<all_tr.length; i++){
// 			var name_column = all_tr[i].getElementsByTagName("td")[0];
// 			if(name_column){
// 				var name_value = name_column.textContent || name_column.innerText;
// 				name_value = name_value.toUpperCase();
// 				if(name_value.indexOf(keyword) > -1){
// 					all_tr[i].style.display = ""; // show
// 				}else{
// 					all_tr[i].style.display = "none"; // hide
// 				}
// 			}
// 		}
// });




// All column
// var searchBox_3 = document.getElementById("searchBox-3");
// searchBox_3.addEventListener("keyup",function(){
// 	var keyword = this.value;
// 	keyword = keyword.toUpperCase();
// 	var table_3 = document.getElementById("table-3");
// 	var all_tr = table_3.getElementsByTagName("tr");
// 	for(var i=0; i<all_tr.length; i++){
// 			var all_columns = all_tr[i].getElementsByTagName("td");
// 		  for(j=0;j<all_columns.length; j++){
// 				if(all_columns[j]){
// 					var column_value = all_columns[j].textContent || all_columns[j].innerText;
					
// 					column_value = column_value.toUpperCase();
// 					if(column_value.indexOf(keyword) > -1){
// 						all_tr[i].style.display = ""; // show
// 						break;
// 					}else{
// 						all_tr[i].style.display = "none"; // hide
// 					}
// 				}
// 			}
// 		}
// })