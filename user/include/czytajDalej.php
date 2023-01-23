<?php
    // $id_ksiazka = $GLOBALS['id_ksiazka'];
    include('connection.php');
?>

<div class='container'>
      
<?php
            
            $p1 = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis
            FROM ksiazki 
            WHERE id_ksiazka = '$id_ksiazka';";

            // if (isset($_GET["id"])) $id = $_GET["id"];

            $query = $p1;
                            // echo $id_ksiazka;

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // $path = "../static/covers/"
            $space = " ";
            $com = ", ";

            $zapytanieAutorzy = "SELECT imie, nazwisko FROM autorzy as a 
            INNER JOIN autor_ksiazka as ak ON ak.id_autor = a.id_autor
            WHERE ak.id_ksiazka = '$id_ksiazka';";
            $res_autorzy = mysqli_query($conn, $zapytanieAutorzy);
            $row_autorzy = mysqli_num_rows($res_autorzy);
            $autorzy = "";
            while($row_autorzy = mysqli_fetch_array($res_autorzy)) {
                $autorzy = $autorzy.$row_autorzy['imie'].$space.$row_autorzy['nazwisko'].$com;
            }
                        // list($imie, $nazwisko, $tytul, $rok_wydania, $wydawnictwo, $ilosc, $okladka, $opis) = mysqli_fetch_array($result); 
                        echo "<div class='columns is-6' >
                                <div class='card column is-one-third' style='margin-top: 5rem; margin-bottom: 5rem; max-height: 70vh;'  onClick='dodaj(this.id, this.title)' id=".$row['id_ksiazka']." title='".$row['tytul']."'>
                                    <div class='card-image has-text-centered px-6'>
                                        <img loading='lazy' src='".$row['okladka']."' alt='okładka'>
                                    </div>
                                    <div class='card-content'>
                                        <p class='title is-size-5 has-text-centered'>".$row['tytul']."</p>
                                        </div>
                                    <footer class='card-footer'>
                                        <p class='card-footer-item'>
                                            ".$autorzy."
                                        </p>
                                    </footer>
                                </div>
                                <div class='column is-two-thirds' style='margin-left: 2rem; margin-right: 2rem; margin-top: 5rem; margin-bottom: 5rem'>".$row['opis']."</div>
                            </div>";
            
?>

</div>