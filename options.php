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
	<link href="css/options.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#form1 input[name='name']").focusout(function(){
				if($(this).val().length > 0){
					$(this).addClass("correct");
					$(this).removeClass("incorrect");
				}else{
					$(this).prev(".name_error").show(500);
					$(this).addClass("incorrect");
					$(this).removeClass("correct");
				}
			});
			$("#form1 input[name='name']").change(function(){
				$(this).prev(".name_error").hide(500);
			});
			function validate(){
				$("#form1 .position").focusout(function(){
					if(($(this).val().search("&") == -1) && ($(this).val().length > 0)){
						$(this).addClass("correct");
						$(this).removeClass("incorrect");
					}else{
						$(this).prev(".position_error").show(500);
						$(this).addClass("incorrect");
						$(this).removeClass("correct");
					}
				});
				$("#form1 .position").change(function(){
					$(this).prev(".position_error").hide(500);
				});
				
				$("#form1 .position_value").focusout(function(){
					if(($(this).val().search("&") == -1) && !(isNaN($(this).val())) && ($(this).val().length > 0)){
						$(this).addClass("correct");
						$(this).removeClass("incorrect");
					}else{
						$(this).prev(".value_error").show(500);
						$(this).addClass("incorrect");
						$(this).removeClass("correct");
					}
				});
				$("#form1 .position_value").change(function(){
					$(this).prev(".value_error").hide(500);
				});
			};
			validate();
			var count_of_positions = 2; 
			$("#form1 #add_position").click(function(){
				if(count_of_positions<25){
					++count_of_positions;
					var new_one = "<div class=\"position_error error\" >Niepoprawna wartość</div> <input type=\"text\" maxlength=\"32\" name=\"position"+count_of_positions+"\" placeholder=\"#"+count_of_positions+"\" class=\"position\"/> <div class=\"value_error error\" >Niepoprawna wartość</div> <input type=\"text\" maxlength=\"3\" name=\"position"+count_of_positions+"_value\" placeholder=\"Wartość\" class=\"position_value\"/>";
					$("#form1 input[name=position"+(count_of_positions - 1)+"_value]").after(new_one);
					validate();
				}else{
					$("#form1 #add_position_error").show(500).delay( 2000 ).hide(500);
				}
			});
			$("#form1 #send_form").click(function(){
				var is_positions_correct;
				for(x=1;x<=count_of_positions;x++){
					if(($("#form1 input[name=position"+x+"]").hasClass("correct")) && ($("#form1 input[name=position"+x+"_value]").hasClass("correct"))){
						is_positions_correct = true;
					}else{
						is_positions_correct = false;
					}
				};
				if(($("#form1 input[name='name']").hasClass("correct")) && is_positions_correct){
					$("#form1").submit();
				}else{
					$("#form1 #send_form_error").show(500).delay( 1000 ).hide(500);
				}
				
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
		<div id="hed">Dodaj nowy schemat godzin</div>
		<hr/>
		<div id="hed2">Uzupełnij dane</div>
		<form id="form1" action="requests/save_schem.php" method="post" >
		
			<div class="label">Nazwa schematu:</div>
			<div class="name_error error" >Wpisz nazwe</div>
			<input type="text" maxlength="32" name="name" id="name" class="incorrect"/>
			
			
			<div class="label">Opcje(minimum dwie):</div>
			
			<div class="position_error error" >Niepoprawna wartość</div>
			<input type="text" maxlength="32" name="position1" placeholder="#1" class="position incorrect"/>
			<div class="value_error error" >Niepoprawna wartość</div>
			<input type="text" maxlength="3" name="position1_value" placeholder="Wartość" class="position_value incorrect"/>
			
			<div class="position_error error" >Niepoprawna wartość</div>
			<input type="text" maxlength="32" name="position2" placeholder="#2" class="position incorrect"/>
			<div class="value_error error" >Niepoprawna wartość</div>
			<input type="text" maxlength="3" name="position2_value" placeholder="Wartość" class="position_value incorrect"/>
			
			<div id="add_position_error" class="error" >Osiągnąłeś maksymalną ilość pozycji</div>
			<input id="add_position" type="button" value="Dodaj pozycję" />
			<div id="send_form_error" class="error" >Popraw dane</div>
			<input id="send_form" type="button" value="Gotowe" />
		</form>
	</div>
</body>
</html>