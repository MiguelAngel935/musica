include("../controller/session.php");
include ("../errores.php");
set_error_handler("errores");

$fecha1=$_POST['date1'];
$fecha2=$_POST['date2'];

$select="select * from Invoice where CustomerId=(select CustomerId from Customer 
          where FirstName=".$login_session." and InvoiceDate between ".$fecha1." and ".$fecha2.";";
		
		$resultado = mysqli_query($db, $select);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
      echo "<table>";
      echo "<th>";
      echo "<td>ID</td><td>ID Cliente</td><td>Fecha</td><td>Direccion Fac</td>
            <td>Ciudad Fac</td><td>Estado Fac</td><td>Pais Fac</td>
            <td>Codigo Postal Fac</td><td>Total</td>";
      echo "</th>";
			while($fila = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
        echo "<td>".$fila['InvoiceId']."</td><td>".$fila['CustomerId']."</td><td>".$fila['InvoiceDate']."</td>
              <td>".$fila['BillingAddress']."</td><td>".$fila['BillingCity']."</td><td>".$fila['BillingState']."</td>
              <td>".$fila['BillingCountry']."</td><td>".$fila['BillingPostalCode']."</td><td>".$fila['Total']."</td>";
        echo "</tr>";
			}
      echo "</table>";
		}
