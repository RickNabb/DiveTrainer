/** AUTH METHODS **/

function logOut(){

	var input_data = {
		method: 'log_out'
	};

	$.post('../common/auth.php',
		input_data,
		function(data, success){
			if(data == '1'){
				window.location = "../index.php";
			}
		});
}