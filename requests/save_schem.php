<?php
	session_start();
	if (!(isset($_SESSION['logged']))){
		header('Location: ../login.php');
		exit();
	}
	( @include '../helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	try{
		$count_of_params = (count($_POST) - 1) / 2;
		for($a=1;$a<=$count_of_params;$a++){
			$params .=", option".$a.", option".$a."_value";
			$values .=", :option".$a.", :option".$a."_value";
		};
		$query = "INSERT INTO options (user_id, name".$params.") VALUES (:id, :name".$values.")";
		$add_schem = $pdo->prepare($query);
		$add_schem->bindParam(":id", $_SESSION["user"]["id"], PDO::PARAM_INT);
		$add_schem->bindParam(":name", $_POST["name"], PDO::PARAM_STR, 32);
		for($b=1;$b<=$count_of_params;$b++){
			$add_schem->bindParam(":option".$b, $_POST["position".$b], PDO::PARAM_STR, 32);
			$add_schem->bindParam(":option".$b."_value", $_POST["position".$b."_value"], PDO::PARAM_INT, 3);
		};
		$add_schem->execute();
		header('Location: ../index.php');
	}catch(PDOException $ex){
		echo "ups";
		//echo $ex->getMessage()."<br>";
	}
?>