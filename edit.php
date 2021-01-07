<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: login.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Harmonogramy</title>
	<link href="css/main.css" rel="stylesheet"/>
	<link href="css/edit.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$.ajax({
					url: "requests/download_options.php"
				})
			.done(function( msg ) {
				$("#options").html(msg);
				$(".main_button").on("click", function(){
					$("#timetable_id").val($(this).val());
					$("#load_timetable").submit();
				});
			});	
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="f_buttons">
			<a href="index.php"><button id="go_back">Wróć</button></a>
			<a href="log.php?logout"><button id="logout">Wyloguj</button></a>
		</div>
		<div id="hed">Edytuj istniejące wersje</div>
		<hr/>
		<div id="options">
			
		</div>
	</div>
	<form id="load_timetable" action="timetable.php" method="POST" style="display:none">
		<input id="timetable_id" name="timetable_id" type="text"></input>
	</form>
</body>
</html>