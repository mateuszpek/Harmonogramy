<?php
	session_start();
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link href="css/main.css" rel="stylesheet"/>
	<link href="css/login.css" rel="stylesheet"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<title>Harmonogramy</title>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function(){
			function tryit(){
				$("#form1 input[name='login']").val("tryit");
				$("#form1 input[name='password']").val("tryit");
				$("#form1").submit();
			};
			$("#form1 input[name='tryit']").click(function(){tryit()});
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="hed">Logowanie</div>
		<hr/>
		<form id="form1" action="log.php" method="post" >
			<div class="label">Login:</div>
			<input name="login" type="text" placeholder="Login"/><br/>
			<div class="label">Hasło:</div>
			<input name="password" type="password" placeholder="Hasło"/><br/><br/>
			<?php
				if(isset($_SESSION['error'])){
					echo $_SESSION['error'];
					unSet($_SESSION['error']);
				};
			?>
			<input type="submit" value="Zaloguj się" />
			<input name="tryit" type="button" value="Wypróbuj bez logowania" />
		</form>
	</div>
</body>
</html>
