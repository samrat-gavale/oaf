<?php # Script- mysqlcon.inc.php

/* 
   This file contains the database access information 
   establishes a connectionto MySQLand selects the database.
*/

// Set the database access information as constants:
DEFINE ('DB_USER_PERM', '<username>');
 DEFINE ('DB_PASSWORD_PERM', '<password>');
 DEFINE ('DB_HOST_PERM', '<host>');
 DEFINE ('DB_NAME_PERM', '<name>');

// Make the connection:
 $dbcon_perm = @mysqli_connect (DB_HOST_PERM, DB_USER_PERM, DB_PASSWORD_PERM, DB_NAME_PERM)
 OR
 die ('Could not connect to MySQL: '.mysqli_connect_error() );
?>
