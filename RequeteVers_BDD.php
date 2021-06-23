<?php

function FindSQL($link,$BD_tab,$mode){

    $tab_name=$_SESSION['tab_name'][$BD_tab];

    $date_start=$_SESSION['Date_creation_bd'];
    $date_stop=date("Y-m-d");
    $error_mode="Code_Erreur > -9999";
    $Max_rows=$_SESSION['max_rows_html'];

    $print_ColData=$_SESSION['print_ColData'];
    $column_tab_show=$_SESSION['column_tab_show'];
    $col_name_bd=$_SESSION['col_name_bd'][$BD_tab];





    if($mode=="screen") {

        if($column_tab_show != NULL){
            $i=0;
            do{
               $colonne[$i]= $col_name_bd[$column_tab_show[$i]];
                $i++ ;
            }while(count($column_tab_show)>$i);


            $colonne= implode(",",$colonne);

        }else{$colonne="*";}



        if (isset($_POST['find']) && $_POST['find'] != "")                  // on regarde si il y a une condition
        {
            $condition = condition($_POST['find'], $BD_tab)." and ";
        }else{$condition="";}


        if (isset($_POST['select_start'])) {
            $date_start = $_POST['select_start'];
            $date_stop = $_POST['select_stop'];
            $date="(DateHeure between \"$date_start 00:00:00\" and \"$date_stop 23:59:59\") and";
        }else{$date="(DateHeure between \"$date_start 00:00:00\" and \"$date_stop 23:59:59\") and";}


        if (isset($_POST['Screen_mode'])) {
            if ($_POST['Screen_mode'] == "no-error") {
                $error_mode = "Code_Erreur = 0";
            } elseif ($_POST['Screen_mode'] == "error") {
                $error_mode = "Code_Erreur > 0";}
            }






    } elseif ($mode == "print") {


        if($print_ColData != NULL){
            $i=0;
            do{
                $colonne[$i]= $col_name_bd[$print_ColData[$i]];
                $i++ ;
            }while(count($print_ColData)>$i);

            $colonne= implode(",",$colonne);

        }else{$colonne="*";}


        if (isset($_POST['find_print']) && $_POST['find_print'] != "")                  // on regarde si il y a une condition
        {
            $condition = condition($_POST['find_print'], $BD_tab)." and ";
        }else{$condition="";}




        if (isset($_POST['print_period_start'])) {
                $date_start = $_POST['print_period_start'];
                $date_stop = $_POST['print_period_stop'];
                $date="(DateHeure between \"$date_start 00:00:00\" and \"$date_stop 23:59:59\") and";
        }else{
            $date="(DateHeure between \"$date_start 00:00:00\" and \"$date_stop 23:59:59\") and";
        }



        if (isset($_POST['Print_mode'])) {
            if ($_POST['Print_mode'] == "no-error") {
                $error_mode = "Code_Erreur = 0";
            } elseif ($_POST['Print_mode'] == "error") {
                $error_mode = "Code_Erreur > 0";
            }



        }

        if (isset($_POST['Max_rows_print'])) {
            $Max_rows=$_POST['Max_rows_print'];}

    }
        $condi_final="SELECT $colonne FROM `$tab_name` where $condition $date $error_mode ORDER BY ID DESC LIMIT 0,$Max_rows";
   
    $_POST['colonne_last_requette']=$colonne;

        $result = mysqli_query($link, $condi_final);
    return $result;
}


function FindSQL_ref($link)
{


$tab_ref=vision_data_reference;
$tab_name_selected=$_SESSION['tab_name'][$tab_ref];

$id_selected =$_SESSION['id_mesure_ref'];

    if($id_selected>=0)
    {
    $condi_final="SELECT * FROM `$tab_name_selected` where id=$id_selected ";

    }else{
        $condi_final="SELECT * From ".$tab_name_selected." ORDER BY ID DESC LIMIT 0,1";
        }





     $result=mysqli_query($link,$condi_final);

return $result;
}

function condition($find,$index_show_tab)
{
    $col_name_bd=$_SESSION["col_name_bd"];
    $nbr_col_bd_data=count($col_name_bd[$index_show_tab]);
    $col_name_http=$_SESSION["col_name_http"];




    $find = str_replace(" ", "", $find);               // Supprime les espaces
    $find = strtolower($find);                                    // minuscule

    for ($j = 0; $j < $nbr_col_bd_data; $j++) {
        $find = str_replace(strtolower($col_name_http[$index_show_tab][$j]), strtolower($col_name_bd[$index_show_tab][$j]), $find);
    }
    $condi = explode(',', $find);                  // on sépare les condition par ','

   $condi="((".implode(') and (', $condi)."))";


return $condi;


}