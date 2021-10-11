<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: ../login.php');
		exit();
	}
	( @include '../helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	try {
		$sql = "SELECT * FROM timetables WHERE id_user = ".$_SESSION["user"]["id"]." ORDER BY id DESC";
		foreach ($pdo->query($sql) as $row) {
			$fragment .= "<button value = \"".$row["id"]."\" class=\"main_button\">".$row["month_in_words"]." ".$row["year"]."</button>";
		};
		echo $fragment;
	}
	catch (PDOException $ex) {
       $msg = $ex->errorInfo;
       error_log(var_export($msg, true));
	} 
?>