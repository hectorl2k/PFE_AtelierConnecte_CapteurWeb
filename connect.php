
<?php


function Connection(){



$connection = mysqli_connect($_SESSION["Serveur"], $_SESSION["Server_user"], $_SESSION["Server_pass"],$_SESSION["db"]);

if (!$connection) {
die('MySQL ERROR: ' . mysqli_connect_error());
}
mysqli_select_db($connection,$_SESSION["db"]) or die( 'MySQL ERROR: '. mysqli_error() );

return $connection;
}

?>