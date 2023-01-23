$password_hash = password_hash($haslo, PASSWORD_DEFAULT);
<?php
include "connection.php";

$imie = trim($_POST["imie"]);
$nazwisko = trim($_POST["nazwisko"]);
$email = trim($_POST["email"]);
$haslo = trim($_POST["haslo"]);
$telefon = trim($_POST["telefon"]);
$wynagrodzenie = trim($_POST["wynagrodzenie"]);

$hash = password_hash($haslo, PASSWORD_DEFAULT);

if (strlen($imie) > 0 && strlen($nazwisko > 0)) {
    $query = "CALL pobierzIdPracownika(\"" . 
        $imie . '", "' . $nazwisko . '", "' .
        $email . '", "' .
        $hash . '", "' .
        $telefon . '", ' . $wynagrodzenie . ", @junk);";
    $result = mysqli_query($conn, $query);
}

header("Location: index.php");

?>