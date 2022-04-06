<?php

	if(isset($_POST["botonlog"])){

		include("bin/connect.php");

		$sql="SELECT * FROM USUARIO WHERE CORREO= :correo AND PASS = :password";

		$consulta=$bdd->prepare($sql);

		$login=$_POST["usuario"];

		$pass=$_POST["password"];

		$consulta->bindValue(":correo",$login);

		$consulta->bindValue(":password",$pass);

		$consulta->execute();

		$comprobar=$consulta->rowCount();

		if($comprobar!=0){

			$tabla=$consulta->fetch(PDO::FETCH_ASSOC);

			$id=$tabla["ID"];

			$tipo=$tabla["Tipo_Usuario"];

			$sql2="SELECT * FROM DATO_USUARIO WHERE ID= :id";

			$consulta2=$bdd->prepare($sql2);

			$consulta2->execute(array(":id"=>$id));

			$tabla2=$consulta2->fetch(PDO::FETCH_ASSOC);

			$nombre=$tabla2["Nombre"];

			session_start();

			$_SESSION["usuario"]=$nombre;

			$_SESSION["id"]=$id;

			$_SESSION["tipo"]=$tipo;

		}else{

			echo "<script type='text/javascript'>alert('El usuario o la contraseña esta incorrecto')</script>";
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
	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<style type="text/css">
		a{
			text-decoration: none;
			color: #fff;
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
			$(".bloque2").hover(function(e) {	//APARECE EL VER PRODUCTO DE ACUERDO A SOBR EQUE IMAGEN ESTEMOS POSICIONADOS
				$(this).css('opacity', '0.8');
				var id = $(this).attr("id");
				if (id=="imagen2"){
					$("#v1").fadeIn(200);			
				}
				else if (id=="imagen3"){
					$("#v2").fadeIn(200);			
				}
				else if (id=="imagen5"){
					$("#v3").fadeIn(200);			
				}
				else if (id=="imagen6"){
					$("#v4").fadeIn(200);			
				}
				else if (id=="imagen8"){
					$("#v5").fadeIn(200);			
				}
				else if (id=="imagen9"){
					$("#v6").fadeIn(200);			
				}
			}, function() {
				$(this).css('opacity', '1');
				$(".ver").fadeOut(200);
			});
		});
	</script>
</head>
			<!-- FALTA EL LINKIADO DE LAS DIFERENTES PAGINAS Y YA-->
<body>

	<!-- ///////////////////////////////////////////////// BOTONES Y LOGIN ///////////////////////////////////////////////////////////// -->
<?php

		if(!isset($_POST["botonlog"])){

			session_start();

		}
	

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

echo ("
			<div class='o4'>
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
		<section class="bloque1" id="imagen1">
			<div class="sombriado2">
				<p>Compra Juegos desde la comodidad de tu hogar</p>
			</div>
		</section>
		
		<section class="bloque2" id="imagen2">
			<div class="sombriado">
				<p>Juegos de La Consola Xbox</p>
				<div class="ver" id="v1"><a href="producto.php?producto=Bodega">Ver Productos</a></div>
			</div>
		</section>
		
		<section class="bloque2" id="imagen3">
			<div class="sombriado">
				<p>Juegos Populares De Android</p>	<!--Combina tus comidas con nuestros productos-->
				<div class="ver" id="v2"><a href="producto.php?producto=Fruta">Ver Productos</a></div>
			</div>
		</section>
		
		<section class="bloque1" id="imagen4">
			<div class="sombriado2">
				<p>Comodidad Al Comprar</p>
			</div>
		</section>
		
		<section class="bloque2" id="imagen5">
			<div class="sombriado">
				<p>Estrenos De Ps3 y Ps4</p>
				<div class="ver" id="v3"><a href="producto.php?producto=Panaderia">Ver Productos</a></div>
			</div>
		</section>

		<section class="bloque2" id="imagen6">
			<div class="sombriado">
				<p>Juegos De Xbox One y Xbox 360</p>
				<div class="ver" id="v4"><a href="producto.php?producto=Carne">Ver Productos</a></div>
			</div>
		</section>

		<section class="bloque1" id="imagen7">
			<div class="sombriado2">
				<p>Eficacia y Actualizado</p>
			</div>
		</section>
		
		<section class="bloque2" id="imagen8">
			<div class="sombriado">
				<p>Nintendo 3DS</p>
				<div class="ver" id="v5"><a href="producto.php?producto=Verdura">Ver Productos</a></div>
			</div>
		</section>

		<section class="bloque2" id="imagen9">
			<div class="sombriado">
				<p>Nintendo Wii</p>
				<div class="ver" id="v6"><a href="producto.php?producto=Charcuteria">Ver Productos</a></div>
			</div>
		</section>

		<div class="abajo">
			<div id="franja"></div> <br>
			tienda ubicada en en centro comercial a vela nivel mar, 
	        con todo lo que el cliente necesita tanto como estrenos exclusivos, juegos mas populares
	        consolas, accesorios y mucho mas, Theseus Shop unete a la Zona virtual<br> 
			Llévate los productos exclusivos, compra Juegos, Compra en internet tus Juegos y recibe en casa a Domicilio.
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
					Nos encontramos ubicados en la Isla de Margarita, centro comercial La Vela nivel Mar, local número 80-12. <br>
					Número Contacto: 0295-2871372 <br>
					Teléfono Movil: 0412-0302290 <br>
					Correo Electrónico: Theseus-Shop@gmail.com <br>
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
					Theseus Shop "Your Are Ready?", al mejor precio y con la excelencia de nuestros servicios <br> 
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
