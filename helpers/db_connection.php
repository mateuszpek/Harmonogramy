<?php
	
	$db['host'] = '';
	$db['user'] = '';
	$db['pass'] = '';
	$db['dbname'] = '';
	
	try {
		$pdo = new PDO( 'mysql:host='. $db['host'] .';dbname='. $db['dbname'] .';encoding=utf8;port=3306', $db['user'], $db['pass'] );
		$pdo->exec( 'set names utf8' );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch( PDOException $e ) { 
		header('Content-Type: text/html; charset=utf-8');
		die( 'Problem z połączeniem z bazą danych. Sprawdź dane w pliku db_connection.php' ); 
	}
?>