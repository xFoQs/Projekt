<?php
    include('connection.php');
    // setcookie("height", "", time()-3600);
    $_COOKIE["height"];
    // echo $_COOKIE['height'];
    // $arr = explode(",", $_COOKIE["height"]);
    // print_r($arr);

    $orderArr = explode( ",", $_COOKIE["height"] );
    // print_r($orderArr);

    $_SESSION["id"];
    $id_czytelnika = $_SESSION['id'];
    // echo $id_czytelnika;


    if($orderArr[0] != null ) {
        // $_COOKIE["height"];
        $query1 = "INSERT INTO wypozyczenia(id_czytelnik) VALUES($id_czytelnika)";
        $result1 = mysqli_query($conn, $query1); 
    
        $sprawdz_wypozyczenia = mysqli_query($conn ,"SELECT id_wypozyczenie as total FROM wypozyczenia ORDER BY id_wypozyczenie DESC LIMIT 1;");
        if(mysqli_num_rows($sprawdz_wypozyczenia) > 0) {
            $w = mysqli_fetch_assoc($sprawdz_wypozyczenia);
            $id_nowego_wypozyczenia = $w['total'];
        }
    
    
        for ($i = 0; $i < count($orderArr); $i++) {
            $query2 = "INSERT INTO ksiazka_wypozyczenie(id_ksiazka, id_wypozyczenie) VALUES($orderArr[$i], $id_nowego_wypozyczenia)";
            // echo "</br>"."id_wypozyczenia: ".$id_nowego_wypozyczenia." id_ksiazka: ".$orderArr[$i]."</br>";
            // $id_nowego_wypozyczenia += 1;
            $result2 = mysqli_query($conn, $query2); 
        };
        echo "Wypożyczenie zostało zarejestrowane.";
        $orderArr = array();
    } else {
        // $_COOKIE["height"];
        echo "Wybierz książki!";
    }

    // $query1 = "INSERT INTO wypozyczenia(id_czytelnik) VALUES($id_czytelnika)";
    // $result1 = mysqli_query($conn, $query1); 

    // $sprawdz_wypozyczenia = mysqli_query($conn ,"SELECT id_wypozyczenie as total FROM wypozyczenia ORDER BY id_wypozyczenie DESC LIMIT 1;");
    // if(mysqli_num_rows($sprawdz_wypozyczenia) > 0) {
    //     $w = mysqli_fetch_assoc($sprawdz_wypozyczenia);
    //     $id_nowego_wypozyczenia = $w['total'];
    // }


    // for ($i = 0; $i < count($arr); $i++) {
    //     $query2 = "INSERT INTO ksiazka_wypozyczenie(id_ksiazka, id_wypozyczenie) VALUES($orderArr[$i], $id_nowego_wypozyczenia)";
    //     echo "</br>"."id_wypozyczenia: ".$id_nowego_wypozyczenia." id_ksiazka: ".$orderArr[$i]."</br>";
    //     // $id_nowego_wypozyczenia += 1;
    //     $result2 = mysqli_query($conn, $query2); 
    // };

?>