<?php  

	require("bin/connect.php");

	session_start();

	if(!isset($_SESSION["tipo"])){

		header("location:/DiGustiMarketStore/index.php");
	}

	if(isset($_POST["configurar"])){

		$correo=$_POST["correo"];
		$direccion=$_POST["dir1"];
		$ciudad=$_POST["dir2"];
		$n_pass=$_POST["confirmar"];
		$v_pass=$_POST["contra"];

		$sql="SELECT * FROM USUARIO WHERE ID=:id";

		$consulta=$bdd->prepare($sql);

		$consulta->execute(array(":id"=>$_SESSION["id"]));

		$registro=$consulta->fetch(PDO::FETCH_ASSOC);

		if($registro["Pass"]==$v_pass){

			$sql2="UPDATE USUARIO SET CORREO=:correo, PASS=:pass WHERE ID=:id";

			$sql3="UPDATE DATO_USUARIO SET DIRECCION=:dir, CIUDAD=:ciudad WHERE ID=:id";

			$up_user=$bdd->prepare($sql2);

			$up_date=$bdd->prepare($sql3);

			$up_user->execute(array(":correo"=>$correo, ":pass"=>$n_pass, ":id"=>$_SESSION["id"]));

			$up_date->execute(array(":dir"=>$direccion, ":ciudad"=>$ciudad, ":id"=>$_SESSION["id"]));

			$up1=$up_user->rowCount();

			$up2=$up_date->rowCount();

			//if(($up1!=0)&&($up2!=0)){

				echo "<script type='text/javascript'>alert('Se actualizaron sus datos exitosamente')</script>";

			//}
		}else{

			echo "<script type='text/javascript'>alert('La contraseña actual es incorrecta')</script>";

		}

	}

	$sql1="SELECT * FROM USUARIO WHERE ID=:id";

	$sql2="SELECT * FROM DATO_USUARIO WHERE ID=:id";

	$consulta1=$bdd->prepare($sql1);

	$consulta2=$bdd->prepare($sql2);

	$consulta1->execute(array(":id"=>$_SESSION["id"]));

	$consulta2->execute(array(":id"=>$_SESSION["id"]));

	$registro1=$consulta1->fetch(PDO::FETCH_ASSOC);

	$registro2=$consulta2->fetch(PDO::FETCH_ASSOC);



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

		.block{
			width: 20%;
			margin-left: 10%;
			margin-right: 11%;
		}
		
		.config{
			width: 100%;
			text-align: center;
			font-size: 18px;
			margin-bottom: -37px;	 
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

			//-----------------------------------SECCION EXCLUSIVA DEL CONTENIDO DE CONFIGURACION---------------------------------------------//
			//VALIDACIONES PARA EL ENVIO DE LA CONFIGURACION 

			$("#register").validate({	//VALIDACIONES DEL FORMULARIO SI TODO SE CUMPLE SE LANZARIA EL EVENTO SUBMIT

				rules:{	//REGLAS DE VALIDACION PARA CADA INPUT
					correo:{
						email:true,
						required: true
					},
					dir1:{
						minlength:10,
						required:true
					},
					dir2:{
						minlength:2,
						required:true
					},
					contraseña:{
						minlength:6,
						required:true
					},
					confirmar:{
						equalTo:"#contraseña",
						minlength:6,
						required:true
					},
					contra:{
						required: true
					}
				},
				
				messages:{	//MENSAJES DE VALIDACION CONFORME A CADA VALIDACION ECHA
					correo:{
						email:"@ y su formato .extension",
						required: "Porfavor rellene todos los campos"
					},
					dir1:{
						minlength:"Minimo 10 caracteres de dirección",
						required: "Porfavor rellene todos los campos"
					},
					dir2:{
						minlength:"Minimo 2 caracteres de dirección",
						required: "Porfavor rellene todos los campos"
					},
					contraseña:{
						minlength:"Debe tener al menos 6 caracteres",
						required: "Porfavor rellene todos los campos"
					},
					confirmar:{
						equalTo:"La contraseña no coincide con la principal",
						minlength:"Debe tener al menos 6 caracteres",
						required: "Porfavor rellene todos los campos"
					},
					contra:{
						required: "Debes Introducir tu contraseña actual para confirmar los cambios"
					}		
				},

				errorPlacement:function(error,element){ //Para reposicionar los elementos de error que son level
					error.insertAfter(element);
				}

			});
			
			/*DEBE EXISTIR ALGUNA FORMA QUE EN EL SUBMIT SE ENVIE DIRECTAMENTE AL PHP
			$(".sombriado").submit(function(event) {
				alert("REGISTRO CORRECTO");
				return false;
			});
			*/

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
			<img src="Alimentos/ImagenHome.jpg"> <br>
			Información y Configuración de usuario <br>
		</section>
		<section class="bloque2">
			<div class="formula">
				<h1>Información de Usuario</h1>
				<p>Configuración de Usuario. <strong>Recuerda ingresar tu contraseña actual para confirmar los cambios</strong>. Recuerde rellenar todos los campos, en caso de ser la misma información suministre la misma sin en cambio en el campo donde se solicite.</p>
			<form action="configuracion.php" method="POST" class="sombriado" id="register">
				<div class="caja-1 config">Correo: <?php echo $registro1['Correo']; ?></div>
				<input id="correo" type="email" name="correo" placeholder="Correo Nuevo o Actual..." class="caja-1">
				<div class="caja-1 config">Dirección: <?php echo $registro2['Direccion']; ?></div>
				<input id="dir1" type="text" name="dir1" placeholder="Dirección Nueva o Actual..." class="caja-1">
				<div class="caja-1 config">Ciudad: <?php echo $registro2['Ciudad']; ?></div>
				<input id="dir2" type="text" name="dir2" placeholder="Ciudad Nueva o Actual..." class="caja-1">
				<input id="contraseña" type="password" name="contraseña" placeholder="Contraseña Nueva o Actual..." class="caja-1">
				<input id="confirmar" type="password" name="confirmar" placeholder="Confirmar Contraseña..." class="caja-1">
				<input id="contra" type="password" name="contra" placeholder="Contraseña Actual Para Confirmar..." class="caja-1">
				<button type="submit" class="block" name="configurar">Enviar</button>
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
