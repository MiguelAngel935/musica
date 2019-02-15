<?php
   include('../controller/session.php');
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenide <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
    <li><a href="downmusic.php">Comprar musica</a></li>
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "../controller/logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>