<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: ../login.php');
		exit();
	}
	( @include '../helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	
	$update_cell = $pdo->prepare("UPDATE timetables SET ".$_POST['c_p']." = ? WHERE id = ?");
	$update_cell->bindParam(1, $_POST["ct"], PDO::PARAM_STR, 12);
	$update_cell->bindParam(2, $_POST["timetable_id"], PDO::PARAM_INT);
	if($update_cell->execute()){
		echo "saved";
	}else{
		echo "error";
	}
?>