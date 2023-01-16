<?php


function Connection()
{
    $db_name=$_SESSION["db_name"];

    $connection = mysqli_connect($_SESSION["Serveur"], $_SESSION["Server_user"], $_SESSION["Server_pass"]);
    if (!$connection) {
        die('MySQL ERROR: ' . mysqli_connect_error());
    }
    if(!mysqli_select_db($connection, $db_name))
    {
        $sql = "CREATE DATABASE $db_name";
        if ($connection->query($sql) === TRUE) {
            echo "Fin de la Création de la Base de donnée";
            mysqli_select_db($connection,$db_name);
        } else {
            echo "Error creating database: " . $connection->error;
        }

    }
    return $connection;
}

function GetTabname($link)
{
    $db=$_SESSION["db_name"];



    $reqInsert = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_type='BASE TABLE' and table_schema='$db'";
    return mysqli_query($link, $reqInsert);
}


function GetColumnName($link,$table)
{
    $db=$_SESSION["db_name"];
    $reqInsert = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' and TABLE_SCHEMA='$db'";
    $result=mysqli_query($link, $reqInsert);


    if($result!==FALSE){                          // erreur dans la requete
        if($row = mysqli_fetch_array($result))         // regarde si la requete renvoi rien
        {
                $i=0;

            do {
                $ColumnName[$i] = $row[0];
                $i++;

            } while ($row = mysqli_fetch_array($result));

        }}


    return $ColumnName;

}
function FindSQL($link,$table)
{
    $max_row=$_SESSION['max_rows_html'];
    $reqInsert = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,$max_row";
    return mysqli_query($link, $reqInsert);

}