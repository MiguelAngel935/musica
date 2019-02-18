<?php
// include("../controller/session.php");
include ("../errores.php");
set_error_handler("errores");

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
function llamada(){
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
}
function finalizarcompra(){
	$where=null;
	if(isset($_COOKIE['cookie'])){
		for ($i=0; $i<count($_COOKIE['cookie']); $i++){
		if($i=0;){
			$where=" TrackId=".$_COOKIE['cookie'][$i];
		}else{
			$where=$where." or TrackId=".$_COOKIE['cookie'][$i];
		}
	}
		$select="select sum(UnitPrice) from track where".$where.";";
		
		$resultado = mysqli_query($db, $select);

		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($fila = mysqli_fetch_assoc($resultado)) {
				$precio=$fila['sum(UnitPrice)'];
			}
		}
		
		
		$invoice="insert into invoice(InvoiceId,CustomerId,InvoiceDate,BillingCity,BillingState,BillingCountry,BillingPostalCode,Total)
		values(select max(InvoiceId)+1 from invoice, select CustomerId from customer where FirstName='".$login_session."',
		".date('Y-m-d')."), select customer.City from customer where FirstName='".$login_session."', select customer.State from customer where FirstName='".$login_session."', 
		select customer.Country from customer where FirstName='".$login_session."', select customer.PostalCode from customer where FirstName='".$login_session."',".$precio.";";
		
		$resultado_invoice = mysqli_query($db, $invoice);

		if ($resultado_upd && $resultado_in){
			echo "";
			mysqli_commit($db);
		}
		
		for ($i=0; $i<count($_COOKIE['cookie']); $i++){
			$invoiceline="insert into invoiceline(InvoiceLineId,InvoiceId,TrackId,UnitPrice,Quantity) values(select max(InvoiceLineId)+1 from invoiceline,
			select InvoiceId from invoice where InvoiceId=(select InvoiceId from customer where CustomerId=(select CustomerId from customer where FirstName='".$login_session."'))
			,".$_COOKIE['cookie'][$i].",select UnitPrice from track where TrackId=".$_COOKIE['cookie'][$i].",1);";
			
			$resultado_invoiceline = mysqli_query($db, $invoiceline);

			if ($resultado_upd && $resultado_in){
				echo "";
				mysqli_commit($db);
			}
		}
	}else{
		echo "Selecciona al menos una cancion para comprar";
	}

}
 require_once('../view/downmusic.php');
?>