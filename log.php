<?php
	session_start();
	if (((!isSet($_POST['login'])) || (!isSet($_POST['password']))) && (!isSet($_GET))){	
		header('Location: login.php');
		exit();
	};
	( @include 'helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	if (empty($_SESSION['user'])) {
		if ((isSet($_POST['login'])) && (isSet($_POST['password']))) {
			$user = $pdo->prepare('SELECT * FROM users WHERE login=? AND password=? LIMIT 1');
			$user->execute(array(
				$_POST['login'],
				md5($_POST['password'])
			));
			if ($user->rowCount() > 0) {
				echo "git";
				$user = $user->fetch(PDO::FETCH_ASSOC);
				$_SESSION['user'] = $user;
				$_SESSION['logged'] = true;
				unSet($_SESSION['error']);
				header( "Location: index.php" );
				exit;
			} else {
				header( "Location: login.php" );
				$_SESSION['error'] = "Nieprawidłowy login lub hasło";
			}
		}
	} 
	else {
		if(isset($_GET['logout'])){
			session_destroy();
			header( "Location: login.php"); 
			exit;
		} 
		else{
			header("Location: index.php ");
			exit;
		}
	};
?>