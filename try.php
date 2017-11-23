
<?php
// Zobacz przykład password_hash(), aby wiedzieć skąd to pochodzi
$haslo = "rasmuslerdorf";
$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

//$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';


if (password_verify($haslo, $haslo_hash)) {
    echo 'Hasło jest poprawne!';
} else {
    echo 'Niepoprawne hasło.';
}
?>
