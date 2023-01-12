<?php
    session_start();
    include("./BDD/requete.php");
	include("./BDD/config.php");



$link=Connection();
$result=GetTabname($link);



?>
<!DOCTYPE html>
<html lang="fr">
   <head>
       <meta charset='utf-8'>
       <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=yes'>
       <title>Graph</title>
       <link rel='stylesheet' type='text/css' href='style.css'>
       <script src="chart.js"></script>
   </head>



<body>
<script src="script.js"> </script>

  <div id="Titre">
      <h1>Base de Données :</h1>
  </div>
    <hr>

<form>
    <fieldset>
        <legend>Table à afficher :</legend>
        <div>

            <?php
            $i=0;

            if($result!==FALSE){                          // erreur dans la requete
                if($row = mysqli_fetch_array($result))         // regarde si la requete renvoi rien
                {
                    if(isset($_GET['db_view']))
                    {$db_view=$_GET['db_view'];}else{$db_view=$row[0];}

                    do {
                        if($db_view == $row[0]){$check="checked";}else{$check="";}

                        echo"<input type='radio' class='perso_button' id='contactChoice1' name='db_view' value='$row[0]' $check/> <label for='dbViewChoose$i'>$row[0]</label></button>";
                        $i++;
                    } while ($row = mysqli_fetch_array($result));
                    mysqli_free_result($result);

                }else{echo "Aucune données trouvées";}
            }else{echo "Format de la requete impossible";}
            ?>
        </div>
        <div>
            <button type="submit">Valider</button>
        </div>
    </fieldset>
</form>


<hr>






<div id="Affiche_tableau">
  <table class="w3-table-all w3-card-4" style="table-layout: auto; width: 75%; position: static; overflow-y: scroll; max-height: 300px">
      <?php

    if(isset($db_view)) {
        /// Tableau En-TETE
        $column = GetColumnName($link, $db_view);
        for ($i = 0; $i < count($column); $i++) {

            echo "<th>$column[$i]</th>";
        }


        $result = FindSQL($link, $db_view);


// Tableau Données

        if ($result !== FALSE) {                          // erreur dans la requete

            if ($row = mysqli_fetch_array($result))         // regarde si la requete renvoi rien
            {

                do {
                    echo "<tr>"; // nouvelle ligne
                    for ($i = 0; $i < count($column); $i++) {
                        echo "<td> $row[$i] </td>";
                    }
                    echo "</tr>";


                } while ($row = mysqli_fetch_array($result));


                mysqli_free_result($result);
                mysqli_close($link);
            }
// FIN TABLEAU  Données

        } else {
            echo "Format de la requete impossible";
        }


    }else{echo "Auncune Table dans la base de données";}
  ?>

  </table>


</div>


</body>
</html>




