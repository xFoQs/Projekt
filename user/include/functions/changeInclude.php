<?php 

        session_start();    

        // $id = "";
        $scr = "";
        if (isset($_GET["scr"])) $scr = $_GET["scr"];

        // if (isset($_GET["id_ksiazka"])) $id_ksiazka = $_GET["id_ksiazka"];
        // $GLOBALS['id_ksiazka'] = $id_ksiazka;

        function main() {
            include('../user/include/nowe.php');
        }

        function wypozyczalnia() {
            include('../user/include/wypozyczalnia.php');
        }

        function wylogowanie() {
            include('../user/include/exit.php');
        }

        function profil() {
            include('../user/include/profil.php');
        }

        function shelf() {
            include('../user/include/shelf.php');
        }
        
        function czytajDalej() {
            $id_ksiazka;
            if (isset($_GET["id_ksiazka"])) $id_ksiazka = $_GET["id_ksiazka"];
            include('../user/include/czytajDalej.php');
        }

        function zamowiono() {
            include('../user/include/zamowiono.php');
        }

        function test() {
            header("Location: test.php");
        }


        switch ($scr)
        {
            case "main":
                main();
                break;
            case "wypozyczalnia":
                wypozyczalnia();
                break;
            case "wylogowanie":
                wylogowanie();
                break;
            case "profil":
                profil();
                break; 
            case "shelf";
                shelf();
                break;
            case "czytajDalej";
                czytajDalej();
                break;    
            case "zamowiono";
                zamowiono();
                break;    
            case "test";
                test();
                break;        
            default:
                main(); 
        }
    
    ?>