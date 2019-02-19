<?php

include ("../errores.php");
set_error_handler("errores");

//Comprobamos que action manda la vista para dirigirlo a la funcion adecuada
$option=null;
if (isset($_GET['action'])) $option=$_GET['action'];
switch ($option){
	case "llamada";
		llamada();
		break;
	case "finalizar";
		finalizarcompra();
		break;
	default;
		break;
}
function llamada(){ //Creamos una cookie y guardamos las canciones compradas en ella
$idcancion=$_POST['cancion'];
	if(isset($_COOKIE['cookie'])){
		$listacanciones=unserialize($_COOKIE['cookie']);
		$listacanciones[]=$idcancion;
	}else{
		$listacanciones=array();
		$listacanciones[]=$idcancion;
	}
	setcookie('cookie', serialize($listacanciones), time()+3600);
	var_dump($listacanciones);
	echo "<br/><br/><a href='../view/welcome.php'>Volver</a>";
}
function finalizarcompra(){ //Finalizamos los datos e insertamos en la base de datos todas las canciones compradas
include('../controller/session.php');
	$funciona=true;
	$where=null;
	$precio=0;
	
	//Recorremos la cookie y concatenamos el where necesario para hacer la select
	if(isset($_COOKIE['cookie'])){
		for ($i=0; $i<count($_COOKIE['cookie']); $i++){
		if($i=0){
			$where=" TrackId=".$_COOKIE['cookie'][$i];
		}else{
			$where=$where." or TrackId=".$_COOKIE['cookie'][$i];
		}
	}
		//Recogemos la suma del precio de todas las canciones que ha comprado el usuario
		$select="select sum(UnitPrice) from track where".$where.";";
		
		$resultado = mysqli_query($db, $select);

		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($fila = mysqli_fetch_assoc($resultado)) {
				$precio=$fila['sum(UnitPrice)'];
			}
		}
		
		//Insertamos el pedido en la tabla Invoice
		$invoice="insert into Invoice(InvoiceId,CustomerId,InvoiceDate,BillingCity,BillingState,BillingCountry,BillingPostalCode,Total)
		values ((select max(InvoiceId)+1 from invoice), (select CustomerId from customer where FirstName='".$login_session."',
		".date('Y-m-d')."), (select customer.City from customer where FirstName='".$login_session."'), (select customer.State from customer where FirstName='".$login_session."'), 
		(select customer.Country from customer where FirstName='".$login_session."'), (select customer.PostalCode from customer where FirstName='".$login_session."'),".$precio.");";
		
		$resultado_invoice = mysqli_query($db, $invoice);

		//Insertamos cada cancion del pedido en la tabla InvoiceLine
		for ($i=0; $i<count($_COOKIE['cookie']); $i++){
			$invoiceline="insert into invoiceline(InvoiceLineId,InvoiceId,TrackId,UnitPrice,Quantity) values((select max(InvoiceLineId)+1 from invoiceline),
			(select InvoiceId from invoice where InvoiceId=(select InvoiceId from customer where CustomerId=(select CustomerId from customer where FirstName='".$login_session."')))
			,".$_COOKIE['cookie'][$i].",(select UnitPrice from track where TrackId=".$_COOKIE['cookie'][$i]."),1);";
			
			$resultado_invoiceline = mysqli_query($db, $invoiceline);

			if (!$resultado_invoiceline){
				$funciona=false;
			}
		}
		//Si ambos insert funciona nos redirecciona aotro documento para que el usuario no pueda seguir usando el mismo pedido
		if ($resultado_invoice && $funciona){
				setcookie("cookie", "", time()-3600);
				mysqli_commit($db);
				header("Location:../view/compra_correcta.php");
			}else{
				echo "Hubo un error y no se realizo la compra";
				echo "<br/><br/><a href='../view/welcome.php'>Volver</a>";
			}
			
	}else{
		echo "Selecciona al menos una cancion para comprar";
	}

}
 require_once('../view/downmusic.php');
?>