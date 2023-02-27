<?php
include("./../BDD/config.php");
include("./../BDD/requete.php");

$connection = Connection();
$request_method = $_SERVER["REQUEST_METHOD"];
$date = "";
$Max_rows = 1;
$mode=-1;                // 1- Export TableName  2- Export Data


$erreur=0;
$limit="LIMIT 0,$Max_rows";

if (isset($_GET['limit'])) {
    $Max_rows = $_GET['limit'];
    $limit="LIMIT 0,$Max_rows";
    if($Max_rows<=0)
    {
        $limit="";
    }
}






$code_date = 0;
if (isset($_GET['start'])) {
    $code_date += 1;
    $date_start = $_GET['start'];
}
if (isset($_GET['stop'])) {
    $code_date += 10;
    $date_stop = $_GET['stop'];
}
if ($code_date == 1) {
    $date = "where (timestamp >= \"$date_start\") ";
} elseif ($code_date == 10) {
    $date = "where (timestamp <= \"$date_stop\") ";
} elseif ($code_date == 11) {
    $date = "where (timestamp >= \"$date_start\" and  timestamp <=\"$date_stop\") ";
}



if (isset($_GET['all_boitiers'])) {
    $mode=1;
}


if (isset($_GET['table_select'])) {
    $table = $_GET['table_select'];
    $mode=2;
} else if($mode!=1){
    echo "Paramètre(s) : table_select --> Selectionner la table , limit --> Nombre(s) de requêtes, start --> Date de début, stop --> Date de fin";
    $erreur=1;
}


switch ($mode) {
    case 1 :
        ExportTableName();
        break;

    case 2 :
        ExportData();
        break;

    default: echo "Erreur de selection de mode";
}


function ExportData()
{
    global  $erreur,$table,$date,$limit,$connection;
    if($erreur==0)
    {
        $query = "SELECT * FROM $table $date ORDER BY ID DESC $limit";
        $result = mysqli_query($connection, $query) or die("Error in Selecting " . mysqli_error($connection));
        $emparray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $emparray[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($emparray, JSON_PRETTY_PRINT);
    }

}


function ExportTableName()
{
    global $connection;


    $result = GetTabname($connection);
    $emparray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $emparray[] = $row;
    }



    header('Content-Type: application/json');
    echo json_encode($emparray, JSON_PRETTY_PRINT);


}





mysqli_close($connection);
?>