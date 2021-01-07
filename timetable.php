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
	<link href="fontello/css/fontello.css" rel="stylesheet"/>
	<link href="css/timetable.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function() {
			const timetable_id = $("#timetable_id_div").text();
			var how_many_days = $("#timetable tr").length - 3;
			var how_many_workers = $("#timetable tr:nth-child(1) td").length -1;
			for(d=1;d<=how_many_days;d++){
				for(w=1;w<=how_many_workers;w++){
					var cell_position = "p"+w+"w"+d;
					$.ajax({
						url: "requests/download_timetable_cell.php",
						method: "POST",
						data: { c_p: cell_position,
								timetable_id: timetable_id
							},
						success: function(msg){
							var ms = msg.split("&");
							if(ms[1].length < 1){
								$("#"+ms[0]+" .option_list option").filter(function() {
									return $(this).text() === "-";
								}).attr("selected","selected");
							}else{
								$("#"+ms[0]+" .option_list option").filter(function() {
									return $(this).text() === ms[1];
								}).attr("selected","selected");
							};
						}
					});
				};
			};
			$(".option_list").change(function(){
				var cell_position = $(this).parent().attr("id");
				var content= $(this).find("option:selected").text();
				$.ajax({
						url: "requests/save_timetable_cell.php",
						method: "POST",
						data: { c_p: cell_position,
								ct:content,
								timetable_id: timetable_id
							},
							success: function(msg){
								if(msg == "error"){
									alert(msg);
								}
							}
					});
				
			});
			function count_hours(){
				for(x=1;x<=how_many_workers;x++){
					var sum = 0;
					for(y=1;y<=how_many_days;y++){
						sum += parseInt($("#p"+x+"w"+y+" select").find("option:selected").val());
					};
					sum = $("#hours_in_this_month"+x).text() - sum;
					$("#sum"+x).text(sum);
				};
			};
			$( document ).ajaxStop(function(){
				count_hours();
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
		<div id="hed">Harmonogram
			<?php
				( @include 'helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
				try {
					$sql = "SELECT * FROM timetables WHERE id = ".$_POST["timetable_id"]." AND id_user = ".$_SESSION["user"]["id"];
					foreach ($pdo->query($sql) as $timetable);
				}
				catch (PDOException $e) {
				   $msg = $e->errorInfo;
				   error_log(var_export($msg, true));
				};
				echo " ".$timetable["month_in_words"]." ".$timetable["year"]."<div id=\"timetable_id_div\" style=\"display:none\">".$_POST["timetable_id"]."</div>";
			?>
		</div>
		<hr/>
		<table id="timetable">
			<?php
				try {
					$sql = "SELECT * FROM options WHERE id = ".$timetable["option_list_id"];
					foreach ($pdo->query($sql) as $options);
				}
				catch (PDOException $e) {
				   $msg = $e->errorInfo;
				   error_log(var_export($msg, true));
				};
				//Generowanie listy opcji dla pól w tabeli do zmiennej $option_li
				$option_li = "<i><i/><select class=\"option_list\"><option value=\"0\" >-</option>";
				for($a=1;$a<=25;$a++){
					if($options["option".$a] !== NULL){
						$option_li .="<option value=\"".$options["option".$a."_value"]."\">".$options["option".$a]."</option>";
					}else{
						break;
					}
				};
				$option_li .= "</select>";
				//Zliczenie pracowników
				$how_many_workers = 0;
				for($i=1;$i<=8;$i++){
					if($timetable["worker".$i] !== NULL){
						$how_many_workers++;
					}
				};
				//Generowanie pierwszego wiersza tabeli
				$result = "<tr><td>Data</td>";
				for($k=1;$k<=$how_many_workers;$k++){
					$result .= "<td>".$timetable["worker".$k]."</td>";
				};
				$result .="</tr>";
				//Generowanie właściwej zawartości tabeli  i kolorowanie 
				if($timetable["saturday_shift"] == 6){
					$sunday = 1;
					$saturday = 7;
				}else{
					$sunday = 7 - $timetable["saturday_shift"];
					$saturday = $sunday - 1;
				}
				for($d=1;$d<=$timetable["number_of_days"];$d++){
					//wykrywanie soboty
					if($d == $saturday){
						$saturday += 7;
						$result .= "<tr style='background-color: #f0a30a'><td>".$d.".".$timetable["month"].".".$timetable["year"]."<i class=\"icon-calendar\"></i></td>";
							for($w=1;$w<=$how_many_workers;$w++){
								$result .= "<td id=\"p".$w."w".$d."\">".$option_li."</td>";
							};
						$result .="</tr>";
					}
					//wykrywanie niedzieli
					else if($d == $sunday){
						$sunday += 7;
						$result .= "<tr style='background-color: #f06a0a'><td>".$d.".".$timetable["month"].".".$timetable["year"]."<i class=\"icon-calendar\"></i></td>";
							for($w=1;$w<=$how_many_workers;$w++){
								$result .= "<td id=\"p".$w."w".$d."\">".$option_li."</td>";
							};
						$result .="</tr>";
					}else{
						$result .= "<tr><td>".$d.".".$timetable["month"].".".$timetable["year"]."<i class=\"icon-calendar\"></i></td>";
							for($w=1;$w<=$how_many_workers;$w++){
								$result .= "<td id=\"p".$w."w".$d."\">".$option_li."</td>";
							};
						$result .="</tr>";
					}
					
					
				};
				//Generowanie przedostatniego wiersza
				$result .= "<tr><td>Pozostało do rozdania</td>";
				for($k=1;$k<=$how_many_workers;$k++){
					$result .= "<td id=\"sum".$k."\"></td>";
				};
				$result .="</tr>";
				//Generowanie ostatniego wiersza
				$result .= "<tr><td>Ilość godzin</td>";
				for($k=1;$k<=$how_many_workers;$k++){
					$result .= "<td id=\"hours_in_this_month".$k."\">".$timetable["w_hours"]."</td>";
				};
				$result .="</tr>";
				echo $result;
			?>
		</table>
	</div>
</body>
</html>
	<?php
	//	echo $how_many_workers."<br /><br />";
	//	echo var_dump($options)."<br /><br />";
	//	echo var_dump($timetable)."<br /><br />";
	//	echo var_dump($_POST);
	?>
