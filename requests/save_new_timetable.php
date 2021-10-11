<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: ../login.php');
		exit();
	}
	( @include '../helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	try{
		$lastday = mktime (0,0,0,($_POST["month"] + 1),0,$_POST["year"]);
		$number_of_days = strftime ("%d", $lastday);
		$first_day_of_month = mktime (0,0,0,$_POST["month"],1,$_POST["year"]);
		$saturday_shift = (strftime("%u", $first_day_of_month) - 1);
		
		switch ($_POST["month"]) {
			case 1:
				$month_in_words = "Styczeń";
				break;
			case 2:
				$month_in_words = "Luty";
				break;
			case 3:
				$month_in_words = "Marzec";
				break;
			case 4:
				$month_in_words = "Kwiecień";
				break;
			case 5:
				$month_in_words = "Maj";
				break;
			case 6:
				$month_in_words = "Czerwiec";
				break;
			case 7:
				$month_in_words = "Lipiec";
				break;
			case 8:
				$month_in_words = "Sierpień";
				break;
			case 9:
				$month_in_words = "Wrzesień";
				break;
			case 10:
				$month_in_words = "Październik";
				break;
			case 11:
				$month_in_words = "Listopad";
				break;
			case 12:
				$month_in_words = "Grudzień";
				break;
		};
		
		$count_of_workers = (count($_POST) - 4);
		for($a=1;$a<=$count_of_workers;$a++){
			$workers .=", worker".$a;
			$workers_alias .=", :worker".$a;
		};
		$query = "INSERT INTO timetables (id_user, option_list_id, number_of_days, month, year, saturday_shift, month_in_words, w_hours".$workers.") VALUES (:id, :option_list_id, :number_of_days, :month, :year, :saturday_shift, :month_in_words, :w_hours".$workers_alias.")";
		$add_timetable = $pdo->prepare($query);
		$add_timetable->bindParam(":id", $_SESSION["user"]["id"], PDO::PARAM_INT);
		$add_timetable->bindParam(":option_list_id", $_POST["schem_id"], PDO::PARAM_INT);
		$add_timetable->bindParam(":number_of_days", $number_of_days, PDO::PARAM_INT, 2);
		$add_timetable->bindParam(":month", $_POST["month"], PDO::PARAM_INT, 2);
		$add_timetable->bindParam(":year", $_POST["year"], PDO::PARAM_INT, 4);
		$add_timetable->bindParam(":saturday_shift", $saturday_shift, PDO::PARAM_INT, 1);
		$add_timetable->bindParam(":month_in_words", $month_in_words, PDO::PARAM_STR, 64);
		$add_timetable->bindParam("w_hours", $_POST["hours"], PDO::PARAM_INT, 3);
		for($b=1;$b<=$count_of_workers;$b++){
			$add_timetable->bindParam(":worker".$b, $_POST["worker".$b], PDO::PARAM_STR, 64);
		};
		$add_timetable->execute();
		$_SESSION["user"]["just_inserted_timetable_id"] = $pdo->lastInsertId();
		header('Location: ../index.php');
	}catch(PDOException $ex){
		echo "ups";
		echo $ex->getMessage()."<br>";
	}
	//echo var_dump($_POST)."<br>";
	//echo $query;
	//echo $saturday_shift;
?>