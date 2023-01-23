<?php

include "connection.php";


function fetchProcedures($conn)
{
    $query = "SELECT * FROM moje_procedury";
    $result = $conn->query($query);

    $procedures = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $proc_name = $row["routine_name"];

            if (!str_starts_with($proc_name, "filtr")) continue;


            if (!array_key_exists($proc_name, $procedures)) {
                $procedures[$proc_name] = array();
                $procedures[$proc_name]["parameters"] = array();
                $procedures[$proc_name]["comment"] = $row["comment"];
            }
        
            $param = array(
                "name" => $row["parameter_name"],
                "mode" => $row["parameter_mode"],
                "data_type" => $row["data_type"],
                "max_length" => $row["char_length"],
            );
            array_push($procedures[$proc_name]["parameters"], $param);
            
        }
    }
    return $procedures;
}

function fetchTables($conn)
{
    $queries = array(
        "tables" => "SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'",
        "views"  =>"SHOW FULL TABLES WHERE Table_Type LIKE 'VIEW'"
    );

    $fields_sql = "SHOW COLUMNS FROM ";

    $data = array();

    foreach ($queries as $key => $value) {

        $data[$key] = array();
        $result = $conn->query($value);

        if ($result->num_rows > 0) {
            $x = $result->fetch_fields();

            while($row = $result->fetch_array()) {
                $name = $row[0];

                if ($name == "moje_procedury") continue;
                
                $data[$key][$name] = [];
                $data[$key][$name]["fields"] = array();
                $result2 = $conn->query($fields_sql . '`' . $name . '`');

                if ($result2->num_rows > 0) {

                    while($row2 = $result2->fetch_assoc()) {
                        $field_info = array(
                            "fields" => array(
                                "name" => $row2["Field"]),
                            );
                        $type = $row2["Type"];

                        if (strpos($type, "(")) {
                            $temp = $type;
                            $type = substr($type, 0, strpos($type, "("));
                            $max_len = substr(substr($temp, strpos($temp, "(") + 1), 0, -1);
                            $field_info["fields"]["max_length"] = $max_len;
                        };

                        if ($row2["Field"] === "okladka")
                            $field_info["fields"]["data_type"] = "image";
                        else if ($row2["Field"] === "email")
                            $field_info["fields"]["data_type"] = "email";
                        else
                            $field_info["fields"]["data_type"] = $type;

                        if ($name === "autorzy") {
                            $data[$key][$name]["identifiedBy"] = array("imie", "nazwisko");
                        }

                        if ($name === "ksiazki") {
                            $data[$key][$name]["foreignKeys"] = array("autorzy");
                        }
                        else
                            $data[$key][$name]["foreignKeys"] = array();

                        array_push($data[$key][$name]["fields"], $field_info);
                    }
                }

            }
        }   
    }

    return $data;
}

$data = array();
$tables_and_views = fetchTables($conn);

foreach ($tables_and_views as $key => $value) {
    $data[$key] = $value;
}
$data["procedures"] = fetchProcedures($conn);

echo json_encode($data);

// close connection with database
$conn->close();
