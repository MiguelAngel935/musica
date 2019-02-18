
<?php
   include('../controller/session.php');
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenide <?php echo $login_session; ?></h1> 
	  
	  <form name="fechas" action="../model/facturas_model.php" method="post">
	      Introduzca la primera fecha: <input type="text" name="date1" placeholder="yyyy-mm-dd"> <br/>
	      Introduzca la segunda fecha: <input type="text" name="date2" placeholder="yyyy-mm-dd"> <br/>
        
        <br/><br/><input type="submit" value="Buscar">
    </form>
   </body>
   
</html>
