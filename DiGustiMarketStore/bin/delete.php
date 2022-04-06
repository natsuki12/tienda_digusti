<?php 

	session_start();

	if((!isset($_SESSION["tipo"]))or($_SESSION["tipo"]!=1)){


		header("location:/DiGustiMarketStore/index.php");

	}

	include("connect.php");

	$codigo=$_GET["Codigo"];

	$bdd->query("DELETE FROM PRODUCTOS WHERE CODIGO='$codigo'");

	header("location:/DiGustiMarketStore/admin.php");


?>