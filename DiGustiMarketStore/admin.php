<?php 

	require("bin/connect.php");

	session_start();

	if((!isset($_SESSION["tipo"]))or($_SESSION["tipo"]!=1)){

		header("location:/DiGustiMarketStore/index.php");
	}

	if(isset($_SESSION["actualizar"])){

		if($_SESSION["actualizar"]==1){

			echo "<script type='text/javascript'>alert('Se ha actualizado el producto correctamente')</script>";

			$_SESSION["actualizar"]=0;
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Theseus Shop</title>
	<meta charset="utf-8">
	<meta name="Supermercado" content="Theseus Shop">
	<link rel="stylesheet" type="text/css" href="Estructura.css">
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="fuentes.css">
	<link rel="stylesheet" type="text/css" href="compras.css">
	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<style type="text/css">
		a{
			text-decoration: none;
			color: #fff;
		}

		.paginacion{

			color: #333;
		}
	</style>
	<script type="text/javascript">
		var loggueado="";
		$(document).ready(function() {

			$("#login").hide();	//OCULTAR EL BLOQUE DEL LOGIN
			$(".ver").hide();	//OCULTAR EL VER PRODUCTOS

			$("#login").removeClass('esconder');
			$("#bienvenute").removeClass('esconder');

			//EVENTO PARA CLICKIAR EL LOGO Y CARGAR EL HOME
			$("#logo").click(function(event) {
				location.href = "index.php";
			});
			//FIN EVENTO DEL CLICK DEL LOGO
			
			$("#BarraI p").hover(function() {	//ANIMACION DE LOS BOTONES SUPERIORES
				$(this).animate({borderWidht: "5px", fontSize: "23px"}, 500);
			}, function() {
				$(this).animate({borderWidht: "2px", fontSize: "15px"}, 500);
			});									//FIN BOTONES SUPERIOR

			$("#sesion").click(function(event) {	//ANIMACION DE ABRIR EL BOTON DE LOGIN
				$("#login").fadeIn(500);
			});

			$("#cerrar").click(function(event) {	//ANIMACION DE CERRAR EL LOGIN
				$("#login").fadeOut(500);
			});

			//AUTO SEÑALIZAR EL BOTON INVITADO
			$("#invitado").css("background","rgba(48,48,47,1)"); 		//('text-shadow','black 2px 2px 10px');

			//ANIMACION DE LOS BOTONES DE LA BARRA DE NAVEGACION
			$(".opcion").hover(function() {
				$(this).animate({fontSize: "25px"}, 350);
			}, function() {
				$(this).animate({fontSize: "20px"}, 350);
			});

			//SECCION DEL MENU DEL PERFIL DEL USUARIO
				$(".logusuario").hide();
				$("#log").click(function(){
					$(".logusuario").slideToggle(500);
				});

				$(".opcusuario").hover(function() {
					$(this).css('text-decoration', 'underline');
				}, function() {
					$(this).css('text-decoration', 'none');
				});
			//ESCRIBIR EL CLICK DE CADA OPCION DE USUARIO//

			//ESCRIBIR EL CLICK DE CERRAR SESION QUE A LA VEZ ACOMODARA LOS BOTONES DE INICIAR SESIN Y TODO ESO
			$("#csesion").click(function(){
				$("#bienvenute").fadeOut(200);
				$(".logusuario").hide(); 
				$("#BarraI").fadeIn(200);
			});
			//FIN SECCION DEL MENU DEL PERFIL

			$("#manual").click(function(event) {	//para mostrar el manual de usuario en otra pestaña
				open("Guia.pdf", "Manual de Usuario", "height=100%","width=100%");
			});

			//--------------------------------------SECCION EXCLUSIVA DEL CONTENIDO DEL HOME-----------------------------------------------//
		});
	</script>
</head>
			<!-- FALTA EL LINKIADO DE LAS DIFERENTES PAGINAS Y YA-->
<body>

	<!-- ///////////////////////////////////////////////// BOTONES Y LOGIN ///////////////////////////////////////////////////////////// -->
<?php


		if(isset($_SESSION["usuario"])){

			//<!-- BOTONES PARTE SUPERIOR -->		

			echo ("<div id='bienvenute' class='esconder'> 
			<div id='usuario'>
				<p>Bienvenido " . $_SESSION["usuario"] . ", a DiGusti Market Store</p>
				<img id='log' src='Alimentos/usuario.png'>
			</div>"); // ***********************QUITAR CLASES ESCONDER*****************

		}else{

			echo ("<div id='BarraI'>                         
					<p id='sesion'>Iniciar Sesion</p>
					<p id='registro'><a href='registro.php'>Registrarse</a></p>
					<p id='invitado'>Invitado</p>
				</div>");

		}

	?>

<?php


	if(isset($_SESSION["usuario"])){

	echo ("<div class='logusuario'>
			<div class='o1'>
				<p class='opcusuario'><a href='configuracion.php'>Configuración</a></p>
			</div>
			<div class='o2'>
				<p class='opcusuario'><a href='carrito.php'>Carrito</a></p>
			</div>
			<div class='o3'>
				<p class='opcusuario'><a href='compras.php'>Ultimas Compras</a></p>
			</div>");


				if($_SESSION["tipo"]==1){

					echo ("<div>
							<p class='opcusuario'><a href='admin.php'>Admin</a></p>
						</div>");

				}

	echo ("<div class='o4'>
				<p class='opcusuario' id='csesion'><a href='bin/csion.php'>Cerrar Sesion</a></p>
			</div>
		</div> 
		</div>");

	}

?>

	<div id="login" class="esconder">	<!-- CONTENIDO DEL LOGIN -->
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
			<input class="log" type="email" name="usuario" placeholder="Ingresar Correo..." required>
			<input class="log" type="password" name="password" placeholder="Contraseña..." required><br>
			<input class="log boton" type="submit" name="botonlog" value="Enviar">
			<input id="cerrar" class="log boton" type="button" name="cerrar" value="Cerrar">
		</form>
	</div>

	<!-- ///////////////////////////////////////////////// FIN BOTONES Y LOGIN ///////////////////////////////////////////////////////////// -->

	<!-- ///////////////////////////////////////////////// SECTOR SUPERIOR ///////////////////////////////////////////////////////////// -->
	<div id="imagenP">
		<form class="formulario" action="buscador.php"> <!-- BARRA DE BUSQUEDA-->
			<input class="texto busqueda" type="text" name="busqueda" placeholder="Barra de Búsqueda..." method="get">
			<input class="boton busqueda" type="button" name="submit" value="Buscar">
		</form>

		<div id="navegacion">	<!-- BARRA DE NAVEGACION-->
			<img id="logo" src="Alimentos/logo1.png">
			<!-- AQUI ESTABA LA BARRA DE NAVEGACION ANTES -->
		</div>
	</div>

	<nav id="barra">
		<ul>
			<li class="opcion"><a href="index.php">Home</a></li>
			<li class="opcion"><a href="producto.php?producto=Carne">Xbox</a></li>
			<li class="opcion"><a href="producto.php?producto=Panaderia">Playstation</a></li>
			<li class="opcion"><a href="producto.php?producto=Charcuteria">Nintendo Wii</a></li>
			<li class="opcion"><a href="producto.php?producto=Verdura">Nintendo 3DS</a></li>
			<li class="opcion"><a href="producto.php?producto=Bodega">PC</a></li>
			<li class="opcion"><a href="producto.php?producto=Fruta">Android</a></li>
			<li class="opcion"><a href="ayuda.php">Ayuda</a></li>
		</ul>
	</nav>	
	<!-- ///////////////////////////////////////////////// FIN SECTOR SUPERIOR ///////////////////////////////////////////////////////////// -->

	<!-- ///////////////////////////////////////////////// CONTENIDO ///////////////////////////////////////////////////////////// -->
	<div id="contenido">
		<?php 

			if(isset($_POST["b_insert"])){

				$nom=$_POST["nom"];
				$cat=$_POST["cat"];
				$pre=$_POST["pre"];
				$name_imagen=$_FILES['fot']['name'];
				$size_imagen=$_FILES["fot"]['size'];
				$type_imagen=$_FILES['fot']['type'];

				if($type_imagen=="image/jpeg" || $type_imagen=="image/jpg" || $type_imagen=="image/png" || $type_imagen=="image/gif"){

					if($size_imagen<=4294967298){

						$sql="SELECT IMAGEN FROM PRODUCTOS WHERE IMAGEN=:img";

						$img="/DiGustiMarketStore/Server_img/" . $name_imagen;

						$query=$bdd->prepare($sql);

						$query->execute(array(":img"=>$img));

						if($query->rowCount()<1){

							$destino=$_SERVER["DOCUMENT_ROOT"] . "/DiGustiMarketStore/Server_img/";

							move_uploaded_file($_FILES["fot"]["tmp_name"],$destino . $name_imagen);

							$img="/DiGustiMarketStore/Server_img/" . $name_imagen;


							$sql="INSERT INTO PRODUCTOS (NOMBRE, CATEGORIA, PRECIO, IMAGEN) VALUES (:nom,:cat,:pre,:img)";

							$in_bdd=$bdd->prepare($sql);

							$in_bdd->execute(array(":nom"=>$nom,":cat"=>$cat,":pre"=>$pre, ":img"=>$img));


							echo "<script type='text/javascript'>alert('Se agrego correctamente el producto a la BDD')</script>";

						}else{

							echo "<script type='text/javascript'>alert('Ya existe un archivo con el mismo nombre en el servidor')</script>";
						}

					}else{

						echo "<script type='text/javascript'>alert('Archivo muy grande para la base de datos')</script>";

					}

				}else{


					echo "<script type='text/javascript'>alert('El tipo de archivo no es el correcto')</script>";	

				}

			}

			$n_filas=10;


			if(isset($_GET["pagina"])){

				if($_GET["pagina"]==1){

					echo "<script type='text/javascript'>location.href='admin.php'</script>";

				}else{

					$n_pagina=$_GET["pagina"];

				}

			}else{

				$n_pagina=1;

			}

			$empezar=($n_pagina-1)*$n_filas;

			$bdd_filas=$bdd->query("SELECT * FROM PRODUCTOS ");

			$n_consulta=$bdd_filas->rowCount();

			$pgn_total=ceil($n_consulta/$n_filas);

			$bdd_filas->closeCursor();

			$registro=$bdd->query("SELECT * FROM PRODUCTOS LIMIT $empezar,$n_filas")->fetchAll(PDO::FETCH_OBJ);


		 ?>


		<form method="post" action="admin.php" enctype="multipart/form-data">
			<div class="factura">
			<p><strong>Insertar nuevo producto</strong></p>
			<table>
				<tr>
					<th>Nombre</th>
					<th>Categoría</th>
					<th>Precio</th>
					<th>Foto</th>
				</tr>
				<tr>
			 		<td><input type="tex" name="nom" required></td>
			 		<td>
			 			<datalist id=categoria>
			 				<option value="Panaderia"></option>
			 				<option value="Carne"></option>
			 				<option value="Charcuteria"></option>
			 				<option value="Fruta"></option>
			 				<option value="Bodega"></option>
			 				<option value="Verdura"></option>
			 			</datalist>
			 			<input list="categoria" type="tex" name="cat" required>
			 		</td>
			 		<td><input type="tex" name="pre" required></td>
			 		<td><input type="file" name="fot" required></td>
				</tr>
				<tr>
					<td colspan="4"><input type="submit" name="b_insert" value="Insertar"></td>
				</tr>
			</table>
			</div>
		</form>

		<div class="factura">
		<p><strong>Productos Pag. <?php echo $n_pagina;?></strong></p>
		<table>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Categoría</th>
				<th>Precio</th>
				<th>Opciones</th>
			</tr>

			<?php foreach ($registro as $producto): ?>

			<tr>
				<td><?php echo $producto->Codigo?></td>
				<td><?php echo $producto->Nombre?></td>
				<td><?php echo $producto->Categoria?></td>
				<td><?php echo $producto->Precio?></td>
				<td><a href="bin/delete.php?Codigo=<?php echo $producto->Codigo; ?>"><input type='button' name='del' value='Borrar'></a><a href="bin/update.php?nom=<?php echo $producto->Nombre;?>&cat=<?php echo $producto->Categoria;?>&pre=<?php echo $producto->Precio;?>&cod=<?php echo $producto->Codigo;?>"><input type='button' name='up' value='Actualizar'></a></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="5"><?php 

					echo "Pgn. ";

					for($i=1; $i<=$pgn_total; $i++){

						echo "<a class='paginacion' href='?pagina=" . $i . "'>" . $i . "</a> ";

					}
				?></td>
				
			</tr>
		</table>
		</div>
	</div>
	
	<!-- ///////////////////////////////////////////////// FIN DE CONTENIDO ///////////////////////////////////////////////////////////// -->
	
	<!-- ///////////////////////////////////////////////// SECTOR INFERIOR ///////////////////////////////////////////////////////////// -->
	<div class="slogan">Un Placer Todos los Días, Ven, Compra y Disfruta!!!</div>
	<div id="informacion">
		<div class="juramental">	<!-- 3 BLOQUES DE INFORMACION -->
			<section class="bloque"> 
				<div class="jur">
					<span class="cambio">Sobre Nosotros</span><br><br>
					Nos encontramos ubicados en la Isla de Margarita, Ciudad de Porlamar, Av.Bolivar, diagonal al centro comercial La Vela y Venetur, local número 80-12. <br>
					Número Contacto: 0295-2624415 <br>
					Teléfono Movil: 0412-7942183 <br>
					Correo Electrónico: digusti@gmail.com <br>
				</div>
			</section>
			<section class="bloque">
				<div class="jur">
					<span class="cambio">Redes Sociales</span><br><br>
					<section class="f1">Dale like en Facebook</section>
					<section class="f2">Miranos por Instagram</section>
					<section class="f3">Siguenos en Twitter</section>
					<section class="f4">Subscribete en Youtube</section>
				</div>
			</section>
			<section class="bloque">
				<div class="jur">
					Theseus Shop "Your Are Ready?", al mejor precio y con la excelencia de nuestros servicios<br> 
					<!-- IMAGEN DEL LOGO PERO MUCHO MAS PEQUEÑA -->
					<img src="Alimentos/Theseus.jpg" width="250" height="100">
					<!-- SECCION MANUAL DE USUARIO -->
					<div class="manual">
						Aprende a Manipular la Página con el 
						<label id="manual" style="text-decoration: underline; color: red; cursor: pointer;">Manual de Usuario</label>
					</div>
				</div>
			</section>
		</div>
		<footer>	<!-- AUTORES -->
				Realizado Por: Cesar Requena y Pedro Arevalo
		</footer>
	</div>
	<!-- ///////////////////////////////////////////////// FIN SECTOR INFERIOR ///////////////////////////////////////////////////////////// -->
</body>
</html>