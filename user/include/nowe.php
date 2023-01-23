<?php
include('connection.php');

?>

        <section class="section">
          <div class="container">
          <h1 class='title has-centered-text' style='margin-bottom: 5rem;'>Nowe książki</h1>
            <div class="columns is-multiline has-text-centered">
            <?php

                $query = "SELECT id_ksiazka, tytul, okladka, ilosc, rok_wydania FROM ksiazki WHERE id_ksiazka > ( (select COUNT(*) from ksiazki) - 12)";
                                            $result = mysqli_query($conn, $query); 
                                            $row = mysqli_num_rows($result); 
                    
                                            $space = " ";
                                            $com = ", ";
                    
                                            if(!empty($result)) {
                                                while($row = mysqli_fetch_array($result)) {
                                                        $zapytanieAutorzy = "SELECT imie, nazwisko FROM autorzy as a 
                                                        INNER JOIN autor_ksiazka as ak ON ak.id_autor = a.id_autor
                                                        WHERE ak.id_ksiazka = ".$row['id_ksiazka'].";";
                                                        $res_autorzy = mysqli_query($conn, $zapytanieAutorzy);
                                                        $row_autorzy = mysqli_num_rows($res_autorzy);
                                                        $autorzy = "";
                                                        while($row_autorzy = mysqli_fetch_array($res_autorzy)) {
                                                            $autorzy = $autorzy.$row_autorzy['imie'].$space.$row_autorzy['nazwisko'].$com;
                                                        }
                    
                                                        // list($imie, $nazwisko, $tytul, $rok_wydania, $wydawnictwo, $ilosc, $okladka, $opis) = mysqli_fetch_array($result); 
                                                        echo "<div class='column is-3-tablet is-3-desktop is-mobile is-vcentered' >
                                                                <div class='card'  onClick='dodaj(this.id, this.title)' id=".$row['id_ksiazka']." title='".$row['tytul']."'>
                                                                    <div class='card-image has-text-centered px-6'>
                                                                        <img loading='lazy' src='".$row['okladka']."' alt='okładka'>
                                                                    </div>
                                                                    <div class='card-content'>
                                                                        <p class='title is-size-5'>".$row['tytul']."</p>
                                                                        <a href='index.php?scr=czytajDalej&id_ksiazka=".$row['id_ksiazka']."' onClick='event.stopPropagation()'>czytaj dalej...</a>
                                                                        </div>
                                                                    <footer class='card-footer'>
                                                                        <p class='card-footer-item'>
                                                                            ".$autorzy."
                                                                        </p>
                                                                        
                                                                    </footer>
                                                                </div>
                                                            </div>";
                                                }
                                            }

            ?>
            </div>
          </div>
        </section>



                        