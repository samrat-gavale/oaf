<?php
    $query = "SELECT * FROM Confirmed_Applications WHERE User_ID = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);
    
    if ($row == NULL) 
	  $confirmed = false;
    else if($row['Confirmed'] == "0")
	  $confirmed = false;
	else 
	  $confirmed = true;
?>
