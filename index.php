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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Harmonogramy</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
		<nav class="navbar bg-nav-blue navbar-dark">
			<div class="navbar-brand  mb-0">Witaj, <?=$_SESSION["user"]["name"]." ".$_SESSION["user"]["surname"]." !" ?> </div>
			<ul class="nav justify-content-end">
				<li class="nav-item">
					<a class="nav-link" href="log.php?logout"> Wyloguj </a>
				</li>
			</ul>
		</nav>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>