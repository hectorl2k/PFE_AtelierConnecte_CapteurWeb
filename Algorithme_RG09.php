

<?php



function AlgoRG09_mesure($link)
{


    $erreur=0;
    $col_name_bd=$_SESSION["col_name_bd"];
    $tab_data = vision_data_mesure;
    $tab_ref=vision_data_reference;

    $num_col_start_data=$j=$_SESSION['num_col_start_data'][$tab_data];
    $num_col_start_ref=$j=$_SESSION['num_col_start_data'][$tab_ref];


    $nbr_col_tab_data=count($col_name_bd[$tab_data]);
    $nbr_col_tab_ref=count($col_name_bd[$tab_ref]);
    $id_mesure_ref=$_SESSION['id_mesure_ref'];  // Si -1 alors on prends la derniere reference;





    $tab_ref_name= $_SESSION["tab_name"][$tab_ref];
    $tab_data_name=$_SESSION["tab_name"][$tab_data];

    if($id_mesure_ref == -1)
        {$requete = "SELECT * FROM $tab_ref_name ORDER BY ID DESC LIMIT 0,1";}
    else{$requete = "SELECT * FROM $tab_ref_name WHERE id=$id_mesure_ref ";}

    $result=mysqli_query($link,$requete);
    $row = mysqli_fetch_array($result);

    for($i=$num_col_start_ref;$i<$nbr_col_tab_ref;$i++)
    {$ref_mes[$i]=$row[$i];}


    $result=mysqli_query($link,"SELECT * FROM $tab_data_name ORDER BY ID DESC LIMIT 0,1");          // derniere données
    $row = mysqli_fetch_array($result);
    $id=$row[0];

    for($i=$num_col_start_data;$i<$nbr_col_tab_data;$i++)
    {$data_mesure[$i]=$row[$i];}


    for($i=0;$i<($nbr_col_tab_data-$num_col_start_data-1);$i++)// il y a un decalage de colonne entre le tableau de ref et le tableau des data
        {


            $col_data=$num_col_start_data+$i;
            $col_min=($col_data+($num_col_start_ref-$num_col_start_data))+($col_data-$num_col_start_data); // Je fais en sorte incrementer l'ecart entre chaque colonne et de faire en sorte de suivre l'ecart entre les deux tables
            $col_max=$col_min+1;


//echo "<br> I=$i coldata=$col_data col_min=$col_min col_max=$col_max data=$data_mesure[$col_data] --> min=".$ref_mes[$col_min]."  max=".$ref_mes[$col_max];
         if (($data_mesure[$col_data] < ($ref_mes[$col_min]) || $data_mesure[$col_data] >($ref_mes[$col_max]) ) && $data_mesure[$col_data] !='')

          {
              //echo" ERREUR";
              $erreur++;}

        }


    if($erreur>0)
    {
        $query = "UPDATE `$tab_data_name` SET `Code_Erreur` = '3' WHERE `$tab_data_name`.`id` = $id";
        mysqli_query($link,$query);
        maj_acquittement($id,$tab_data_name,$row[1],$erreur);

    }
mysqli_close($link);
}






function maj_acquittement($id,$tab_data_name,$time,$erreur)
{

    $handle=fopen ($_SESSION['fichier_txt_save'],"a+");
    if(filesize($_SESSION['fichier_txt_save'])>0){
        fwrite($handle,"\ntime=$time&tab=$tab_data_name&id=$id&erreur=$erreur");
    }else{
        fwrite($handle,"time=$time&tab=$tab_data_name&id=$id&erreur=$erreur");
    }

    fclose($handle);

}



?>

