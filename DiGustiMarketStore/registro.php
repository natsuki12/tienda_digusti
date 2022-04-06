<?php

	session_start();

	if(isset($_SESSION["tipo"])){


		header("location:/DiGustiMarketStore/index.php");

	}

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


			$_SESSION["usuario"]=$nombre;

			$_SESSION["id"]=$id;

			$_SESSION["tipo"]=$tipo;

			echo "<script type='text/javascript'>location.href='index.php'</script>";

		}else{

			echo "<script type='text/javascript'>alert('El usuario o la contraseña esta incorrecto')</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>DiGusti Market Store</title>
	<meta charset="utf-8">
	<meta name="Supermercado" content="Supermercado DiGusti Market Store">
	<link rel="stylesheet" type="text/css" href="Estructura.css">
	<link rel="stylesheet" type="text/css" href="registro.css">
	<link rel="stylesheet" type="text/css" href="fuentes.css">
	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="jquery.validate.min.js"></script>
	<style type="text/css">
		a{
			text-decoration: none;
			color: #fff;
		}

		label.error{	/*MANIPULO EL CSS DEL LABEL QUE SE ESCRIBE CUANDO HAY UN ERROR*/
			color: red;
			margin-top: 5px;
			width: 50%;
			margin-left: 2%;
			display: inline-block;
			font-style: italic;
		}

		input.error{	/*MODIFICA LOS INPUT QUE HAYAN TENEDIO ALGUN ERROR*/
			border: 1px solid red;
			background: rgba(230,200,180,0.5);
		}

		.bloque1{
			margin-top: 2%;
		}

	</style>
	<script type="text/javascript">
		
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

			//-----------------------------------SECCION EXCLUSIVA DEL CONTENIDO DEL REGISTRO-----------------------------------------------//
			//VALIDACIONES PARA EL ENVIO DEL REGISTRO 
			
			$("#register").validate({	//VALIDACIONES DEL FORMULARIO SI TODO SE CUMPLE SE LANZARIA EL EVENTO SUBMIT

				rules:{	//REGLAS DE VALIDACION PARA CADA INPUT
					nombre:{
						required:true
					},
					apellido: "required",
					email:{
						email:true,
						required:true
					},
					cedula:{
						number:true,
						required:true,
						minlength: 7
					},
					dir1:{
						required: true,
						minlength:10
					},
					dir2:{
						required: true,
						minlength:2
					},
					contraseña:{
						required:true,
						minlength:6
					},
					confirmar:{
						equalTo:"#contraseña",
						required:true,
						minlength:6
					}
				},

				messages:{	//MENSAJES DE VALIDACION CONFORME A CADA VALIDACION ECHA
					nombre:{
						required:"Ingresa Tu nombre",
					},
					apellido:"Ingresa tu Apellido",
					email:{
						email:"@ y su formato .extension",
						required:"Ingrese su email correspondiente"
					},
					cedula:{
						number:"Solamete valores numericos",
						required:"Ingrese su Cedula",
						minlength: "La cedula al menos tiene 7 cifras"
					},
					dir1:{
						required:"Ingresa tu dirección de Vivienda",
						minlength:"Minimo 10 caracteres de dirección"
					},
					dir2:{
						required:"Ingresa tu dirección de Vivienda",
						minlength:"Minimo 2 caracteres de dirección"
					},
					contraseña:{
						required:"Ingresa tu contraseña",
						minlength:"Debe tener al menos 6 caracteres"
					},
					confirmar:{
						required:"Ingresa tu confirmación de contraseña",
						equalTo:"La contraseña no coincide con la principal",
						minlength:"Debe tener al menos 6 caracteres"
					}		
				},

				errorPlacement:function(error,element){ //Para reposicionar los elementos de error que son level
					error.insertAfter(element);
				}

			});
			
			$(".caja-1").focus(function(event) {
				$(this).css('background', 'rgba(255,218,42,0.2)');	//CAMBIARLE EL COLOR
			});

			$(".caja-1").blur(function(event) {
				$(this).css('background', 'none');
			});

			$(".block").hover(function() {
				$(this).css('background', 'rgba(48,48,47,0.7)'); 
			}, function() {
				$(this).css('background', 'rgba(33,127,20,1)');
			});
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
			<li class="opcion"><a href="producto.php?producto=Carne">Carnes</a></li>
			<li class="opcion"><a href="producto.php?producto=Panaderia">Panadería</a></li>
			<li class="opcion"><a href="producto.php?producto=Charcuteria">Charcutería</a></li>
			<li class="opcion"><a href="producto.php?producto=Verdura">Verduras</a></li>
			<li class="opcion"><a href="producto.php?producto=Bodega">Bodega</a></li>
			<li class="opcion"><a href="producto.php?producto=Fruta">Frutas</a></li>
			<li class="opcion"><a href="ayuda.php">Ayuda</a></li>
		</ul>
	</nav>	
	<!-- ///////////////////////////////////////////////// FIN SECTOR SUPERIOR ///////////////////////////////////////////////////////////// -->

	<!-- ///////////////////////////////////////////////// CONTENIDO ///////////////////////////////////////////////////////////// -->
	<div id="contenido">
		<section class="bloque1">
			<img src="Alimentos/señor.jpg">
			<br>
			!Regístrate y vive una experiencia única! <br>
			<img style="width: 80%; border-radius: 0px;" src="Alimentos/logo1.png"> 
		</section>
		<section class="bloque2">
			<div class="formula">
				<h1>Formulario de Contacto</h1>
				<p>Regístrate en digusti.com y accede a múltiples beneficios, descuentos, información y ofertas exclusivas para ti.<strong> Hazlo y comienza a disfrutar de una experiencia única y pensada para ti</strong></p>
			<form action="registro.php" method="post" class="sombriado" id="register">
				<input id="nombre" type="text" name="nombre" placeholder="Nombre..." class="caja-1" >
				<input id="apellido" type="text" name="apellido" placeholder="Apellido..." class="caja-1" >
				<input type="email" name="email" placeholder="Correo Electrónico..." class="caja-1">
				<input id="cedula" type="text" name="cedula" placeholder="Cedula..." class="caja-1">
				<input id="dir1" type="text" name="dir1" placeholder="Dirección de Hogar..." class="caja-1" >
				<input id="dir2" type="text" name="dir2" placeholder="Ciudad..." class="caja-1" >
				<input id="contraseña" type="password" name="contraseña" placeholder="Contraseña..." class="caja-1" >
				<input id="confirmar" type="password" name="confirmar" placeholder="Confirmar Contraseña..." class="caja-1" >
				<button type="submit" class="block" name="registrar">Enviar</button>
			</form>
			</div>
		</section>
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
					DiGusti Market Store siempre a la Vanguardia con los nuevos productos, al mejor precio y con la excelencia de nuestros servicios <br> 
					<!-- IMAGEN DEL LOGO PERO MUCHO MAS PEQUEÑA -->
					<img src="Alimentos/logo2.png" width="250" height="100">
					<!-- SECCION MANUAL DE USUARIO -->
					<div class="manual">
						Aprende a Manipular la Página con el 
						<label id="manual" style="text-decoration: underline; color: red; cursor: pointer;">Manual de Usuario</label>
					</div>
				</div>
			</section>
		</div>
		<footer>	<!-- AUTORES -->
				Derechos Reservados: Ing. Ramirez Andres e Ing. Gil Miguel
		</footer>
	</div>
	<!-- ///////////////////////////////////////////////// FIN SECTOR INFERIOR ///////////////////////////////////////////////////////////// -->
</body>
</html>

<?php
	
	include("bin/connect.php");

	if(isset($_POST["registrar"])){

		$nombre=$_POST["nombre"];
		$email=$_POST["email"];
		$apellido=$_POST["apellido"];
		$direccion=$_POST["dir1"];
		$ciudad=$_POST["dir2"];
		$pass1=$_POST["contraseña"];
		$pass2=$_POST["confirmar"];
		$ci=$_POST["cedula"];


		if(!is_numeric($ci)){

			echo "<script type='text/javascript'>alert('La Cédula solo es de caracter numerico')</script>";

		}else{

			$q_verificar1="SELECT * FROM USUARIO WHERE CORREO= :correo";

			$q_verificar2="SELECT * FROM DATO_USUARIO WHERE CI= :ci";

			$verificar1=$bdd->prepare($q_verificar1);

			$verificar2=$bdd->prepare($q_verificar2);

			$verificar1->execute(array(":correo"=>$email));

			$verificar2->execute(array(":ci"=>$ci));

			if($verificar1->rowCount()>0){

				echo "<script type='text/javascript'>alert('El correo ya se encuentra afiliado a un Usuario.')</script>";

			}else{

				if($verificar2->rowCount()>0){

					echo "<script type='text/javascript'>alert('La Cedula ya se encuentra afiliada a un Usuario.')</script>";

				}else{

					$q_insertar1="INSERT INTO USUARIO (CORREO, PASS) VALUES (:correo, :pass)";

					$q_insertar2="INSERT INTO DATO_USUARIO (NOMBRE, APELLIDO, CI, DIRECCION, CIUDAD) VALUES (:nombre, :apellido, :ci, :direccion, :ciudad)";

					$usuario=$bdd->prepare($q_insertar1);

					$datos=$bdd->prepare($q_insertar2);

					$usuario->execute(array(":correo"=>$email, ":pass"=>$pass1));

					$datos->execute(array(":nombre"=>$nombre, ":apellido"=>$apellido, ":ci"=>$ci, ":direccion"=>$direccion, ":ciudad"=>$ciudad));

					echo "<script type='text/javascript'>alert('Registro Exitoso!!')</script>";
						
						
				}
			}
		}
	}
?>