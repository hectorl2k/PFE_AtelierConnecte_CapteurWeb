<?php
include("./../BDD/config.php");
include("./../BDD/requete.php");

$connection = Connection();
$request_method = $_SERVER["REQUEST_METHOD"];
$date = "";

$Max_rows = 1;

if (isset($_GET['limit'])) {
    $Max_rows = $_GET['limit'];
}
if (isset($_GET['table_select'])) {
    $table = $_GET['table_select'];
} else {
    echo "Paramétre : table_select, limit, start,stop";
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


$query = "SELECT * FROM $table $date ORDER BY ID DESC LIMIT 0,$Max_rows";
var_dump($query);

$result = mysqli_query($connection, $query) or die("Error in Selecting " . mysqli_error($connection));

//create an array
$emparray = array();
while ($row = mysqli_fetch_assoc($result)) {
    $emparray[] = $row;
}
header('Content-Type: application/json');
echo json_encode($emparray, JSON_PRETTY_PRINT);

//close the db connection
mysqli_close($connection);
?>