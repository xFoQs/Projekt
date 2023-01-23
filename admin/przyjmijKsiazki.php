<?php
include "connection.php";

session_start();
echo(json_encode($_POST)) . "<br>";

$loan_id = $_POST["idWypozyczenie"];
$changeBookAmt = "UPDATE ksiazki SET ilosc = ilosc + 1 WHERE id_ksiazka = ";

// check if books have been returned
$query = "SELECT * FROM wypozyczenia WHERE id_wypozyczenie = {$loan_id}";

echo $query . "<br>";

$result = mysqli_query($conn, $query)->fetch_assoc();

if ($result["oddano"] == 0) {
    echo (json_encode($result));
    $return_date = date("Y-m-d H:i:s");
    
    $updateLoan = "UPDATE wypozyczenia SET data_oddania = '{$return_date}', oddano = 1 WHERE id_wypozyczenie = {$loan_id}";
    mysqli_query($conn, $updateLoan);

    $query = "SELECT kw.id_ksiazka FROM ksiazka_wypozyczenie AS kw
    INNER JOIN ksiazki AS k ON kw.id_ksiazka = k.id_ksiazka
    WHERE kw.id_wypozyczenie = {$loan_id}";

    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            mysqli_query($conn, $changeBookAmt . $row["id_ksiazka"]);
        }
    }


}
header("Location: index.php");

?>