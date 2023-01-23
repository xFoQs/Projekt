<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteka";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = $_GET["query"];
$export = $_GET["export"];
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $x = mysqli_fetch_fields($result);
  $pola = array();

  foreach ($x as $val) array_push($pola, $val->name);

  $data = array($pola);

  while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      array_push($data, $row);
  }


  if ($export === "yes") {

    $TMP_DIR="..\\tmp";
    if (!is_dir($TMP_DIR)) {
        mkdir("..\\tmp");
    }
    else {

      $sep = $_GET["sep"];
      $filename = $TMP_DIR . "\\" . $_GET["filename"] . ".csv";
      $line = "";
      $temp_file = fopen($filename, "w");

      if ($_GET["header"] === "no")
        $data = array_slice($data, 1);
        
        foreach($data as $row) {
          $line = "";

          foreach($row as $column) {
            $line = $line . $column . $sep;
          }
          $line =  substr($line, 0, -1) . "\n";
          fwrite($temp_file, $line);
        }

        $data = array("link" => $filename);
        echo json_encode($data);

        fclose($temp_file);
    }
  } else {

    echo json_encode($data);
    mysqli_free_result($result);
  }
} 
else
  echo json_encode(array());

mysqli_close($conn);