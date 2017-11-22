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
$password = $_POST['password'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");
$password = htmlentities($password, ENT_QUOTES, "UTF-8");

if($result = $connecting->query(
sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",
mysqli_real_escape_string($connecting,$login),
mysqli_real_escape_string($connecting,$password))))
{
	$ile_userow = $result->num_rows;
	if($ile_userow > 0)
	{
		$_SESSION['zalogowany'] = true;

		$row = $result->fetch_assoc();
		$_SESSION['id'] = $row['id'];
		$_SESSION['user'] = $row['user'];
		$_SESSION['drewno'] = $row['drewno'];
		$_SESSION['kamien'] = $row['kamien'];
		$_SESSION['zboze'] = $row['zboze'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['dnipremium'] = $row['dnipremium'];

		unset($_SESSION['blad']);
		$result->close();
		header('Location:gra.php');
	}
	else
	{
		$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
		header('Location:index.php');
	}
}

$connecting->close();

?>
