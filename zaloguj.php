<?php
session_start();
require_once "connect.php";

$connecting = @new mysqli($host, $db_user, $db_password, $db_name);

if($connecting->connect_errno!=0)
{
echo "Error: ".$connecting->connect_errno;
}
else
{
$login = $_POST['login'];
$password = $_POST['password'];


$sql = "SELECT * FROM uzytkownicy WHERE user='$login' AND pass='$password'";

if($result = @$connecting->query($sql))
{
	$ile_userow = $result->num_rows;
	if($ile_userow = 1)
	{
		$row = $result->fetch_assoc();
		$_SESSION['user'] = $row['user'];

		
		$result->close();
		header('Location:gra.php');
	}
	else
	{
	
	}
}

$connecting->close();

}







?>