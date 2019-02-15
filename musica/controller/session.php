<?php
   include('../db/config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select FirstName from customer where Email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['FirstName'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:../view/login.php");
      die();
   }
?>