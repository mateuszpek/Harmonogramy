<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: login.php');
		exit();
	}
	
	if(isset($_SESSION["user"]["just_inserted_timetable_id"])){
		$id = $_SESSION["user"]["just_inserted_timetable_id"];
		unset($_SESSION["user"]["just_inserted_timetable_id"]);
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Harmonogramy</title>
	<link href="css/main.css" rel="stylesheet"/>
	<link href="css/index.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function(){
			if(($("#timetable_id").val()) > 0){
				$("#load_timetable").submit();
			}
		});
	</script>
</head>
<body>
	<div id="container">
		<a href="log.php?logout"><button id="logout">Wyloguj</button></a>
		<div id="hed">Strona główna</div>
		<hr/>
		<div id="buttons">
			<a href="addnew.php"><button class="main_button">Dodaj nowy harmonogram</button></a>
			<a href="options.php"><button class="main_button">Dodaj nowy schemat godzin</button></a>
			<a href="edit.php"><button class="main_button">Edytuj istniejące wersje</button></a>
		</div>
		<form id="load_timetable" action="timetable.php" method="POST" style="display:none">
			<input id="timetable_id" name="timetable_id" type="text" value="<?= $id?>"> 
		</form>
	</div>
</body>
</html>