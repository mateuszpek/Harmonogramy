<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: login.php');
		exit();
	}
	( @include 'helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	try {
		$sql = "SELECT id, name FROM options WHERE user_id = ".$_SESSION["user"]["id"];
		foreach ($pdo->query($sql) as $row) {
			$schem_list .= "<option value=\"".$row["id"]."\">".$row["name"]."</option>";
		};
	}
	catch (PDOException $ex) {
       //echo $ex->getMessage();
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
	<link href="css/addnew.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#form1 input[name='month']").focusout(function(){
				if(($(this).val().length > 0) && !(isNaN($(this).val())) && ($(this).val() >= 1) && ($(this).val() <= 12)){
					$(this).addClass("correct");
					$(this).removeClass("incorrect");
				}else{
					$(this).prev(".error").show(500);
					$(this).addClass("incorrect");
					$(this).removeClass("correct");
				}
			});
			$("#form1 input[name='month']").change(function(){
				$(this).prev(".error").hide(500);
			});
			$("#form1 input[name='year']").focusout(function(){
				if(($(this).val().length > 0) && !(isNaN($(this).val())) && ($(this).val() >= 1970) && ($(this).val() <= 2100)){
					$(this).addClass("correct");
					$(this).removeClass("incorrect");
				}else{
					$(this).prev(".error").show(500);
					$(this).addClass("incorrect");
					$(this).removeClass("correct");
				}
			});
			$("#form1 input[name='year']").change(function(){
				$(this).prev(".error").hide(500);
			});
			$("#form1 input[name='hours']").focusout(function(){
				if(($(this).val().length > 0) && !(isNaN($(this).val())) && ($(this).val() >= 1) && ($(this).val() <= 999)){
					$(this).addClass("correct");
					$(this).removeClass("incorrect");
				}else{
					$(this).prev(".error").show(500);
					$(this).addClass("incorrect");
					$(this).removeClass("correct");
				}
			});
			$("#form1 input[name='hours']").change(function(){
				$(this).prev(".error").hide(500);
			});
			
			function validate(){
				$("#form1 .worker").focusout(function(){
					if(($(this).val().search("&") == -1) && ($(this).val().length > 0)){
						$(this).addClass("correct");
						$(this).removeClass("incorrect");
					}else{
						$(this).prev(".error").show(500);
						$(this).addClass("incorrect");
						$(this).removeClass("correct");
					}
				});
				$("#form1 .worker").change(function(){
					$(this).prev(".error").hide(500);
				});
			};
			validate();
			var count_of_workers = 2; 
			$("#form1 #add_worker").click(function(){
				if(count_of_workers<8){
					++count_of_workers;
					var new_one = "<div class=\" error\" >Niepoprawna wartość</div> <input type=\"text\" maxlength=\"64\" name=\"worker"+count_of_workers+"\" placeholder=\"#"+count_of_workers+"\" class=\"worker\"/> ";
					$("#form1 input[name=worker"+(count_of_workers - 1)).after(new_one);
					validate();
				}else{
					$("#form1 #add_worker_error").show(500).delay(2000).hide(500);
				}
			});
			$("#schem_list").change(function(){
				if($(this).val() != "default"){
					$("#form1 input[name='schem_id']").val($(this).val());
					$(this).addClass("correct");
					$(this).removeClass("incorrect");
					$(this).prev(".error").hide(500);
				}else{
					$(this).addClass("incorrect");
					$(this).removeClass("correct");
					$(this).prev(".error").show(500);
				}	
			});
			$("#form1 #send_timetable").click(function(){
				var is_workers_correct;
				for(x=1;x<=count_of_workers;x++){
					if($("#form1 input[name=worker"+x+"]").hasClass("correct")){
						is_workers_correct = true;
					}else{
						is_workers_correct = false;
					}
				};
				if(($("#form1 input[name='month']").hasClass("correct")) && ($("#form1 input[name='year']").hasClass("correct")) && ($("#form1 input[name='hours']").hasClass("correct")) && ($("#schem_list").hasClass("correct")) && is_workers_correct){
					$("#form1").submit();
				}else{
					$("#form1 #send_timetable_error").show(500).delay(2000).hide(500);
				}
			});
			
		});
	</script>
</head>
<body>
	<div id="container">
		<nav class="navbar bg-nav-blue navbar-dark">
			<div class="navbar-brand  mb-0">Witaj, <?=$_SESSION["user"]["name"]." ".$_SESSION["user"]["surname"]." !" ?> </div>
			<ul class="nav justify-content-end">
				<li class="nav-item">
					<a class="nav-link" href="index.php"> Wróć </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="log.php?logout"> Wyloguj </a>
				</li>
			</ul>
		</nav>
		<div id="hed">Dodaj nowy harmonogram</div>
		<hr/>
		<div id="hed2">Uzupełnij dane</div>
		<form id="form1" action="requests/save_new_timetable.php" method="post" >
			
			<div class="label">Miesiąc(liczbą):</div>
			<div id="month_error" class="error" >Niepoprawna wartość</div>
			<input maxlength="2" type="text" name="month" class="incorrect"/>
			
			<div class="label">Rok:</div>
			<div class="error" >Niepoprawna wartość</div>
			<input maxlength="4" type="text" name="year" class="incorrect"/>
			
			<div class="label">Godziny do wyrobienia:</div>
			<div class="error" >Niepoprawna wartość</div>
			<input maxlength="3" type="text" name="hours" class="incorrect"/>
			
			
			<div class="label">Wybierz schemat:</div>
			<div class="error" >Wybierz!</div>
			<select id="schem_list">
				<option value="default">-</option>
				<?= $schem_list?>
			</select>
			<input style="display:none" type="text" name="schem_id" class="incorrect"/>
			
			
			<div class="label">Pracownicy:</div>
			<div class="error" >Niepoprawna wartość</div>
			<input maxlength="64" type="text" name="worker1" placeholder="#1" class="worker incorrect"/>
			<div class="error" >Niepoprawna wartość</div>
			<input maxlength="64" type="text" name="worker2" placeholder="#2" class="worker incorrect"/>
			
			<div id="add_worker_error" class="error" >Osiągnąłeś maksymalną ilość pracowników</div>
			<input id="add_worker" type="button" value="Dodaj pracownika" />
			<div id="send_timetable_error" class="error" >Popraw dane zanim zapiszesz</div>
			<input id="send_timetable" type="button" value="Gotowe" />
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>