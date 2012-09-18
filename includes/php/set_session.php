<?php
  session_start();
  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) 
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) 
    {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
	  $user_id = $_SESSION['user_id'];
    }
  }
  else
  {
	///--------------Check if the user has confirmed his application--------------------------///
	require_once('../includes/php/mysqlcon.php');
	$user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM Confirmed_Applications WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);
    
    if ($row == NULL) 
	  $confirmed = false;
    else if($row['Confirmed'] == "0")
	  $confirmed = false;
	else 
	  $confirmed = true;
  }
?>
