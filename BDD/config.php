<?php


define('string',1);
define('float',0);



// Base de donnée

$_SESSION['Serveur']=    "localhost";
$_SESSION['Server_user']=      "admin_bc";
$_SESSION['Server_pass']=      "password_bc";
$_SESSION['db_name']=        "atelierconnectes";



// Table a afficher


$_SESSION['max_rows_html']= 100;

$_SESSION['col_name_bd']=      array("id","DateHeure","ID_BORNE","ID_USER","PILLAR");
$_SESSION['col_name_http']=    array("id","DateHeure","Nom Boitier","USER","PILLAR");

$_SESSION['type_row']=    array(float,string,string,string,float,float,float,float);
$_SESSION['rows_show_html']=array(0,1,2,3,4);







// Envoi les data en Session








