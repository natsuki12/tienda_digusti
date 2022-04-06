<?php 

	require("bin/connect.php");

	session_start();

	if(!isset($_GET["factura"])){

		header("location:index.php");

	}

	$factura=$_GET["factura"];

	$id=$_SESSION["id"];

	$sql_p="SELECT * FROM DATO_USUARIO WHERE ID=:id";

	$query_p=$bdd->prepare($sql_p);

	$query_p->execute(array(":id"=>$id));

	$persona=$query_p->fetch(PDO::FETCH_ASSOC);

	$sql="SELECT * FROM ORDEN INNER JOIN PRODUCTOS ON PRODUCTOS.CODIGO=orden.CODIGO where c_factura=$factura";

	$sql2="SELECT * FROM FACTURA WHERE C_FACTURA=:factura";

	$query_f=$bdd->prepare($sql2);

	$query_f->execute(array(":factura"=>$factura));

	$fact=$query_f->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title>DiGusti Market Store</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="factura.css">
	<link rel="stylesheet" type="text/css" href="fuentes.css">
	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function($) {
			$(".print").click(function(event) {
				$(this).hide();
				window.print();
				self.close();
			});
		});
	</script>
</head>
<body>
	<input class="print" type="button" name="boton" value="Imprimir">  
	<div class="factura">
		<img src="Alimentos/logo1.png">
		<div class="informacion">
			<font>Dirección: Porlamar, Av.Bolivar, Sector la Vela (Local nro:80-12)</font><br>
			<font>Teléfono: 0295-2624415</font><br>
			<font>Persona: <?php echo $persona["Nombre"] . " " . $persona["Apellido"];?></font><br>
			<font>Cedula: <?php echo $persona["Ci"];?></font><br>
		</div>
		<div class="producto">
			<table>
				<tr>
					<th>Producto</th>
					<th>Precio</th>
				</tr>
				<?php foreach($bdd->query($sql) as $producto):?>
				<tr>
					<td class="izquierda"><?php echo $producto["Nombre"];?> / Cantidad (<?php echo $producto["Cantidad"];?>)</td>
					<td class="derecha"><?php echo $producto["Precio"]*$producto["Cantidad"];?><font size="2"> Bs</font></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<div class="precio">
			TOTAL <br>
			<span><?php echo $fact["Monto"];?><font size="2"> BS</font></span>
		</div>
		<footer>Fecha: <?php echo $fact["Fecha"];?> - Código de la Factura:<?php echo $factura;?></footer>
	</div>
</body>
</html>
