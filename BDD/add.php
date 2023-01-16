<?php

include("config.php");
include ("requete.php");


$link = Connection();     // Connection a la base de donnée


if ($link)              // Si On est bien connécté
{
    echo "Connectés";

    $id_boitier = $_GET["ID_Boitier"];

    if (isset($_GET["nbrCaptVibration"])) {
        $nbrCaptVibration = $_GET["nbrCaptVibration"];
    } else {
        $nbrCaptVibration = 0;
    }
    if (isset($_GET["nbrDistance_Dist"])) {
        $nbrDistance_Dist = $_GET["nbrDistance_Dist"];
    } else {
        $nbrDistance_Dist = 0;
    }
    if (isset($_GET["nbrDistance_Flux"])) {
        $nbrDistance_Flux = $_GET["nbrDistance_Flux"];
    } else {
        $nbrDistance_Flux = 0;
    }
    $nbrTotalCaptDistance=$nbrDistance_Dist+$nbrDistance_Flux;
    $reqData_colomn="";
    $reqData_data="";


    if (!boitier_connu($id_boitier))        // Si le boitier n'est pas reconnu alors on crée la table
    {
        if (!CreateTable())                  // création de la Table
        {
            echo "<br>Erreur Lors de la Création de la Table";
        }else{
            echo "<br>Boitier non reconnu, création de la Table effectué";
        }
    }
    GetData();                              // récupére les paramètre de la requete

        if (!SaveData())                  // création de la Table
        {
            echo "<br>Erreur Lors de la sauvegarde des données";
        }else{
            echo "<br> Sauvegarde des données Réussis";
        }



} else {
    echo "ERROR";
}

/*
function Connection()
{

    $connection = mysqli_connect($_SESSION["Serveur"], $_SESSION["Server_user"], $_SESSION["Server_pass"], $_SESSION["db_name"]);
    if (!$connection) {
        die('MySQL ERROR: ' . mysqli_connect_error());
    }
    mysqli_select_db($connection, $_SESSION["db_name"]) or die('MySQL ERROR: ' . mysqli_error());
    return $connection;
}
*/

function GetData()
{
    global $nbrCaptVibration, $nbrDistance_Dist, $nbrDistance_Flux,$reqData_colomn,$reqData_data;


    if ($nbrCaptVibration > 0) {
        for ($i = 0; $i < $nbrCaptVibration; $i++) {
            $reqData_colomn.="Capt_Vibration_$i , ";
            $reqData_data.=$_GET["Vibration$i"].", ";
        }
    }

    if ($nbrDistance_Dist > 0) {
        for ($i = 0; $i < $nbrDistance_Dist; $i++) {
            $reqData_colomn.="Capt_Distance_Dist_$i , ";
            $reqData_data.=$_GET["Distance_Dist$i"].", ";

        }
    }
    if ($nbrDistance_Flux > 0) {
        for ($i = 0; $i < $nbrDistance_Flux; $i++) {
            $reqData_colomn.="Capt_Distance_Flux_$i , ";
            $reqData_data.=$_GET["Distance_Flux$i"].", ";
        }
    }
    $reqData_colomn= substr($reqData_colomn,0,-2);
    $reqData_data= substr($reqData_data,0,-2);
}



function boitier_connu($id)
{
    global $link;
    if (mysqli_query($link, "SELECT * FROM $id ORDER BY id DESC LIMIT 0,1") != false) {
        return true;
    } else {
        return false;
    }

}

function CreateTable()
{
    $db_name=$_SESSION["db_name"];
    global $id_boitier, $nbrCaptVibration, $nbrDistance_Dist, $nbrDistance_Flux, $link;
    $DebutRequete = "CREATE TABLE `$db_name`.`$id_boitier` ( `id` INT(11) NULL AUTO_INCREMENT , `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ";
    $FinRequete = ", PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $ColonneVib = "";
    if ($nbrCaptVibration > 0) {

        for ($i = 0; $i < $nbrCaptVibration; $i++) {
            $ColonneVib .= ",`Capt_Vibration_$i` DOUBLE(10,2) NULL ";
        }

    }
    $ColonneDist = "";
    if ($nbrDistance_Dist > 0) {

        for ($i = 0; $i < $nbrDistance_Dist; $i++) {
            $ColonneDist .= ",`Capt_Distance_Dist_$i` DOUBLE(10,2) NULL ";
        }

    }

    $ColonneFlux = "";
    if ($nbrDistance_Flux > 0) {

        for ($i = 0; $i < $nbrDistance_Flux; $i++) {
            $ColonneFlux .= ",`Capt_Distance_Flux_$i` DOUBLE(10,2) NULL ";
        }
    }
    $resCreate = ($DebutRequete . $ColonneDist . $ColonneFlux . $ColonneVib . $FinRequete);

    return mysqli_query($link, $resCreate);


}

function SaveData()
{
    global $id_boitier,$link,$reqData_colomn,$reqData_data;

    $reqInsert = "INSERT INTO $id_boitier ($reqData_colomn) VALUES ($reqData_data) ";
    return mysqli_query($link, $reqInsert);



}


?>


