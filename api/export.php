<?php
include ("./../BDD/config.php");
include ("./../BDD/requete.php");

$conn = Connection();

$request_method = $_SERVER["REQUEST_METHOD"];


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
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>