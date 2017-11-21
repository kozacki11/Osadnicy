<?php
session_start();

if (!isset($_POST['']))
{
	# code...
}

 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http=equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - załóż darmowe konto</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<form method="post">

	Nick: </br> <input type="text" name="nick" /></br>
	E-mail: </br> <input type="text " name="email" /></br>
	Hasło: </br> <input type="password" name="haslo1" /></br>
	Powtórz Hasło: </br> <input type="password" name="haslo2" /></br>

<label>
	<input type="checkbox" name="regulamin" />Akceptuje regulamin
</label>
<div class="g-recaptcha" data-sitekey="6LflyDkUAAAAACRdT8Q_xPoF2PjIhx6UmJfA9Gos"></div>
</br>
<input type="submit" value="Zarejestruj się!" />
</form>

</body>
</html>
