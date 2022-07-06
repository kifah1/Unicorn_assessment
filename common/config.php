<?php 

   $host     = "localhost"; 
   $database = "mydatabase";
   $user     = "root";
   $password = "";
   
   $db  = new Db($host,$user,$password,$database);
   
   $GLOBALS['DB'] = $db;
   
   $user     = "";
   $password = "";

?>
