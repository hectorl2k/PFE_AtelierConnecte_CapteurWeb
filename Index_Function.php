<?php




function print_setup(){

    $max_rows_print=$_SESSION['max_rows_html'];
    $nom_equipement=$_SESSION['nom_equipement'];
    if (isset($_POST['select_start'])){$start= $_POST['select_start'];}else {$start= $_SESSION['Date_creation_bd'];}
    if (isset($_POST['select_stop'])){$stop= $_POST['select_stop'];}else{$stop= date("Y-m-d");}

    echo "<h3 style='text-align: center'>Paramétrage de l'impression</h3> <hr>
        
        <div id='Recap' class='t4'>
        
        <form method='post' class='' id='formulaire_print'>
            
        
                    <table width='100%' align='center' class='tableau_setup_print'>
                
                    <tbody>
                    <tr>
                        <td width='30%'>Nom de l'equipement : </td>
                        <td width='20%'><input type='text' class='Print_data-pop'  id='Nom_Equipement' name='Nom_Equipement' value='$nom_equipement'> </td>
                    </tr>
                    <tr colspan='2'>
                        <td >Selection de la période : </td>
                        <td width='20%'>  <input type='date' id='print_period_start' class='Print_data-pop' name='print_period_start' value='$stop'> </td>
                        <td width='3%' style='text-align: center'>  au </td>
                        <td>  <input type='date' id='print_period_stop' class='same_line t4-2_selection' name='print_period_stop' value='$stop'> </td>
                    </tr>
                    <tr>
                        <td>Mode :</td>
                        <td>
                            <select name='Print_mode' id='Print_mode' class='same_line pure-input-rounded'>
                                <option value='all'>Toutes les données</option>
                                <option value='error'>Uniquement les erreurs</option>
                                <option value='no-error' >Pas erreurs</option>
                
                            </select> </td>
                
                    </tr>
                    <tr>
                        <td>Nb max requete :</td>
                        <td><input type='number' style='width:60%'  id='Max_rows_print' class='pure-input-rounded' name='Max_rows' value='$max_rows_print' min='30' max='300'></td>
                    </tr>
                    <tr><td><br></td></tr><tr><td><br></td></tr>
                    <tr>
                        <td colspan='4' align='center'>
                            <button class='button Impression'  id='Submit_form_print' type='button'>Imprimer</button>
                            <button class='button'  id='Annuler_impression' type='button'>Annuler</button>
                        </td>
                    </tr>
                
                
                    </tbody>
                </table>
            
            
            
            
            
            
       </form>
        
        
        </div>
        ";
$_POST['Impression-valider']=1;
}

function afficher_erreur(){

    $filename = ".\Request\\".$_SESSION['fichier_txt_save'];

    $handle = fopen($filename, "r");
    if (filesize("./Request/".$_SESSION['fichier_txt_save']) > 0) {
        $data = fread($handle, filesize("./Request/".$_SESSION['fichier_txt_save']));       // Recupere donnée fichier txt
    } else {
        $data = "";
    }
    fclose($handle);
    $col_name_erreur_txt = $_SESSION['col_name_erreur_txt'];


    echo "<h3>Nouvelle(s) Erreurs :</h3> <br>";


    echo "<table id=\"Tableau_erreur\"class=\"w3-table-all w3-card-4\" style=\"table-layout: auto; width: 75%; position: static; overflow-y: scroll; max-height: 300px\"; >";
   

    for ($i = 0; $i < count($col_name_erreur_txt); $i++)                   // En-tete du tableau
    {
        echo "<th>" . $col_name_erreur_txt[$i] . "</th>";
    }


    if (strlen($data) > 5) {

        $erreurs = explode("\n", $data);                   // separe chaque erreurs
        $max_erreurs = $j = (count($erreurs));


        do {
            $j--;
            $row = $max_erreurs - $j;
            echo "<tr  accesskey='Row$row'>";

            $erreur = explode("&", $erreurs[$j]);

            for ($x = 0; $x < count($col_name_erreur_txt); $x++) {
                

                if ($x == (count($col_name_erreur_txt) - 1)) {
                    echo "<td>" . "<button  id='erreur_txt$id' class='button' onclick='acquitter_data(\"Row$row\");'>OK</button>" . " </td>";
                } else {
                    $val = explode("=", $erreur[$x]);
                    echo "<td > " . $val[1] . " </td>";
                }
                if ($x == 2) {
                    $id = $val[1];
                }
            }
            echo "</tr>";

        } while ($j > 0);
    }
    echo "</table>";




}
function creation_tableau($link,$result,$tab_selected,$mode){
    $nom_tableau=$_SESSION['nom_tableau_print_data'];
    $max_column = count(explode(",", $_POST['colonne_last_requette']));
    $col_name_bd=$_SESSION["col_name_bd"];
    $col_name_http=$_SESSION["col_name_http"];
    $col_error=-1;
    $col_path=-1;



    $type_col=$_SESSION["type_col"];
    $colonne_last_requette=explode(",",$_POST['colonne_last_requette']);
    $nbr_col=count($colonne_last_requette);


    for ($i=0;$i<$nbr_col;$i++)
    {
        $index=array_search($colonne_last_requette[$i],$col_name_bd[$tab_selected]);

        $nom_col[$i]=$col_name_http[$tab_selected][$index];

        if( $colonne_last_requette[$i] == "Code_Erreur")
        {$col_error=$i;}


        if( $colonne_last_requette[$i] == "Photo")
        {$col_path=2;}


    }

    $value = "<thead>
                <tr>
                    <th colspan='$max_column'>$nom_tableau</th>
                </tr><tr>    ";

    for($i=0;$i<$nbr_col;$i++)
    {
        $value.= "<th>".$nom_col[$i]."</th>";
    }
    $value.= "</tr></thead>";

    $data=array();
    $i=0;
    if($result!==FALSE){                          // pas erreur dans la requete

        if($row = mysqli_fetch_array($result))         // regarde si la requete renvoi rien
        {
            do {
                $value.= "<tr>";
                for($col=0;$col<$nbr_col;$col++)    // GL: "$nbr_col_tab_select" = Nb de colonnes à afficher
                {
                    if($col==$col_path)
                    {
                        $value.= path_btn($row[$col],$row[0]);

                    }elseif($col_error >= 0  && $row[$col_error] >0 && $_SESSION['num_col_start_data'][vision_data_mesure] <= $col){     // Verifie que col erreur existe

                        $value.= "<td><div>".bold($link,$col,$row[$col])."</div></td>";
                    }else{
                       // $value.= "<td><div>".bold($link,$col,$row[$col])."</div></td>";
                        $value.= "<td>". $row[$col] ."</td>";
                    }






                    if($type_col[$tab_selected][$col]==String)
                    {
                        $data[$col][$i] = $row[$col];
                    } else {$data[$col][$i] = floatval($row[$col]);}
                }


                $i = $i + 1;

            } while ($row = mysqli_fetch_array($result));



            $_SESSION['data'] = $data;
            $_SESSION['data_col_name']=$nom_col;


        }else{$value= "Aucune données trouvées";}
    }else{$value= "Format de la requete impossible";}



    if($mode=="print"){
        return $value;
    }else{echo $value;}

}
function bold($link,$col,$val)
{


    $col_name_bd=$_SESSION["col_name_bd"];
    $tab_data = vision_data_mesure;
    $tab_ref=vision_data_reference;

    $num_col_start_data=$j=$_SESSION['num_col_start_data'][$tab_data];
    $num_col_start_ref=$j=$_SESSION['num_col_start_data'][$tab_ref];



    $tab_name=$_SESSION["tab_name"];

    $res="$val";
    $col_min=($col+($num_col_start_ref-$num_col_start_data))+($col-$num_col_start_data); // Je fais en sorte incrementer l'ecart entre chaque colonne et de faire en sorte de suivre l'ecart entre les deux tables


    $ref_name_min=$col_name_bd[vision_data_reference][$col_min];
    $ref_name_max=$col_name_bd[vision_data_reference][$col_min+1];


    if($_SESSION['id_mesure_ref'] ==-1)
    {$request="SELECT id,$ref_name_min,$ref_name_max From ".$tab_name[vision_data_reference]." ORDER BY ID DESC LIMIT 0,1";
    }else{
        $request="SELECT id,$ref_name_min,$ref_name_max From ".$tab_name[vision_data_reference]." where id =".$_SESSION['id_mesure_ref'];
    }
    $result=mysqli_query($link,$request);
    $row = mysqli_fetch_array($result);


    if (($val < $row[1]) || ($val >$row[2])  ) {


        $res = "<p class='data-error'>$val</p>";              // On met la valeur en gras

    }




    return $res;
}
function calcul_maxColumn($print_ColData,$print_data_StartStop){

    $i=0;
    $nb_column=0;
    do{
        $col=$print_ColData[$i];
        if($col >= $print_data_StartStop[0] && $col <= $print_data_StartStop[1])
        {$nb_column=$nb_column+2;}
        else{$nb_column++;}
        $i++;
    }while($i<count($print_ColData)-1);
    return $nb_column;
}
function path_btn($data,$id)
{
    $current_dir=str_replace("/","\\",getcwd());
    $data=str_replace("/","\\",$data);
    $path=explode($current_dir,$data);        // change \ par / et on supprime avant RG09...

    $value= "<td> <button id=\"btn_path$id\" class=\"button PopUp\" >Path</button> </td>";

    $divbtn[0]= "<div id=\"PopUp_path$id\" class=\"modal\">";
    $divbtn[1]="<div id=\"popup$id\" class=\"modal-content\">";
    $divbtn[2]="<span id=\"btnClose$id\" class=\"close\"<>&times;</span>";
    $divbtn[3]="<h4>Path : </h4><p>$data</p>";

    if (array_key_exists (1,$path))
    {
        $divbtn[4]="<p>  <img src=\".$path[1]\" alt=\" Try to load the file\" style=\"width:70%;height:70%;\"></p></div></div>";}
    else
    {$divbtn[4]="<p>  <img src=\"./icone/error_load_picture.png\" alt=\" Try to load the file\" style=\"width:60%;height:60%;\"></p></div></div>";}

    $value.= $divbtn[0].$divbtn[1].$divbtn[2].$divbtn[3].$divbtn[4];
    return $value;

}
function impression()
{

    $link = connection();
    $col_name_http = $_SESSION["col_name_http"];
    $print_ColData = $_SESSION['print_ColData'];
    $print_data_StartStop = $_SESSION['print_data_StartStop'];
    $num_col_start_data = $j = $_SESSION['num_col_start_data'][vision_data_mesure];
    $num_col_start_ref = $j = $_SESSION['num_col_start_data'][vision_data_reference];
    $max_column = calcul_maxColumn($print_ColData, $print_data_StartStop);


    if (isset($_POST['Nom_Equipement'])) {
                $nom_equipement = $_POST['Nom_Equipement'];
    } else {    $nom_equipement = $_SESSION['nom_equipement'];    }
    $i = 0;


    $div_print = "<div id='Titre_print' class='titre'>
            <h3 class='tire' style='text-align: center'>Bilan $nom_equipement</h3>
        </div><hr>
        <div id='Affiche_tableau_reference' align='center'>
            <table class='w3-table-all w3-card-4' style='table-layout: auto; width: 95%; position: static; overflow-y: scroll; max-height: 300px; margin:3%'; >
            <tr class='en-tete tire-tab'><th style='padding: 1px' colspan=$max_column class='en-tete'>Reference de chaque Valeur</th></tr>
            <tr class='en-tete'>\n";

    do {
        $col = $print_ColData[$i];
        if ($col >= $print_data_StartStop[0] && $col <= $print_data_StartStop[1]) {
            $div_print.= "<th colspan=2 class='en-tete' style='padding: 1px'> " . $col_name_http[vision_data_mesure][$col] . "</th>\n";
        } else {
            $div_print.= "<th colspan=1 class='en-tete' style='padding: 1px'>" . $col_name_http[vision_data_mesure][$col] . "</th>\n";
        }
        $i++;
    } while ($i < count($print_ColData) - 1);
    $div_print.= "</tr><tr>";


    $i = 0;
    do {
        $col = $print_ColData[$i];
        if ($col >= $print_data_StartStop[0] && $col <= $print_data_StartStop[1]) {
            $col_min = ($col + ($num_col_start_ref - $num_col_start_data)) + ($col - $num_col_start_data); // Je fais en sorte incrementer l'ecart entre chaque colonne et de faire en sorte de suivre l'ecart entre les deux tables
            $div_print.= "<th class='en-tete' style='padding: 1px'>" . $col_name_http[vision_data_reference][$col_min] . "</th> \n";
            $div_print.= "<th class='en-tete' style='padding: 1px'>" . $col_name_http[vision_data_reference][$col_min + 1] . "</th> \n";
        } else {
            $div_print.= "<th class='en-tete' style='padding: 1px'>" . $col_name_http[vision_data_reference][$col] . "</th>";
        }
        $i++;
    } while ($i < count($print_ColData) - 1);

    $div_print.= "</tr><tr>\n";

    $result = FindSQL_ref($link);
    $row = mysqli_fetch_array($result);
    $i = 0;

    do {
        $col = $print_ColData[$i];
        if ($col >= $print_data_StartStop[0] && $col <= $print_data_StartStop[1]) {
            $col_min = ($col + ($num_col_start_ref - $num_col_start_data)) + ($col - $num_col_start_data); // Je fais en sorte incrementer l'ecart entre chaque colonne et de faire en sorte de suivre l'ecart entre les deux tables


            $div_print.= "<td>" . $row[$col_min] . "</td>";
            $div_print.= "<td>" . $row[$col_min + 1] . "</td>";

        } else {
            $div_print.= "<td>" . $row[$col] . "</td>";
        }

        $i++;
    } while ($i < count($print_ColData) - 1);

    $div_print.= "</tr></table></div><hr>

            <div id='Affiche_tableau_reference' align='center'>
            <table class='w3-table-all w3-card-4' style='table-layout: auto; width: 95%; position: static; overflow-y: scroll; max-height: 300px'>
      ";

    $result = FindSQL($link, vision_data_mesure, "print");
    $div_print.=creation_tableau($link, $result, vision_data_mesure,"print");
    $div_print.= " </table></div>";

    return $div_print;

}














?>







