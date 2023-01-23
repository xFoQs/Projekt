<div class="container">
<?php
// sesję dodać do każdego pliku + sesja z logowania

    function twojeDane() {
        echo "<div class='tabs'>
        <ul>
          <li class='is-active'><a href='index.php?scr=profil&tab=twojedane'>Twoje dane</a></li>
          <li><a href='index.php?scr=profil&tab=historia'>Historia wypożyczeń</a></li>
        </ul>
      </div>";
        include('connection.php');

        $id_czytelnika = $_SESSION["id"];
        $czytelnik_info = mysqli_query($conn, "SELECT imie as i, nazwisko as n, email as e, telefon as t FROM czytelnicy 
                            WHERE id_czytelnik = $id_czytelnika;");
        $row_czytelnik = mysqli_num_rows($czytelnik_info);
        while($row = mysqli_fetch_array($czytelnik_info)) {
            $cz_i = $row['i'];
            $cz_n = $row['n'];
            $cz_e = $row['e'];
            $cz_t = $row['t'];
            echo "
            <div class='box'>
                <div class='content'>
                    <label class='label is-size-4'>
                        Imię
                    </label>
                    <h3 class='is-size-5 pb-5'>
                        ".$row['i']."
                    </h3>
    
                    <label class='label is-size-4'>
                        Nazwisko
                    </label>
                    <h3 class='is-size-5 pb-5'>
                        ".$row['n']."
                    </h3>
                    <label class='label is-size-4'>
                        E-mail
                    </label>
                    <h3 class='is-size-5 pb-5'>
                        ".$row['e']."
                    </h3>
                    <label class='label is-size-4'>
                        Telefon
                    </label>
                    <h3 class='is-size-5 pb-5'>
                        ".$row['t']."
                    </h3>
                </div>
            </div>";
        }
    }
    
    function historia() {
        include('connection.php');
        echo "<div class='tabs'>
        <ul>
          <li><a href='index.php?scr=profil&tab=twojedane'>Twoje dane</a></li>
          <li class='is-active'><a href='index.php?scr=profil&tab=historia'>Historia wypożyczeń</a></li>
        </ul>
      </div>";
        $id_czytelnika = $_SESSION["id"];

        "SELECT w.id_wypozyczenie FROM wypozyczenia as w
        INNER JOIN czytelnicy AS c ON w.id_czytelnik = c.id_czytelnik
        WHERE c.id_czytelnik = $id_czytelnika;";

        $lista_id_wypozyczen = mysqli_query($conn, 
                    "SELECT w.id_wypozyczenie FROM wypozyczenia as w
                    INNER JOIN czytelnicy AS c ON w.id_czytelnik = c.id_czytelnik
                    WHERE c.id_czytelnik = $id_czytelnika;");

        $arr_id_wypo = array();    
        $row_lista_id_wypozyczen = mysqli_num_rows($lista_id_wypozyczen);
            while($row_lista_id_wypozyczen = mysqli_fetch_array($lista_id_wypozyczen)) {
                array_push($arr_id_wypo, $row_lista_id_wypozyczen['id_wypozyczenie']);
            }
        $arr_id_wypo = array_reverse($arr_id_wypo);    
        


        // $niezrealizowane_info = mysqli_query($conn, "SELECT c.imie, c.nazwisko, w.id_wypozyczenie, k.tytul FROM czytelnicy AS c
        // INNER JOIN wypozyczenia AS w ON c.id_czytelnik = w.id_czytelnik
        // INNER JOIN ksiazka_wypozyczenie AS kw ON w.id_wypozyczenie = kw.id_wypozyczenie
        // INNER JOIN ksiazki AS k ON kw.id_ksiazka = k.id_ksiazka
        // WHERE
        //     w.data_wypozyczenia IS NULL AND 
        //     w.termin_oddania IS NULL AND
        //     c.id_czytelnik = $id_czytelnika AND
        //     w.id_wypozyczenie = $arr_id_wypo[$i];");
    
        

    // tutaj poprawić, bo zwalone całkiem -- sprawdzanie czy istnieje
    

        for($i = 0; $i < count($arr_id_wypo); $i++) {
            $niezrealizowane_info = mysqli_query($conn, "SELECT c.imie, c.nazwisko, w.id_wypozyczenie, k.tytul, k.okladka FROM czytelnicy AS c
                INNER JOIN wypozyczenia AS w ON c.id_czytelnik = w.id_czytelnik
                INNER JOIN ksiazka_wypozyczenie AS kw ON w.id_wypozyczenie = kw.id_wypozyczenie
                INNER JOIN ksiazki AS k ON kw.id_ksiazka = k.id_ksiazka
                WHERE
                    -- w.data_wypozyczenia IS NULL AND 
                    -- w.termin_oddania IS NULL AND
                    c.id_czytelnik = $id_czytelnika AND
                    w.id_wypozyczenie = $arr_id_wypo[$i]
                    ORDER BY w.id_wypozyczenie DESC;");
                        echo "<div class='box mb-6'> <h1 class='is-size-4 has-text-centered mb-3 is-underlined'>Id zamówienia: ".$arr_id_wypo[$i]. "</h1>";
                        $row_niezrealizowane = mysqli_num_rows($niezrealizowane_info); 
                            echo "<div class='box is-flex flex-direction-row is-flex-wrap-wrap'>"; 
                            while($row_niezrealizowane = mysqli_fetch_array($niezrealizowane_info)) { 
                                echo "
                                    <img class='m-2' style='width: 150px; height: 200px;' src='".$row_niezrealizowane['okladka']."'>
                                ";

                            }
                            echo "</div>";
                        echo "</div>";    
            }
    }

    if (isset($_GET['tab']) && $_GET['tab'] == "twojedane") {
        twojeDane();
    } else if(isset($_GET['tab']) && $_GET['tab'] == "historia") {
        historia();
    } else {
        twojeDane();
    }
    // $wynik_czytelnik = mysqli_query($conn, $query_czytelnik);
    // $f_a_czytelnik = mysqli_fetch_assoc($wynik_czytelnik);
    // echo $f_a_czytelnik['i'];
    // // $query = "SELECT * FROM czytelnicy WHERE id_czytelnik = $_SESSION['id']";
    // $result = mysqli_query($conn, $query); 
    // $row = mysqli_num_rows($result);     
    // echo $row;

    // $sprawdz_wypozyczenia = mysqli_query($conn ,"SELECT * FROM czytelnicy WHERE id_czytelnik = $_SESSION['id']");
    // $wynik_wypozyczen = mysqli_fetch_assoc($sprawdz_wypozyczenia);
    // $ilosc_wypozyczen = $wynik_wypozyczen['total'];
    
?>

</div>