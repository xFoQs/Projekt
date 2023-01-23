<?php
    include('connection.php');
?>

<form action="" method="POST" id="filter">

<div class="container mb-4" id="form-filter">
<section class="mb-2">
    <div class="select is-small is-rounded">
        <select name="w">
            <option value="d">Wybierz wydawnictwo</option>
            <?php
                        $query = "SELECT DISTINCT wydawnictwo FROM ksiazki ORDER BY wydawnictwo";
                        $result = mysqli_query($conn, $query); 
                        $row = mysqli_num_rows($result); 
                
                        while($row = mysqli_fetch_array($result)) {
                            echo "<option value='".$row['wydawnictwo']."'>".$row['wydawnictwo']."</option>";
                        }
            ?>
        </select>
    </div>
</section>  

<section class="mb-2">
    <div class="select is-small is-rounded">
        <select name="a">
            <option value="d">Wybierz autora</option>
            <?php
                        $query = "SELECT DISTINCT id_autor, imie, nazwisko FROM autorzy ORDER BY nazwisko";
                        $result = mysqli_query($conn, $query); 
                        $row = mysqli_num_rows($result); 
                
                        while($row = mysqli_fetch_array($result)) {
                            echo "<option value='".$row['id_autor']."'>".$row['nazwisko']." ".$row['imie']."</option>";
                        }
            ?>
        </select>
    </div>
</section> 

<section class="mb-2">
    <div class="select is-small is-rounded">
        <select name="t">
            <option value="d">Wybierz tytuł</option>
            <?php
                        $query = "SELECT DISTINCT tytul FROM ksiazki ORDER BY tytul";
                        $result = mysqli_query($conn, $query); 
                        $row = mysqli_num_rows($result); 
                
                        while($row = mysqli_fetch_array($result)) {
                            echo "<option value='".$row['tytul']."'>".$row['tytul']."</option>";
                        }
            ?>
        </select>
    </div>
</section>  

<input class="button mb-2 has-text-centered" style="width: 10%;" type="submit" name="submit" value="Filtruj"/>
<input class="button mb-3 has-text-centered" style="width: 10%;" type="reset" name="reset" value="Resetuj" onclick='window.location.reload(true);'/>
</div>
                    </form>

<div class="container" id="wyswietlanieDiv">
    <div class="columns is-multiline has-text-centered">
    <?php


// $query = "  SELECT imie, nazwisko, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis
// FROM ksiazki k, autorzy a, autor_ksiazka ak
// WHERE k.id_ksiazka = ak.id_ksiazka 
// AND a.id_autor = ak.id_autor";
                                //FILTER BUTTON

        // $id_autorow = "SELECT id_ksiazka FROM ksiazki;";
        // $result_id_autorow = mysqli_query($conn, $id_autorow);
        // $row_id_autorow = mysqli_num_rows($result_id_autorow);

        // $lista_id_autorow = array();

        // if(!empty($result_id_autorow)) {
        //     while($row_id_autorow = mysqli_fetch_array($result_id_autorow)) {
        //         array_push($lista_id_autorow, $row_id_autorow['id_ksiazka']);
        //     }
        // }
        // print_r($lista_id_autorow);

        // $p1 = "SELECT "

        // $p1 = "SELECT k.id_ksiazka, imie, nazwisko, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis
        // FROM ksiazki k, autorzy a, autor_ksiazka ak
        // WHERE k.id_ksiazka = ak.id_ksiazka 
        // AND a.id_autor = ak.id_autor 
        //  ";
        $p1 = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki WHERE";
        // $zapytanieAutorzy = "SELECT imie, nazwisko FROM autorzy as a 
        // INNER JOIN autor_ksiazka as ak ON ak.id_autor = a.id_autor
        // WHERE ";

        if (isset($_POST['a']) && $_POST['a'] != "d" && $_POST['w'] == 'd' && $_POST['t'] == 'd') {
            $a = $_POST['a'];   
            $query = "SELECT k.id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki as k
            INNER JOIN autor_ksiazka as ak ON ak.id_ksiazka = k.id_ksiazka
            INNER JOIN autorzy as a ON a.id_autor = ak.id_autor
            WHERE a.id_autor = '$a' ";
        } elseif(isset($_POST['w']) && $_POST['w'] != "d" && $_POST['a'] == "d" && $_POST['t'] == 'd') {
            $w = $_POST['w']; 
            $query = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki WHERE wydawnictwo ='$w';";
        } elseif(isset($_POST['t']) && $_POST['t'] != "d" && $_POST['a'] == "d" && $_POST['w'] == 'd') {
            $t = $_POST['t'];
            $query = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki  WHERE tytul = '$t';";
        }
            elseif(isset($_POST['a']) && isset($_POST['w']) && $_POST['a'] != "d" && $_POST['w'] != "d" && $_POST['t'] == 'd') {
                $a = $_POST['a'];
                $w = $_POST['w'];
                $query = "SELECT k.id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki as k
                INNER JOIN autor_ksiazka as ak ON ak.id_ksiazka = k.id_ksiazka
                INNER JOIN autorzy as a ON a.id_autor = ak.id_autor
                WHERE a.id_autor = '$a'
                AND k.wydawnictwo = '$w';";
            }elseif(isset($_POST['a']) && isset($_POST['t']) && $_POST['a'] != "d" && $_POST['t'] != "d" && $_POST['w'] == 'd') {
                $a = $_POST['a'];
                $t = $_POST['t'];
                $query = "SELECT k.id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki as k
                INNER JOIN autor_ksiazka as ak ON ak.id_ksiazka = k.id_ksiazka
                INNER JOIN autorzy as a ON a.id_autor = ak.id_autor
                WHERE a.id_autor = '$a'
                AND k.tytul = '$t';";
            } elseif(isset($_POST['w']) && isset($_POST['t']) && $_POST['w'] != "d" && $_POST['t'] != "d" && $_POST['a'] == 'd') {
                $w = $_POST['w'];
                $t = $_POST['t'];
                $query = "SELECT k.id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki as k
                INNER JOIN autor_ksiazka as ak ON ak.id_ksiazka = k.id_ksiazka
                INNER JOIN autorzy as a ON a.id_autor = ak.id_autor
                WHERE k.wydawnictwo = '$w'
                AND k.tytul = '$t';";
            } elseif(isset($_POST['w']) && isset($_POST['t']) && isset($_POST['a']) && $_POST['w'] != "d" && $_POST['t'] != "d" && $_POST['a'] != 'd') {
                $a = $_POST['a'];
                $w = $_POST['w'];
                $t = $_POST['t'];
                $query = "SELECT k.id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki as k
                INNER JOIN autor_ksiazka as ak ON ak.id_ksiazka = k.id_ksiazka
                INNER JOIN autorzy as a ON a.id_autor = ak.id_autor
                WHERE k.wydawnictwo = '$w'
                AND k.tytul = '$t'
                AND a.id_autor = '$a';";
            }
        else {
            $query = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki ORDER BY tytul;"; 
        }


                        // $query = "SELECT id_ksiazka, tytul, rok_wydania, wydawnictwo, ilosc, okladka, opis FROM ksiazki ORDER BY tytul";
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
                                                    <img loading='lazy' src='" .$row['okladka']."' alt='okładka'>
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
                        }else {
                            echo "<div class='column is-3-tablet is-3-desktop is-mobile is-vcentered' >Brak pozycji o podanych danych</div>";
                        }
    ?>
    </div>
</div>

<!-- <div class='popup-opis has-text-white'>".$row['opis']."</div> --> 

<!-- <div class="column is-4-tablet is-3-desktop">
        <div class="card">
            <div class="card-image has-text-centered px-6">
                <img src="" alt="">
            </div>
            <div class="card-content">
                <p>4123</p>
                <p class="title is-size-5">XDsdasd</p>
            </div>
            <footer class="card-footer">
                <p class="card-footer-item">
                    <a href="" class="has-text-grey">View</a>
                </p>
            </footer>
        </div>
    </div>  -->