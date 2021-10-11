<?
	header('Content-Type: text/html; charset=utf-8');
	
	( @include 'helpers/db_connection.php' ) || die( 'Brak pliku db_connection.php' );
	for($p=1;$p<=8;$p++){
		for($w=1;$w<=31;$w++){
			$val = "p".$p."w".$w;
			$newHarm = $pdo->prepare('ALTER TABLE timetables ADD '.$val.' text');
			if($newHarm->execute()){
				echo "sukces ".$val."<br>";
			}
			else{
				echo "fail";
			}
		};
	};
?>