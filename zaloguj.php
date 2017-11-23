<?php

session_start();
if ((!isset($_POST['login'])) ||  (!isset($_POST['password'])))
{
	header('Location:index.php');
	exit();
}

require_once "connect.php";

$connecting = @new mysqli($host, $db_user, $db_password, $db_name);

if($connecting->connect_errno!=0)
{
echo "Error: ".$connecting->connect_errno;
}
else
$login = $_POST['login'];
$haslo = $_POST['password'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");

if($result = $connecting->query(
sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
mysqli_real_escape_string($connecting,$login))))
{
	$ile_userow = $result->num_rows;
	if($ile_userow > 0)
	{
		$wiersz = $result->fetch_assoc();
		if (password_verify($haslo, $wiersz['pass']))
		{
			$_SESSION['zalogowany'] = true;
			$_SESSION['id'] = $wiersz['id'];
			$_SESSION['user'] = $wiersz['user'];
			$_SESSION['drewno'] = $wiersz['drewno'];
			$_SESSION['kamien'] = $wiersz['kamien'];
			$_SESSION['zboze'] = $wiersz['zboze'];
			$_SESSION['email'] = $wiersz['email'];
			$_SESSION['dnipremium'] = $wiersz['dnipremium'];

			unset($_SESSION['blad']);
			$result->free_result();
			header('Location:gra.php');
		}
		else
		{
			$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
			header('Location:index.php');
		}
	}
	else
	{
		$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
		header('Location:index.php');
	}
}

$connecting->close();

?>
