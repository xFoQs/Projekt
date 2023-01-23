<?php

session_start();


require_once "connect.php";


$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);


 if($polaczenie->connect_errno!=0)
 {
     echo "Error:".$polaczenie->connect_errno;
 }
 else
 {
    
    $user = $_POST['email'];
    $haslo = $_POST['password'];

    $user = htmlentities($user, ENT_QUOTES,"UTF-8");

    // $sql = "SELECT * FROM czytelnicy WHERE email = '$user' AND haslo = '$haslo'";
    if($rezultat = @$polaczenie->query(
    sprintf("SELECT * FROM czytelnicy WHERE email='%s'",
    mysqli_real_escape_string($polaczenie,$user))))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow > 0)
        {

            $wiersz = $rezultat->fetch_assoc();

            if(password_verify($haslo,$wiersz['haslo']))
            {

                    $_SESSION['zalogowany'] = true;
                    $_SESSION['id'] = $wiersz['id_czytelnik'];
                    $_SESSIOn['user'] = $wiersz['user'];
                    $user = $wiersz['user'];

                    unset($_SESSION['blad']);
                    $rezultat->close();
                    header('Location:../user/index.php');

            }
            else{
            
                header('Location:index.php');
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
    
            }

        }else{
            header('Location:index.php');
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';

        }
    }

    $polaczenie->close();
 }




?>