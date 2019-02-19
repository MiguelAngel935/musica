<?php
include("../controller/session.php");
include ("../errores.php");
set_error_handler("errores");

$fecha1=$_POST['date1'];
$fecha2=$_POST['date2'];

//select que muestra los datos de la tabla Invoice del usuario conectado comprendidos entre 2 fechas
$select="select * from Invoice where CustomerId=(select CustomerId from Customer 
          where FirstName='".$login_session."') and (InvoiceDate between '".$fecha1."' and '".$fecha2."');";
		
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
			echo "No se encontraron factiras entre las fechas indicadas";
		}
?>