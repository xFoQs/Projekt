<?php
include "connection.php";

$file_path = "/src/static/covers/" . basename($_FILES['okladka']['name']);
$full_file_path = $_SERVER["DOCUMENT_ROOT"] . $file_path;

if (move_uploaded_file($_FILES['okladka']['tmp_name'], $full_file_path)) {

    echo $full_file_path . "<br>";
    echo $file_path . "<br>";

    $insertBook = "CALL pobierzIdKsiazki(" .
        '"' . $_POST["tytul"] . '",' .
        '' . $_POST["rok_wydania"] . ',' .
        '"' . $_POST["wydawnictwo"] . '",' .
        '' . $_POST["ilosc"] . ',' .
        '"' . $file_path . '",' .
        '"' . $_POST["opis"] . '", @id);';

    
    $author_num = 1;


    mysqli_query($conn, $insertBook);
    $insertBook = "SELECT @id;";
    $result = mysqli_query($conn, $insertBook);
    $book_id = $result->fetch_assoc()["@id"];

    // check if book already exists
    $query = "SELECT id_autor_ksiazka FROM `autor_ksiazka` WHERE id_ksiazka = " . $book_id;
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        header("Location: index.php");
    }

    foreach ($_POST as $key => $value) {
        if (str_starts_with($key, "imie")) {
            $author_id = "CALL pobierzIdAutora(" .
                '"' . $_POST["imie" . $author_num] . '", "' .
                $_POST["nazwisko" . $author_num] . '", @id);';
            $author_num++;

            mysqli_query($conn, $author_id);
            $author_id = 'SELECT @id;';
            $result = mysqli_query($conn, $author_id);
            $author_id = $result->fetch_assoc()["@id"];

            $insertAuthor = "INSERT INTO `autor_ksiazka` (id_ksiazka, id_autor) VALUES (" .
                $book_id . ", " . $author_id . ");";

            echo $insertAuthor;
            mysqli_query($conn, $insertAuthor);
        }
    }

    header("Location: index.php");
}
