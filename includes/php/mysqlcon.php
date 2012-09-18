<?php # Script- mysqlcon.php

/* 
   This file contains the database access information 
   establishes a connectionto MySQL and selects the database.
*/

// Set the database access information as constants:
 DEFINE ('DB_USER', 'root');
 DEFINE ('DB_PASSWORD', 'sbgCSE!!');
 DEFINE ('DB_HOST', 'localhost');
 DEFINE ('DB_NAME', 'Faculty_Temporary');

// Make the connection:
 $dbcon = @mysqli_connect (DB_HOST, DB_USER,DB_PASSWORD, DB_NAME)
 OR
 die ('Could not connect to MySQL: '.mysqli_connect_error() );
?>
