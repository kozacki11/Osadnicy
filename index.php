<?php
session_start();

if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true))
{
	header('Location:gra.php');
	exit();
}

 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http=equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>

<body>
Tylko martwi ujrzeli koniec wojny - Platon</br></br>

<a href="rejestracja.php">Rejestracja - załóż darmowe konto!</a>
</br></br>

<form action="zaloguj.php" method="POST">
Login: </br><input type="text" name="login" /> </br>
Haslo: </br><input type="password" name="password" /> </br></br>
<input type ="submit" value="zaloguj się" />
</form>
<?php
if(isset($_SESSION['blad']))
echo $_SESSION['blad'];
?>
</body>
</html>
