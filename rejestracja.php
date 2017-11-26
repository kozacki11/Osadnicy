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


	if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
	{
		$wszystko_ok = false;
		$_SESSION['e_haslo'] = "Hasło musi składać się od 8 do 20 znaków";
	}

	if ($haslo1!=$haslo2)
	{
		$wszystko_ok = false;
		$_SESSION['e_haslo'] = "Hasła nie są zgodnę!";
	}
	//Hashowanie hasła
	$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

	//echo $haslo_hash; exit();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try
	{
		$connecting = new mysqli($host, $db_user, $db_password, $db_name);
		if($connecting->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());

		}
		else
		{
				//Czy email już istnieje
				$result = $connecting->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				if (!$result) throw new Exception($connecting->error);

				$ile_takich_maili = $result->num_rows;
				if ($ile_takich_maili>0)
				{
				$wszystko_ok = false;
				$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email";
				}

				//Czy login już zajęty
				$result = $connecting->query("SELECT id FROM uzytkownicy WHERE  user='$nick'");
				if (!$result) throw new Exception($connecting->error);

				$ile_takich_nick = $result->num_rows;
				if ($ile_takich_nick>0)
				{
				$wszystko_ok = false;
				$_SESSION['e_nick'] = "Istnieje już konto z takim nickiem";
				}

				if ($wszystko_ok==true)
				{
						//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy.
						if ($connecting->query("INSERT INTO  uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)"))
						{
							$_SESSION['udanarejestracja'] = true;
							header('Location: witamy.php');
						}
						else
						{
						throw new Exception($connecting->error);
						}

				}

				$connecting->close();
		}
	}
	catch (Exception $e)
    {
        if ($wszystko_ok==true)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodoności i prosimy o rejestracje w innym terminie</span>';
            echo "</br> Informacje developerskie: ".$e;
        }
    }

	//Sprawdzanie zaznaczonego regulaminu
	if (!isset($_POST['regulamin']))
	{
		$wszystko_ok = false;
		$_SESSION['e_regulamin'] = "Zaakceptuj regulamin";
	}


	//Bot or not :)
	/*$secret_key = "6LfcGToUAAAAAMKYqsXakRFHdY5HeuMfEEtq7_wi";
	$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	$odpowiedz = json_decode($sprawdz);


	//Bot or not :)
	/*$secret_key = "6LfcGToUAAAAAMKYqsXakRFHdY5HeuMfEEtq7_wi";
	$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	$odpowiedz = json_decode($sprawdz);


	if ($odpowiedz->success==false)
	{
		$wszystko_ok = false;
		$_SESSION['e_bot'] = "Potwierdź że nie jesteś botem";
	}
*/
}

 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http=equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - załóż darmowe konto</title>

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
	<?php
		if (isset($_SESSION['e_haslo']))
		{
	 		echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
	 		unset($_SESSION['e_haslo']);
		}
	?>

	Powtórz Hasło: </br> <input type="password" name="haslo2" /></br>

<label>
	<input type="checkbox" name="regulamin" />Akceptuje regulamin
	<?php
		if (isset($_SESSION['e_regulamin']))
		{
	 		echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
	 		unset($_SESSION['e_regulamin']);
		}
	?>
</label>
</br></br>
<input type="submit" value="Zarejestruj się!" />
</br>
<a href="index.php">Wróć do strony logowania</a>
</form>

</body>
</html>
