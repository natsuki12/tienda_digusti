<?php 

	include("connect.php");

	session_start();

	if((!isset($_SESSION["tipo"]))or(isset($_SESSION["tipo"]))){


		header("location:/DiGustiMarketStore/index.php");

	}

	$codigo=$_GET["codigo"];

	$id=$_SESSION['id'];

	if($codigo!=0){

		$bdd->query("DELETE FROM CARRITO WHERE CODIGO='$codigo' AND ID='$id'");

	}else{

		
		$bdd->query("DELETE FROM CARRITO WHERE ID='$id'");

	}

	//header("location:/DiGustiMarketStore/carrito.php");
	echo "loca"

?>