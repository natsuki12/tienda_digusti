<?php
	
	require("connect.php");
	session_start();

	if((!isset($_SESSION["tipo"]))or(isset($_SESSION["tipo"]))){


		header("location:/DiGustiMarketStore/index.php");

	}

	$codigo = $_GET["codigo"];
	$cantidad = $_GET["cantidad"];

	$sql="INSERT INTO CARRITO (ID, CODIGO, CANTIDAD) VALUES (:id, :codigo, :cantidad)";

	$query=$bdd->prepare($sql)->execute(array(":id"=>$_SESSION["id"],":codigo"=>$codigo,":cantidad"=>$cantidad));

	echo "Producto insertado correctamente Carrito";

?>