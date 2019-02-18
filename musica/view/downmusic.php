<?php
   include('../controller/session.php');
?>
<html>
   
   <head>
      <title></title>
   </head>
   
   <body>
		<form name="formulario" action="../model/downmusic_modelo.php?action=llamada" method="post">
		  Selecciona la categoria<select name="cancion">
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
				
		<br><br>
		 <input type="submit" value="Comprar">
		 </form>
		 <form name="formulario2" action="../model/downmusic_modelo.php" method="post">
		 
			<input type="submit" value="Finalizar compra">
		 </form>
		  <h2><a href = "../controller/logout.php">Cerrar Sesion</a></h2>
		
   </body>
   
</html>