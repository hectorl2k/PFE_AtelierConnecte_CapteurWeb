<?php
define("Entier",0);
define("Float",1);
define("String",2);


$_SESSION['fichier_txt_save']="Erreur_non_acquittement.txt";
$_SESSION['col_name_erreur_txt']=array("DateHeure","Nom Table","id","nb error","Acquitter");

$server="localhost";            // login mdp
$user="root";
$pass="";
$db="rg09";



$_SESSION['id_mesure_ref'] =-1;             // Reference de id a comparer
$_SESSION['x_min']=1;                       // intervalle de temps entre 2 sauvegardes

$_SESSION['Date_creation_bd']="2021-01-01";




$nbr_tab=2;
$tab_name[0]="vision_data_mesure";
$tab_name[1]="vision_data_reference";


define("$tab_name[0]",0);       // definie comme des variables
define("$tab_name[1]",1);




$_SESSION['max_rows_html']=100;
$col_name_bd[vision_data_mesure]=array("id","DateHeure","Photo","Valeur1","Valeur2","Valeur3","Valeur4","Valeur5","Valeur6","Valeur7","Valeur8","Valeur9","Valeur10","Code_Erreur");
$col_name_http[vision_data_mesure]=array("N","DateHeure","Photo","Notice?","Ergot","Ventouse","Vent: dist.","Mesure5","Mesure6","Mesure7","Mesure8","Mesure9","Mesure10","Code_Erreur");

$type_col[vision_data_mesure]=array(Entier,String,String,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,String);
$num_col_start_data[vision_data_mesure]=3;
$col_path[vision_data_mesure]=2;

$col_name_bd[vision_data_reference]=array("id","Dateheure","Path","Ref_Min_Val1","Ref_Max_Val1","Ref_Min_Val2","Ref_Max_Val2","Ref_Min_Val3","Ref_Max_Val3","Ref_Min_Val4","Ref_Max_Val4","Ref_Min_Val5","Ref_Max_Val5","Ref_Min_Val6","Ref_Max_Val6","Ref_Min_Val7","Ref_Max_Val7","Ref_Min_Val8","Ref_Max_Val8","Ref_Min_Val9","Ref_Max_Val9","Ref_Min_Val10","Ref_Max_Val10","Code_Erreur");
$col_name_http[vision_data_reference]=array("","","Path","Min1","Max1","Min2","Max2","Min","Max","Min","Max","Min","Max","Min","Max","Min","Max","Min","Max","Min","Max","Min","Max","Code_Erreur");
$type_col[vision_data_reference]=array(Entier,String,String,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,Float,String);
$num_col_start_data[vision_data_reference]=3;
$col_path[vision_data_reference]=2;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            /// Graph///
$column_tab_show=array(0,1,2,3,4,5,6,13);    // GL Avec la colonne erreur: $column_tab_show=array(0,1,2,3,4,5,6,13);

$column_graph_show=array(3,4,5,6,7);
$column_graph_color= array("rgb(255,0,0)","rgb(255,128,0)","rgb(123,0,255)","rgb(255,123,255)","rgb(129,23,213)");








//// PARTIE IMPRESSION ////////
$_SESSION['nom_equipement']="RG09";
$_SESSION['print_ColData']=array(0,1,3,4,5,6,7,8,9,10,11,12,13);
$_SESSION['print_data_StartStop']=array(3,12);  // data commence col 3 et finis 6
$_SESSION['nom_tableau_print_data']="Donnée(s) Enregistré par la RG09";

$_SESSION['max_rows_print']=80;



$print_ColName_TabRef=array(0,3,4,5,6,7,8); // colonne a affiché
$print_DataStartStop_TabRef=array(3,8,2); // (min,max, nombre de col par data
$_SESSION['print_ColName_TabRef']=$print_ColName_TabRef;
$_SESSION['print_DataStartStop_TabRef']=$print_DataStartStop_TabRef;









/////////// MISE A JOUR DES VARIABLES  ///////////




$_SESSION["Serveur"]=$server;
$_SESSION["Server_user"]=$user;
$_SESSION["Server_pass"]=$pass;
$_SESSION["db"]=$db;


$_SESSION['num_col_start_data']=$num_col_start_data;
$_SESSION['nb_col_path']=$col_path;
$_SESSION["nbr_tab"]=$nbr_tab;
$_SESSION["tab_name"]=$tab_name;

$_SESSION["col_name_bd"]=$col_name_bd;
$_SESSION["col_name_http"]=$col_name_http;

$_SESSION["type_col"]=$type_col;

$_SESSION['column_tab_show']=$column_tab_show;
$_SESSION["column_graph_show"]=$column_graph_show;
$_SESSION["column_graph_color"]=$column_graph_color;

