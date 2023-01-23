<?php
    include "connection.php";

    // import data from csv file into specified table
    // script will set session variable to indicate
    // if any error occured
    
    if ($_FILES['import-fn']['error'] == UPLOAD_ERR_OK               //checks for errors
            && is_uploaded_file($_FILES['import-fn']['tmp_name'])) { //checks if file is uploaded

        $table = $_POST["table-name"];
        $sep = $_POST["import-sep"];

        $file = fopen($_FILES["import-fn"]["tmp_name"], "r");
        $query = "INSERT INTO " . $table . " VALUES ";

        if (isset($_POST["headers"])) {
            $junk = fgets($file);
        }

        while (!feof($file)) {

            $data = explode($sep, trim(fgets($file)));

            if (count($data) >= 2) {
                $line = "(";

                foreach ($data as $column) {
                    $clear_col = trim($column);
                    $line = $line . "'" . $clear_col . "',";
                }

                $line = substr($line, 0, -1) . "),";
                $query = $query . $line;
            }
        }

        $query = substr($query, 0, -1) . ";";

        // TODO set some session variable indicating if operation succeded

        mysqli_query($conn, $query);
        header("Location: index.php");
    }
?>
