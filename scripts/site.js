/* ADMIN FUNCTIONS */

function adminLogout(){

	$.post('./validate_login.php',
		function(result){
			if(result == "true"){
				window.location = './admin.php';
			}
		});
}

function addArticle(title, body, image_url){

	var input_data = {
		"method": "addArticle",
		"title": title,
		"body": body,
		"image_url": image_url
	};

	$.post('./php_objects/article.php',
		input_data,
		function(result){
			if(result.indexOf('Error') < 0){
				alert("Success! Article #" + result + " added!");
				window.location = "./admin_news.php";
			}
			else{
				alert(result);
			}
		});
}

function loadArticlesToEdit(){

	var input_data = {
		"method": "getArticles"
	};

	$.post("./php_objects/article.php",
		input_data,
		function(result){

		});
}

/* TROUPE FUNCTIONS */

function showTroupeInfo(){

	$("#troupe_info").show();
	$("#troupe_info_bg").show();
}