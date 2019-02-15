<?php
include("../controller/session.php");
include ("../errores.php");
set_error_handler("errores");
$comprar = array();
$comprar = $_POST['cat'];
$seguir = $_POST['seguir'];

if($seguir){
	var_dump($comprar);
	header("location:../view/downmusic.php");
}else{
	
}


?>