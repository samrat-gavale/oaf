<?php # Script- mysqlcon.inc.php

/* 
   This file contains the database access information 
   establishes a connectionto MySQLand selects the database.
*/

// Set the database access information as constants:
DEFINE ('DB_USER_PERM', 'root');
 DEFINE ('DB_PASSWORD_PERM', '******');
 DEFINE ('DB_HOST_PERM', 'localhost');
 DEFINE ('DB_NAME_PERM', 'Faculty_Permanent');

// Make the connection:
 $dbcon_perm = @mysqli_connect (DB_HOST_PERM, DB_USER_PERM, DB_PASSWORD_PERM, DB_NAME_PERM)
 OR
 die ('Could not connect to MySQL: '.mysqli_connect_error() );
?>
