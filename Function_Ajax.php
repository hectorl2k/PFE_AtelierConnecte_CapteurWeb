<?php
const HTTP_OK = 200;
const HTTP_BAD_REQUEST= 400;
const HTTP_METHOD_NOT_ALLOWED= 409;
session_start();
include("config_serveur.php");
include("connect.php");
include("RequeteVers_BDD.php");
include("Algorithme_RG09.php");
include ("Index_Function.php");

$data="";

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {

    $response_code = HTTP_BAD_REQUEST;
    $message = "Il manque le parametre Action";


    if ($_POST['action'] == "FunctionDelRow" && isset($_POST['ArrayDelRow'])) {
        $response_code = HTTP_OK;
        $message = FunctionDelRow();
    } elseif ($_POST['action'] == "Impression") {

        $data=impression();



        $response_code = HTTP_OK;
        $message = "Pret a Imprimer";


    } }else{
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $message = "Method not allowed";
    }

    response($response_code, $message,$data);


    function response($response_code, $message,$data)
    {
        header('Content-Type:application/json');
        http_response_code($response_code);
        $response = ["response_code" => $response_code, "message" => $message, "data" => $data];


        echo json_encode($response);
    }

    function FunctionDelRow()
    {

        $row = $_POST['ArrayDelRow'];
        $filename = "./Request/".$_SESSION['fichier_txt_save'];

        $handle = fopen( $filename, "r+");
        $data = fread($handle, filesize($filename));
        fclose($handle);

        $error = explode("\n", $data);
        unset($error[$row]);

        $txt = implode("\n", $error);

        $handle = fopen( $filename, "w");
        $err=fwrite($handle, $txt);
        fclose($handle);

        if($err!=0){ return "Erreur lors de la suppression";}else{ return "Suppression Confirme";}



    }







/*

header('location:index.php'); */
?>
