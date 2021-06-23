<?php

session_start();
ini_set("memory_limit", "-1");
include("config_serveur.php");
include("connect.php");
include("RequeteVers_BDD.php");
include("Algorithme_RG09.php");
include("Index_Function.php");


$show_tab = $_SESSION['show_tab'] = "vision_data_mesure";
$tab_selected = vision_data_mesure;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=yes'>
  <title>RG09  : Projet 4.0</title>
  <link rel="icon" type="image/png" href="./icone/IconeSanofi.png" />
  <link rel="stylesheet" type="text/css" href='CSS/bootstrap.min.css'>
  <link rel="stylesheet" type="text/css" href="CSS/tableau.css">
  <link rel="stylesheet" type="text/css" href="CSS/style.css" media="screen">
  <link rel="stylesheet" type="text/css" href="CSS/impression.css" media="print">

  <script src="chart.js"></script>
  <script src="jquery.js"></script>
</head>



<body>

  <div id="All_page_print">
   
      <div id="Erreur_Impression" class="modal-contents">
        <h4> Passer par le bouton imprimante afin initialiser l'impression</h4>
      </div>
   
  </div>


  <div id="All_page_screen">



    <div id="Titre">
      <h1>Données de la RG09 :</h1>
      <hr>
    </div>


    <div id="Choix_donnees">
      <div id="Rechercher_text">Rechercher :</div>
      <div id='Bouton_Open_PopUp_Print'></div>

      <form action="" method="post" class="Recherche_BaseSQL">


        <div id="date_select">
          <input class="pure-input-rounded" type="text" name="find" id="rechercher" value="<?php if (isset($_POST['find'])) {
                                                                                              echo $_POST['find'];
                                                                                            } ?>">
          <input class="select_date" type="date" id="select_start" name="select_start" min="2021-01-01" value="<?php if (isset($_POST['select_start'])) {
                                                                                                                  echo $_POST['select_start'];
                                                                                                                } else {
                                                                                                                  echo $_SESSION['Date_creation_bd'];
                                                                                                                } ?>">
          <input class="select_date" type="date" id="select_stop" name="select_stop" value="<?php if (isset($_POST['select_stop'])) {
                                                                                              echo $_POST['select_stop'];
                                                                                            } else {
                                                                                              echo date("Y-m-d");
                                                                                            } ?>">
        </div>
        <div id="Switch_data">Types de données :
          <input type="radio" id="data_forcer" name="Screen_mode" value="error" <?php if (isset($_POST['Screen_mode']) && $_POST['Screen_mode'] == "error") {
                                                                                  echo "checked";
                                                                                }; ?> />
          <label for="data_forcer">Only Error</label>
          <input type="radio" id="data_all" name="Screen_mode" value="all" <?php if (isset($_POST['Screen_mode']) && $_POST['Screen_mode'] == "all" || !isset($_POST['Screen_mode'])) {
                                                                              echo "checked";
                                                                            } ?> />
          <label for="data_all">Toutes</label>
          <input type="radio" id="data_non_forcer" name="Screen_mode" value="no-error" <?php if (isset($_POST['Screen_mode']) && $_POST['Screen_mode'] == "no-error") {
                                                                                          echo "checked";
                                                                                        } ?> />
          <label for="data_non_forcer"><b>Sans Erreur</b></label>
        </div>


        <input class="button" id="Submit_form_rechercher" type="submit" value="Valider">
      </form>
      <button class="button" id="Open_popup" onclick="graph();">Afficher Graph</button>
      <button id="btn_Acquitement" class="button PopUp">Acquitement</button>
    </div>


    <div id="Affiche_tableau" >
      <table class="w3-table-all w3-card-4" style="table-layout: auto; width: 95%; position: static; overflow-y: scroll; max-height: 300px" ;>

        <?php

        $link = Connection();

        $result = FindSQL($link, vision_data_mesure, "screen");
        creation_tableau($link, $result, $tab_selected, $_SESSION['nom_tableau_print_data']);

        mysqli_free_result($result);
        mysqli_close($link);
        ?>
      </table>




    </div>

    <div id="PopUp_Acquitement" class="modal">


      <div class="modal-content">
        <span id="cls_Acquitement1" class="close">&times;</span>
        <div id="div_Text_erreur">
          <p> <?php afficher_erreur(); ?> </p>
        </div>
      </div>
    </div>

    <div id="PopUp_Print-Setup" class="modal">

      <div class="modal-content">
        <span id="cls_Print-Setup" class="close">&times;</span>
        <div id="Show-Print-Setup">
          <p> <?php print_setup(); ?> </p>
        </div>
      </div>



    </div>






  </div>




  <script src="script.js"> </script>
  <script src="script_graph.js"> </script>


</body>


</html>