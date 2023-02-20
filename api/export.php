<?php
include("./../BDD/config.php");
include("./../BDD/requete.php");

$connection = Connection();
$request_method = $_SERVER["REQUEST_METHOD"];
$date = "";
$Max_rows = 1;


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


if (isset($_GET['table_select'])) {
    $table = $_GET['table_select'];
} else {
    echo "Paramètre(s) : table_select --> Selectionner la table , limit --> Nombre(s) de requêtes, start --> Date de début, stop --> Date de fin";
    $erreur=1;
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
mysqli_close($connection);
?>