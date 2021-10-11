<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: ../login.php');
		exit();
	}
	( @include '../helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	try {
		$sql = "SELECT ".$_POST["c_p"]." FROM timetables WHERE id_user = ".$_SESSION["user"]["id"]." AND id=".$_POST["timetable_id"];
		foreach ($pdo->query($sql) as $row) {
			$answer = $row[$_POST["c_p"]] ;
		};
	}
	catch (PDOException $ex) {
       $msg = $ex->errorInfo;
       error_log(var_export($msg, true));
	} 
	echo $_POST["c_p"]."&".$answer;
?>