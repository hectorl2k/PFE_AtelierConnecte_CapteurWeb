<?php
session_start();
include("config_serveur.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphique RG09</title>
    <link rel="stylesheet" type="text/css" href="./CSS/style_graph.css">
    <script src="chart.js"></script>
    <script src="script_graph.js"></script>




</head>

<body>


<?php





$col_name_http=$_SESSION["col_name_http"][0];
$nbr_col_http = count($col_name_http);


$data =  $_SESSION['data'] ;
$show_tab=$_SESSION['show_tab'];
$column_graph_show=$_SESSION["column_graph_show"];
$column_graph_color=$_SESSION["column_graph_color"];
$col_name= $_SESSION['data_col_name'];



?>

<h2>Variation des données :</h2>




<div id="Graphe_visu">
    <canvas id="myChart"></canvas>
</div>





<script>



    <?php 
     echo "
     var nbr_col=$nbr_col_http;
     var col_name=". json_encode(array_reverse($col_name_http)).';'; 
     //echo "var type_col=". json_encode(array_reverse($type_col)); 

     $nbr_col_display=0;
     $datasets="datasets : [ ";

        for($i=0; $i<count($column_graph_show);$i++)          // creer es variable
        {

                $nbr_col_display++;
               echo "var col".$nbr_col_display." = { label: '".$col_name[$column_graph_show[$i]]."', data: ".json_encode(array_reverse($data[$column_graph_show[$i]])).", backgroundColor: 'transparent', borderColor: '".$column_graph_color[$i]."', borderWidth: 3 };\n";

                $datasets = $datasets. "col".$nbr_col_display.", ";

        }


        echo  "var ShowGraph={labels:".json_encode(array_reverse($data[1])).",".substr($datasets,0,-1)."]};";

        echo "
        document.addEventListener('keydown', (touche)=>{if(touche.key=='Escape'){console.log('ferme');}
            window.close(); });
        "

    ?>



    affichegraph();



</script>




</body>
</html>


