<?php
   include('../controller/session.php');
?>
<html>
   
   <head>
      <title></title>
   </head>
   
   <body>
		<form name="formulario" action="downmusic_modelo.php" method="post">
		  Selecciona la categoria<select name="cat">
									<?php
									set_error_handler("errores");
									
									$select="select TrackId,Name from track;";
									$resultado = mysqli_query($db, $select);

									if ($resultado && mysqli_num_rows($resultado) > 0) {
									
										while($fila = mysqli_fetch_assoc($resultado)) {
											echo "<option value='".$fila['TrackId']."'>".$fila['TrackId']." - ".$fila['Name']."</option>";
										}
										
									}
						
								  echo "</select><br><br>";
		?>
				<input type='checkbox' name= 'seguir'> Seguir comprando
		<br><br>
		 <input type="submit" value="Comprar">
		 <input type="reset" value="Cancelar compra">
		 </form>
		  <h2><a href = "../controller/logout.php">Cerrar Sesion</a></h2>
		
   </body>
   
</html>