<?php
include("../controller/session.php");
include ("../errores.php");
set_error_handler("errores");

//Select que muestra los datos de la tabla Invoice del usuario conectado
$select="select * from Invoice where CustomerId=(select CustomerId from Customer where FirstName='".$login_session."');";
		
		//Comprobamos que hay datos y creamos una tabla para mostrarlos
		$resultado = mysqli_query($db, $select);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
      echo "<table border='1'>";
      echo "<tr>";
      echo "<th>ID</th><th>ID Cliente</th><th>Fecha</th><th>Direccion Fac</th>
            <th>Ciudad Fac</th><th>Estado Fac</th><th>Pais Fac</th>
            <th>Codigo Postal Fac</th><th>Total</th>";
      echo "</tr>";
			while($fila = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
        echo "<td>".$fila['InvoiceId']."</td><td>".$fila['CustomerId']."</td><td>".$fila['InvoiceDate']."</td>
              <td>".$fila['BillingAddress']."</td><td>".$fila['BillingCity']."</td><td>".$fila['BillingState']."</td>
              <td>".$fila['BillingCountry']."</td><td>".$fila['BillingPostalCode']."</td><td>".$fila['Total']."</td>";
        echo "</tr>";
			}
      echo "</table>";
		}else{
			echo "Aun no tiene facturas";
		}
?>