<?php
function getAge( $p_strDate )
{
    list($Y,$m,$d)    = explode("-",$p_strDate);
    $years            = date("Y") - $Y;
    
    if( date("md") < $m.$d ) { $years--; }
    return $years;
}

function toNumeric( $month )
{
		 if($month == "Jan")		return 1;
	else if($month == "Feb")		return 2;
	else if($month == "Mar")		return 3;
	else if($month == "Apr")		return 4;
	else if($month == "May")		return 5;
	else if($month == "June")		return 6;
	else if($month == "July")		return 7;
	else if($month == "Aug")		return 8;
	else if($month == "Sept")		return 9;
	else if($month == "Oct")		return 10;
	else if($month == "Nov")		return 11;
	else if($month == "Dec")		return 12;
	else 							return 0;
}

function getDuration( $period_from, $period_to )
{
    list($fm,$fy)    = explode(" ",$period_from);
    list($tm,$ty)    = explode(" ",$period_to);
    $years           = $ty - $fy;
    $months          = toNumeric($tm) - toNumeric($fm);
  
    if( $months < 0 )
    {
		$years--;
		$months = $months+12;
	 }
		 
	 if($years<0 or ( $years == 0 && $months == 0 ) )
		return "Invalid!";
	 else
	    return "$years years, $months months";
}

function valid_email($email) 
{
  $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
  if ( !preg_match($regexp, $email) ) 
    return false;
  else
  return true;
}

function valid_pass($passwd)
{
	if (preg_match('/^\w{4,20}$/',$passwd))
	return true;
	else 
	return false;
}

function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

function getScriptName()
{
		$file = $_SERVER["SCRIPT_NAME"];
		$break = Explode('/', $file);
		return $break[count($break) - 1];
}

function changeDirName($dir)
{
		$file = $_SERVER["SCRIPT_NAME"];
		$break = Explode('/', $file);
		$break[count($break)-2] = $dir;
		$new_name = '';
		$new_name .=implode('/',$break);
		return $new_name;
}
?>
