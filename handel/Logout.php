<?php 
session_start() ;
 if (! isset($_SESSION['user_id'])) { header("location:Login.php");} 

unset($_SESSION['user_id']) ;

header("location:../Login.php") ;