<?php
    include "connection.php";

    session_start();

    $loan_id = $_POST["idWypozyczenie"];

    $query = "SELECT kw.id_ksiazka, k.ilosc FROM ksiazka_wypozyczenie AS kw
    INNER JOIN ksiazki AS k ON kw.id_ksiazka = k.id_ksiazka
    WHERE kw.id_wypozyczenie = {$loan_id}";

    $removeFromOrder = "DELETE FROM ksiazka_wypozyczenie
    WHERE id_wypozyczenie = {$loan_id} AND id_ksiazka = ";

    $changeBookAmt = "UPDATE ksiazki SET ilosc = ilosc - 1 WHERE id_ksiazka = ";

    $result = mysqli_query($conn, $query);
    $liczba_ksiazek = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           if ($row["ilosc"] <= 0) {
               $tmp = $removeFromOrder . $row["id_ksiazka"];
                mysqli_query($conn, $tmp);
           }
           else {
                $tmp = $changeBookAmt . $row["id_ksiazka"];
                mysqli_query($conn, $tmp);
                $liczba_ksiazek += 1;
           }
        }

        if ($liczba_ksiazek > 0) {
            $loan_date = date("Y-m-d H:i:s");
            $loan_return_date = date("Y-m-d H:i:s", strtotime( $loan_date . '+14 day'));
            
            $updateLoan = "UPDATE wypozyczenia SET " .
                "data_wypozyczenia = '{$loan_date}', " .
                "termin_oddania = '{$loan_return_date}', " .
                "id_pracownik = " . $_SESSION["id"] . 
                " WHERE id_wypozyczenie = {$loan_id}";
            mysqli_query($conn, $updateLoan);
        }
        
        header("Location: index.php");
    }

?>