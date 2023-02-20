<?php
include ("./../BDD/config.php");
include ("./../BDD/requete.php");

$conn = Connection();

$request_method = $_SERVER["REQUEST_METHOD"];
/*

switch($request_method)
{
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer un seul produit
            $id = intval($_GET["id"]);
            getData($id);
        }
        else
        {
            // Récupérer tous les produits
            getData();
        }
        break;
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>


<?php
function getData()
{
    $Max_rows=1;
    if(isset($_GET['limit']))
    {
        $Max_rows=$_GET['limit'];
    }
    if(isset($_GET['table_select']))
    {
    $table =$_GET['table_select'];
    }else    {echo "Paramétre : table_select, limit, start,stop";}
    global $conn;
    $date="";
    if (isset($_GET['start'])) {
        $date_start = $_GET['start'];
        $date_stop = $_GET['stop'];

        $date = "where (timestamp between \"$date_start\" and \"$date_stop\") ";
    }
    $query = "SELECT * FROM $table $date ORDER BY ID DESC LIMIT 0,$Max_rows";


    $response = array();
    $result = mysqli_query($conn, $query);
    $i=0;
    while($row = mysqli_fetch_array($result))
    {$i++;
    var_dump($row[1]);
        $response[] = $row;
    var_dump($response);
    }
    //var_dump($i);
    header('Content-Type: application/json');
    //var_dump($response);
    //echo json_encode($response[0], JSON_PRETTY_PRINT);
    //if
}
?>

*/

//open connection to mysql db
$connection =Connection() or die("Error " . mysqli_error($connection));

$Max_rows=1;
if(isset($_GET['limit']))
{
    $Max_rows=$_GET['limit'];
}
if(isset($_GET['table_select']))
{
    $table =$_GET['table_select'];
}else    {echo "Paramétre : table_select, limit, start,stop";}
global $conn;
$date="";
if (isset($_GET['start'])) {
    $date_start = $_GET['start'];
    $date_stop = $_GET['stop'];

    $date = "where (timestamp between \"$date_start\" and \"$date_stop\") ";
}
$query = "SELECT * FROM $table $date ORDER BY ID DESC LIMIT 0,$Max_rows";


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