<?php 

	require("bin/connect.php");

	session_start();

	if(!isset($_SESSION["tipo"])){

		header("location:/DiGustiMarketStore/index.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>DiGusti Market Store</title>
	<meta charset="utf-8">
	<meta name="Supermercado" content="Supermercado DiGusti Market Store">
	<link rel="stylesheet" type="text/css" href="Estructura.css">
	<link rel="stylesheet" type="text/css" href="carrito2.css">
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

	</style>
	<script type="text/javascript">
		
		$(document).ready(function() {

			$("#login").hide();	//OCULTAR EL BLOQUE DEL LOGIN
			$(".ver").hide();	//OCULTAR EL VER PRODUCTOS
			$(".ProPagar").hide();

			$(".ProPagar").removeClass('esconder');
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
			
			//-----------------------------------SECCION EXCLUSIVA DEL CONTENIDO DEL CARRITO-----------------------------------------------//
			$(".compra").hover(function() {
				$(this).css('background', 'rgba(255,145,4,1)');
			}, function() {
				$(this).css('background', 'rgba(255,145,4,0.8)');
			});
			
			$("#pagar").click(function(event) {
				$(".ProPagar").fadeIn(300);
			});

			$(".eliminar").click(function(event){
				if(confirm("¿Esta seguro de eliminar este producto?")){
					$.get("bin/deletecarrito.php",{codigo:$(this).attr("id")},function(e){
						location.href="carrito.php";
					});
				}
			});

			$("#0").click(function(event){
				if(confirm("¿Esta seguro de eliminar todos los productos del carrito?")){
					$.get("bin/deletecarrito.php",{codigo:$(this).attr("id")},function(e){
						location.href="carrito.php";
					});
				}
			});
			//-----------------------------------SECCION DEL METODO DE CANCELACION--------------------------------------------------------//
			//VALIDACIONES DE LA COMPRA

			$("#register").validate({	//VALIDACIONES DEL FORMULARIO SI TODO SE CUMPLE SE LANZARIA EL EVENTO SUBMIT

				rules:{	//REGLAS DE VALIDACION PARA CADA INPUT
					tipo_pago:{
						required:true
					},
					tarjeta:{
						number:true,
						required:true,
						minlength: 10,
						maxlength: 16
					},
					tipo_tarjeta:{
						required:true
					},
					retiro:{
						required:true
					}
				},

				messages:{	//MENSAJES DE VALIDACION CONFORME A CADA VALIDACION ECHA
					tipo_pago:{
						required:"Ingresa la forma de cancelar los productos",
					},
					tarjeta:{
						number:"Eg: 0000 0000 0000 0000 / Escirbirlo todo pegado",
						required:"Ingrese un número de tarjeta",
						minlength:"El número de la tarjeta debe ser mayor a 10 dígitos",
						maxlength:"El número no debe exceder de 12 dígitos"
					},
					tipo_tarjeta:{
						required:"Seleccione una opción"
					},
					retiro:{
						required:"Seleccione una opción de retiro"
					},
				},

				errorPlacement:function(error,element){ //Para reposicionar los elementos de error que son level
					
					if(element.is(":radio")){
						error.appendTo(element.parent());
					}
					else
						error.insertAfter(element);
				}

			});

			$("#cancel").click(function(event) {	//animacion de cerrado del proceso de cancelamiento
				$(".ProPagar").fadeOut(500);
			});

			$("#tipo_pago").keyup(function(event) {		//animaciones para habilitar o no las opciones de tarjeta
				if ($(this).val()=="crédito"){
					$(".radio1").each(function(index, el) {
						$(this).removeAttr('disabled');
					});
					$("#tarjeta").removeAttr('disabled');
				}
				else{
					$(".radio1").each(function(index, el) {
						$(this).attr('disabled','false');
					});
					$("#tarjeta").attr('disabled','false');
					$("#tarjeta").val("");
				}	
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
	<div class="factura producto">

		<table>
			<tr>	<!-- Titulo o head donde aprece la descripcion de la tabla -->
				<th>Eliminar</th>
				<th>Descripción del Producto</th>
				<th>Cantidad</th>
				<th>Precio del Producto</th>
				<th>Precio Total</th>
			</tr>
			<?php 

			$sql="SELECT * FROM PRODUCTOS INNER JOIN CARRITO ON PRODUCTOS.CODIGO=CARRITO.CODIGO where ID=:id";

			$query=$bdd->prepare($sql);

			$query->execute(array(":id"=>$_SESSION["id"]));

			$contador=0;

			while($tabla=$query->fetch(PDO::FETCH_ASSOC)):

			?>
   
			<tr>
				<td><input id="<?php echo $tabla['Codigo']?>" class="eliminar" type="button" name="eliminar" value="X"></td>
				<td>
					<img src="<?php echo $tabla["Imagen"]; ?>">
					<div class="descripcion block">
						<p><?php echo $tabla["Nombre"]; ?></p>
					</div>
				</td>
				<td>
					<div class="cantidad">
						<p><?php echo $tabla["Cantidad"]; ?></p>
					</div>
				</td>
				<td>
					<div class="precio">
						<p><?php echo $tabla["Precio"]; ?><font size="2"> Bs</font></p>
					</div>
				</td>
				<td>
					<div class="precio">
						<p><strong><?php echo $tabla["Precio"]*$tabla["Cantidad"]; ?><font size="2"> Bs</font></strong></p>
					</div>	
				</td>
			</tr>
			<?php global $contador; $contador+=$tabla["Precio"]*$tabla["Cantidad"]; endwhile; ?>
				
		</table>		
	</div>
		<!-- SECCION DE LOS BOTONES PARA ELIMINAR TODO EL CARRITO O CANCELAR ESTE -->

		<?php if($contador!=0): ?>
		<div class="cancelar block">
			<p align="right">Total a Cancelar: <strong><font size="5"><?php echo $contador ?></font></strong><font size="2"> Bs</font></p>
			<input id="0" type="button" name="cancelar" value="Eliminar Carrito" class="compra">
			<input id="pagar" type="button" name="cancelar" value="Cancelar Compra" class="compra">
		</div>
		<?php endif; if($contador==0):?>
		<p>No se encuentran productos actualmente en el carrito</p>
		<?php endif; ?>
		<div class="ProPagar esconder">
		<div class="formula">
			<h3>Proceso de Cancelación del Carrito</h3>
			<form id="register" action="bin/compra.php" method="post">
				<datalist id="info">
					<option value="crédito" label="pago con tarjeta de crédito"></option>
					<option value="efectivo" label="pago con eféctivo"></option>
				</datalist>
				<input list="info" id="tipo_pago" class="caja-1" type="text" name="tipo_pago" placeholder="Modalidad de Pago...">
				<input id="tarjeta" class="caja-1" type="text" name="tarjeta" placeholder="Numero de Tarjeta..." disabled="true">
				<div class="radiob">
					<p align="left">Seleccione el tipo de tarjeta:</p>
					<input class="radio1" type="radio" name="tipo_tarjeta" disabled="true">VISA
					<input class="radio1" type="radio" name="tipo_tarjeta" disabled="true">MasterCard
					<input class="radio1" type="radio" name="tipo_tarjeta" disabled="true">AMEX
				</div>
				<div class="radiob">
					<p align="left">Seleccione la forma de retiro de la compra:</p>
					<input type="radio" name="retiro" value="Delivery">Delivery
					<input type="radio" name="retiro" value="Retiro Presencial">Retiro Presencial
				</div>
				<button id="cancel" type="button" class="aceptar">Cancelar</button>
				<button id="aceptar" type="submit" class="aceptar" name="comprar" value="<?php echo $contador ?>">Aceptar</button>
			</form>
		</div>
		<!-- FIN DE LA SECCION DE ESTOS BOTONES -->
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