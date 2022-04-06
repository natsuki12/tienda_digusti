<link rel="stylesheet" type="text/css" href="Estructura.css">
<link rel="stylesheet" type="text/css" href="producto.css">

<?php  

/////////////////////////////////////////////////////// MOTOR BUSCADOR //////////////////////////////////////////////////////////

	function busqueda($buscar){

		try{

			$bdd=new PDO("mysql:host=localhost; dbname=digusti", "root", ""); //conexion a la base de datos

			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql="SELECT * FROM PRODUCTOS WHERE NOMBRE LIKE ?";

			$bdd->exec("SET CHARACTER SET utf8");

			$query=$bdd->prepare($sql);

			$query->execute(array("%$buscar%"));

			$contador=0;


			while($tabla=$query->fetch(PDO::FETCH_ASSOC)){

				global $contador;

				$contador++;

				echo ("<div class='pro'>");
				echo ("<img src='" . $tabla["Imagen"] ."'>");
				echo ("<div class='descripcion'> 
					<p>" . $tabla['Nombre'] . "</p>
					<p class='precio'>" . $tabla['Precio'] . "<span> Bs</span>");//</p>");

				if($tabla["Categoria"]!="Bodega"){
					echo "<font size='2' style='color:black;'> x Kg</font>";
				}
				else{
					echo "<font size='2' style='color:black;'> x Und</font>";	
				}
				echo "</p>";

				if(isset($_SESSION["tipo"])){

					echo ("<input id=" . $tabla["Codigo"] . " class='cantidad' type='number' name='cantidad' value='1' min='1'><font size='2'>.und</font>
					<input id=" . $tabla["Codigo"] . " class='car' type='button' name='carrito' value='Carrito'>
					</div>
					</div>");
				}else{

					echo "</div></div>";
				}


			}

			if($contador==0){

				echo "<p class='error'>No se ha encontrado el producto</p>";

			}

		$query->closeCursor();

		}catch(Exception $e){

			die('Error: ' . $e->GetMessage());

		}finally{

			$bdd=NULL;
		}
	}

//////////////////////////////////////////////////// PAGINAS DE PRODUCTO ////////////////////////////////////////////////////


	function producto($producto){


		try{

			$bdd=new PDO("mysql:host=localhost; dbname=digusti", "root", ""); //conexion a la base de datos

			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql="SELECT * FROM PRODUCTOS WHERE CATEGORIA= :pro";

			$bdd->exec("SET CHARACTER SET utf8");

			$query=$bdd->prepare($sql);

			$query->execute(array(":pro"=>$producto));

			$contador=0;

			while($tabla=$query->fetch(PDO::FETCH_ASSOC)){

				global $contador;

				$contador++;

				echo ("<div class='pro'>
					<img src='" . $tabla["Imagen"] . "'>
					<div class='descripcion'> 
					<p>" . $tabla['Nombre'] . "</p>
					<p class='precio'>" . $tabla['Precio'] . "<span> Bs</span>");//</p>");

				if($tabla["Categoria"]!="Bodega"){
					echo "<font size='2' style='color:black;'> x Kg</font>";
				}
				else{
					echo "<font size='2' style='color:black;'> x Und</font>";	
				}
				echo "</p>";
					
				if(isset($_SESSION["tipo"])){

					echo ("<input id=" . $tabla["Codigo"] . " class='cantidad' type='number' name='cantidad' value='1' min='1'><font size='2'>.und</font>
					<input id=" . $tabla["Codigo"] . " class='car' type='button' name='carrito' value='Carrito'>
					</div>
					</div>");
				}else{

					echo "</div></div>";
				}

			}

		}catch(Exception $e){

			die('Error: ' . $e->GetMessage());

		}finally{

			$bdd=NULL;
		}
	}
?>