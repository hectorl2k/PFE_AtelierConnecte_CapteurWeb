<?php

    include("./../config_serveur.php");
    include("./../connect.php");
    include("./../Algorithme_RG09.php");

   	$tab="vision_data_mesure";
    $tab_selected=vision_data_mesure;

    $tab_name=$_SESSION["tab_name"];
   	$col_name_bd=$_SESSION["col_name_bd"];
    $nbr_col_tab_select=count($col_name_bd[$tab_selected]);

   	$res=0; // Erreur dans l'envoi ou non
    $check_avant_envoi=0;



    $link=Connection();

for($i=0;$i<$nbr_col_tab_select;$i++){$data_in[$i]='NULL';} // intitialise tableau input







for( $i=2;$i<$nbr_col_tab_select;$i++)                 // enregistre data dan des une varibale
{
    $col_selected_temp=$col_name_bd[$tab_selected][$i];

    if(isset($_GET["$col_selected_temp"]))
            {

                if ($col_selected_temp == "Photo")
                {
                    $data_in[$i]=str_replace ("\\","/",$_GET["$col_selected_temp"]);
                $path=$data_in[$i];
                }else {
                    $data_in[$i] = $_GET["$col_selected_temp"];

                }
                $check_avant_envoi = 1;
            }
    else{if($col_selected_temp =="Code_Erreur")
             {           $data_in[$i]= 0;

             }else if($col_selected_temp =="DateHeure")
                {
                      $data_in[$i]="current_timestamp()";
                 }else {
                        $data_in[$i] = 'NULL';
                        }
        }


}
$data_in[1]="current_timestamp()";


$query_par1="INSERT INTO $tab (";
$query_par2=") VALUES (";

for($i=1;$i<$nbr_col_tab_select;$i++)
{
    $col_selected_temp=$col_name_bd[$tab_selected][$i];
    $query_par1=$query_par1."`$col_selected_temp`,";
    $query_par2=$query_par2.$data_in[$i].",";

}
$x_min=$_SESSION['x_min'];
$query=substr($query_par1,0,-1).substr($query_par2,0,-1).")";
$now=date('y-m-d G:i:s',mktime(date("H"),date("i")-$x_min,0,date("m"),date("d"),date("Y")));      //GL: ici on met l'intervalle de tps d'enregistrement ds la base (après: date("i")-    )
echo $now;
$Plus_xmn=0;
$requete=mysqli_query($link,"SELECT * from vision_data_mesure where DateHeure > '$now'");
$row = mysqli_fetch_array($requete);
if($row==NULL)          // Si 1 alors on enregistre
{$Plus_xmn=1;}else{
}

	if($check_avant_envoi!=0  && $Plus_xmn == 1)          // ENVOIE VER SERVEUR
	{

        $res=mysqli_query($link,$query);

        if($res ==1)
        {
            echo "<div id='DonneeSauvegarde'>Donnees bien enregistre</div>";
            AlgoRG09_mesure($link);
        }else
        {
            echo "<div id='DonneeSauvegarde'>Erreur lors de la Sauvegarde</div>";
        }



	}else if( $check_avant_envoi ==0){
        echo "<div id='DonneeSauvegarde'>Mauvais Format</div>";
    }else{

        echo "<div id='DonneeSauvegarde'>Delai trop court entre 2 sauvegardes</div>";
	}



	







