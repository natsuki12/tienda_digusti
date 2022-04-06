<?php 

	include("connect.php");

	$name_imagen="chocolate.jpg";

	$sql="SELECT IMAGEN FROM PRODUCTOS WHERE IMAGEN=:img";

	$img="/DiGustiMarketStore/Server_img/" . $name_imagen;

	$query=$bdd->prepare($sql);

	$query->execute(array(":img"=>$img));

	if($query->rowCount()<1){

		echo "Se puede subir la imagen";
	}else{

		echo "Imagen duplicada";
	}

?>