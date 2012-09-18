<?php
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) 
  {
    echo '<br><br/><div id="wrapper"><p class="login">Please <a href="../forms/login.php">log in</a> to access this page.</p></div>';
?> 
    <br/><br/><br/><br/><br/><br/><br/><br/>
<?php
	include('../includes/html/footer.html');
    exit();
  }
?>
