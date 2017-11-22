<?php
session_start();

if (isset($_POST['email']))
{
	//Udana walidacja? Załóżmy, że tak!
	$wszystko_ok = true;

	//Sprawdzenie poprawności nick'a
	$nick = $_POST['nick'];

	//Sprawdzenie długości nick'a
	if ((strlen($nick)<3) || (strlen($nick)>20))
	{
			$wszystko_ok=false;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
	}

	if (ctype_alnum($nick)==false)
	{
		$wszystko_ok=false;
		$_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
	}

	//Sprawdz poprawność adresu imap_getmailboxes
	$email = $_POST['email'];
	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

	if ((filter_var($emailB, FILTER_SANITIZE_EMAIL)==false) || ($emailB!=$email))
	{
		$wszystko_ok = false;
		$_SESSION['e_email'] = "Podaj poprawny adres email";
	}

	//Sprawdz poprawnosć hasła
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];


	if ($wszystko_ok==true)
	{
			//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy.
			echo "Udana walidacja";
			exit();
	}
}

 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http=equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - załóż darmowe konto</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<style>

		.error
		{
		color:red;
		margin-top: 10px;
		margin-bottom: 10;
		}

	</style>
</head>
<body>

<form method="POST">

	Nick: </br> <input type="text" name="nick" /></br>
	 <?php
if (isset($_SESSION['e_nick']))
{
		echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
		unset($_SESSION['e_nick']);
}
	 ?>
	E-mail: </br> <input type="text " name="email" /></br>
	<?php
if (isset($_SESSION['e_email']))
{
	 echo '<div class="error">'.$_SESSION['e_email'].'</div>';
	 unset($_SESSION['e_email']);
}
	?>
	Hasło: </br> <input type="password" name="haslo1" /></br>
	Powtórz Hasło: </br> <input type="password" name="haslo2" /></br>

<label>
	<input type="checkbox" name="regulamin" />Akceptuje regulamin
</label>
<div class="g-recaptcha" data-sitekey="6LflyDkUAAAAACRdT8Q_xPoF2PjIhx6UmJfA9Gos"></div>
</br>
<input type="submit" value="Zarejestruj się!" />
</br>
<a href="index.php">Wróć do strony logowania</a>
</form>

</body>
</html>
