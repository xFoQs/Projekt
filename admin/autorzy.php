<?php
include "connection.php";

$imie_autora = trim($_POST["imie"]);
$nazwisko = trim($_POST["nazwisko"]);

if (strlen($imie_autora) > 0 && strlen($nazwisko > 0)) {
    $query = "CALL pobierzIdAutora(\"" . $imie_autora . " " . $nazwisko . "\", @junk)";
    $result = mysqli_query($conn, $query);
}

header("Location: index.php");

?>