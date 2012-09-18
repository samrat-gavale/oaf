<?php
    include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	$error_msg = "";
	if (isset($_POST['submit'])) 
   {
    // Grab the data from the POST
    $organisation = mysqli_real_escape_string($dbcon, trim($_POST['Organisation']));
    $designation = mysqli_real_escape_string($dbcon, trim($_POST['Designation']));
    $from_month = $_POST['From_Month'];
    $from_year = $_POST['From_Year'];
    $to_month = $_POST['To_Month'];
    $to_year = $_POST['To_Year'];
	$mon_salary = mysqli_real_escape_string($dbcon, trim($_POST['Monthly_Salary']));
    $nature_of_duties = mysqli_real_escape_string($dbcon, trim($_POST['Nature_Of_Duties']));
    $from = $from_month.' '.$from_year;
    $to = $to_month.' '.$to_year;
    $period = getDuration($from, $to);
    $error = false;

    // Insert data in the database
    if (!$error)
    {
      if (!empty($organisation) && !empty($designation) && !empty($nature_of_duties) && $period !="Invalid!" && !empty($mon_salary))
      {
			 $query = "SELECT Sr_No from Industrial_Experience WHERE User_ID =  '$user_id'";
			 $data = mysqli_query($dbcon, $query);
			 $rows = mysqli_num_rows($data);
			 //Check if maximum limit is reached
			 if($rows<MAX_INDUS_EXP)
			 {
				//Insert a row in table Sr_No is set to 0 since it is auto incremented
				$query = "INSERT INTO Industrial_Experience VALUES(0, '$user_id', '$organisation','$designation', ".
					  "'$from', '$to','$period', '$mon_salary', '$nature_of_duties') ";
				mysqli_query($dbcon, $query);
				if($rows == 0)
				{
					$query = "UPDATE Forms_Submitted SET Industrial_Experience = 1 WHERE User_ID = '$user_id'";
					mysqli_query($dbcon, $query) or
					trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
				}
				// Navigate to Teaching Experience		  
				$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
				echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
				mysqli_close($dbcon);
				exit();
             }
			 else
			 {
				 $error_msg =  "You have already entered the maximum number of qualifications! You can delete other records and then add new ones.";
			 }
      }
      else
      {
        $error_msg =  "Please enter all the data.";
      }
    }
 } // End of check for form submission

?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn1">
<p class="texta">Industrial Experience</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<form name="industrial_exp" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset class="fieldset">
 <table>
	 <tr>
		 <td class="labelcell"><label for="Organisation" >Organisation</label></td>
		 <td class="fieldcell"><input type="text"  id="organisation" name="Organisation" size = "25" maxlength="50" value="<?php if (isset($_POST['Organisation'])) echo $_POST['Organisation']; ?>"/></td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="Designation" >Designation</label></td>
		 <td class="fieldcell"><input type="text"  id="designation" name="Designation" size = "25" maxlength="30" value="<?php if (isset($_POST['Designation'])) echo $_POST['Designation']; ?>"/></td>
	 </tr>
	 <tr>
		<td class="labelcell"><label for="From">From</label></td>
		<td class="fieldcell"><select name="From_Month"> 
									<option value="Jan" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Jan")) echo "selected"; ?> > Jan </option>
									<option value="Feb" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Feb")) echo "selected"; ?> > Feb </option>
									<option value="Mar" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Mar")) echo "selected"; ?> > Mar </option>
									<option value="Apr" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Apr")) echo "selected"; ?> > Apr </option>
									<option value="May" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "May")) echo "selected"; ?> > May </option>
									<option value="June" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "June")) echo "selected"; ?> > June </option>
									<option value="July" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "July")) echo "selected"; ?> > July </option>
									<option value="Aug" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Aug")) echo "selected"; ?> > Aug </option>
									<option value="Sept" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Sept")) echo "selected"; ?> > Sept </option>
									<option value="Oct" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Oct")) echo "selected"; ?> > Oct </option>
									<option value="Nov" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Nov")) echo "selected"; ?> > Nov </option>
									<option value="Dec" <?php if ((isset($_POST['From_Month']) && $_POST['From_Month'] == "Dec")) echo "selected"; ?> > Dec </option>
								</select>
								<select name="From_Year">
									<option value="1960" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1960")) echo "selected"; ?> >1960</option>
									<option value="1961" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1961")) echo "selected"; ?> >1961</option>
									<option value="1962" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1962")) echo "selected"; ?> >1962</option>
									<option value="1963" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1963")) echo "selected"; ?> >1963</option>
									<option value="1964" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1964")) echo "selected"; ?> >1964</option>
									<option value="1965" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1965")) echo "selected"; ?> >1965</option>
									<option value="1966" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1966")) echo "selected"; ?> >1966</option>
									<option value="1967" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1967")) echo "selected"; ?> >1967</option>
									<option value="1968" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1968")) echo "selected"; ?> >1968</option>
									<option value="1969" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1969")) echo "selected"; ?> >1969</option>
									<option value="1970" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1970")) echo "selected"; ?> >1970</option>
									<option value="1971" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1971")) echo "selected"; ?> >1971</option>
									<option value="1972" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1972")) echo "selected"; ?> >1972</option>
									<option value="1973" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1973")) echo "selected"; ?> >1973</option>
									<option value="1974" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1974")) echo "selected"; ?> >1974</option>
									<option value="1975" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1975")) echo "selected"; ?> >1975</option>
									<option value="1976" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1976")) echo "selected"; ?> >1976</option>
									<option value="1977" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1977")) echo "selected"; ?> >1977</option>
									<option value="1978" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1978")) echo "selected"; ?> >1978</option>
									<option value="1979" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1979")) echo "selected"; ?> >1979</option>
									<option value="1980" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1980")) echo "selected"; ?> >1980</option>
									<option value="1981" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1981")) echo "selected"; ?> >1981</option>
									<option value="1982" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1982")) echo "selected"; ?> >1982</option>
									<option value="1983" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1983")) echo "selected"; ?> >1983</option>
									<option value="1984" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1984")) echo "selected"; ?> >1984</option>
									<option value="1985" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1985")) echo "selected"; ?> >1985</option>
									<option value="1986" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1986")) echo "selected"; ?> >1986</option>
									<option value="1987" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1987")) echo "selected"; ?> >1987</option>
									<option value="1988" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1988")) echo "selected"; ?> >1988</option>
									<option value="1989" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1989")) echo "selected"; ?> >1989</option>
									<option value="1990" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1990")) echo "selected"; ?> >1990</option>
									<option value="1991" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1991")) echo "selected"; ?> >1991</option>
									<option value="1992" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1992")) echo "selected"; ?> >1992</option>
									<option value="1993" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1993")) echo "selected"; ?> >1993</option>
									<option value="1994" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1994")) echo "selected"; ?> >1994</option>
									<option value="1995" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1995")) echo "selected"; ?> >1995</option>
									<option value="1996" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1996")) echo "selected"; ?> >1996</option>
									<option value="1997" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1997")) echo "selected"; ?> >1997</option>
									<option value="1998" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1998")) echo "selected"; ?> >1998</option>
									<option value="1999" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "1999")) echo "selected"; ?> >1999</option>
									<option value="2000" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2000")) echo "selected"; ?> >2000</option>
									<option value="2001" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2001")) echo "selected"; ?> >2001</option>
									<option value="2002" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2002")) echo "selected"; ?> >2002</option>
									<option value="2003" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2003")) echo "selected"; ?> >2003</option>
									<option value="2004" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2004")) echo "selected"; ?> >2004</option>
									<option value="2005" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2005")) echo "selected"; ?> >2005</option>
									<option value="2006" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2006")) echo "selected"; ?> >2006</option>
									<option value="2007" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2007")) echo "selected"; ?> >2007</option>
									<option value="2008" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2008")) echo "selected"; ?> >2008</option>
									<option value="2009" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2009")) echo "selected"; ?> >2009</option>
									<option value="2010" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2010")) echo "selected"; ?> >2010</option>
									<option value="2011" <?php if ((isset($_POST['From_Year']) && $_POST['From_Year'] == "2011")) echo "selected"; ?> >2011</option>
							</select>
		</td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="To">To</label></td>
		 <td class="fieldcell"><select name="To_Month"> 
									<option value="Jan" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Jan")) echo "selected"; ?> > Jan </option>
									<option value="Feb" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Feb")) echo "selected"; ?> > Feb </option>
									<option value="Mar" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Mar")) echo "selected"; ?> > Mar </option>
									<option value="Apr" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Apr")) echo "selected"; ?> > Apr </option>
									<option value="May" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "May")) echo "selected"; ?> > May </option>
									<option value="June" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "June")) echo "selected"; ?> > June </option>
									<option value="July" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "July")) echo "selected"; ?> > July </option>
									<option value="Aug" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Aug")) echo "selected"; ?> > Aug </option>
									<option value="Sept" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Sept")) echo "selected"; ?> > Sept </option>
									<option value="Oct" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Oct")) echo "selected"; ?> > Oct </option>
									<option value="Nov" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Nov")) echo "selected"; ?> > Nov </option>
									<option value="Dec" <?php if ((isset($_POST['To_Month']) && $_POST['To_Month'] == "Dec")) echo "selected"; ?> > Dec </option>
								</select>
								<select name="To_Year">
									<option value="1960" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1960")) echo "selected"; ?> >1960</option>
									<option value="1961" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1961")) echo "selected"; ?> >1961</option>
									<option value="1962" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1962")) echo "selected"; ?> >1962</option>
									<option value="1963" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1963")) echo "selected"; ?> >1963</option>
									<option value="1964" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1964")) echo "selected"; ?> >1964</option>
									<option value="1965" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1965")) echo "selected"; ?> >1965</option>
									<option value="1966" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1966")) echo "selected"; ?> >1966</option>
									<option value="1967" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1967")) echo "selected"; ?> >1967</option>
									<option value="1968" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1968")) echo "selected"; ?> >1968</option>
									<option value="1969" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1969")) echo "selected"; ?> >1969</option>
									<option value="1970" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1970")) echo "selected"; ?> >1970</option>
									<option value="1971" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1971")) echo "selected"; ?> >1971</option>
									<option value="1972" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1972")) echo "selected"; ?> >1972</option>
									<option value="1973" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1973")) echo "selected"; ?> >1973</option>
									<option value="1974" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1974")) echo "selected"; ?> >1974</option>
									<option value="1975" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1975")) echo "selected"; ?> >1975</option>
									<option value="1976" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1976")) echo "selected"; ?> >1976</option>
									<option value="1977" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1977")) echo "selected"; ?> >1977</option>
									<option value="1978" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1978")) echo "selected"; ?> >1978</option>
									<option value="1979" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1979")) echo "selected"; ?> >1979</option>
									<option value="1980" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1980")) echo "selected"; ?> >1980</option>
									<option value="1981" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1981")) echo "selected"; ?> >1981</option>
									<option value="1982" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1982")) echo "selected"; ?> >1982</option>
									<option value="1983" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1983")) echo "selected"; ?> >1983</option>
									<option value="1984" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1984")) echo "selected"; ?> >1984</option>
									<option value="1985" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1985")) echo "selected"; ?> >1985</option>
									<option value="1986" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1986")) echo "selected"; ?> >1986</option>
									<option value="1987" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1987")) echo "selected"; ?> >1987</option>
									<option value="1988" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1988")) echo "selected"; ?> >1988</option>
									<option value="1989" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1989")) echo "selected"; ?> >1989</option>
									<option value="1990" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1990")) echo "selected"; ?> >1990</option>
									<option value="1991" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1991")) echo "selected"; ?> >1991</option>
									<option value="1992" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1992")) echo "selected"; ?> >1992</option>
									<option value="1993" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1993")) echo "selected"; ?> >1993</option>
									<option value="1994" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1994")) echo "selected"; ?> >1994</option>
									<option value="1995" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1995")) echo "selected"; ?> >1995</option>
									<option value="1996" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1996")) echo "selected"; ?> >1996</option>
									<option value="1997" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1997")) echo "selected"; ?> >1997</option>
									<option value="1998" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1998")) echo "selected"; ?> >1998</option>
									<option value="1999" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "1999")) echo "selected"; ?> >1999</option>
									<option value="2000" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2000")) echo "selected"; ?> >2000</option>
									<option value="2001" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2001")) echo "selected"; ?> >2001</option>
									<option value="2002" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2002")) echo "selected"; ?> >2002</option>
									<option value="2003" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2003")) echo "selected"; ?> >2003</option>
									<option value="2004" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2004")) echo "selected"; ?> >2004</option>
									<option value="2005" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2005")) echo "selected"; ?> >2005</option>
									<option value="2006" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2006")) echo "selected"; ?> >2006</option>
									<option value="2007" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2007")) echo "selected"; ?> >2007</option>
									<option value="2008" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2008")) echo "selected"; ?> >2008</option>
									<option value="2009" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2009")) echo "selected"; ?> >2009</option>
									<option value="2010" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2010")) echo "selected"; ?> >2010</option>
									<option value="2011" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2011")) echo "selected"; ?> >2011</option>
									<option value="2012" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2012")) echo "selected"; ?> >2012</option>
									<option value="2013" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2013")) echo "selected"; ?> >2013</option>
									<option value="2014" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2014")) echo "selected"; ?> >2014</option>
									<option value="2015" <?php if ((isset($_POST['To_Year']) && $_POST['To_Year'] == "2015")) echo "selected"; ?> >2015</option>
							</select>
		</td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="monthly_salary">Monthly Salary</label><br class="nobr"></td>
		 <td class="fieldcell"><input type="text" id="monthly_salary" name="Monthly_Salary" size = "25" maxlength="25"
								value="<?php if (isset($_POST['Monthly_Salary'])) echo $_POST['Monthly_Salary']; ?>"/></td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="period">Nature of Duties</label><br class="nobr"></td>
		 <td class="fieldcell"><input type="text" id="nature_of_duties" name="Nature_Of_Duties" size = "25" maxlength="200"
								value="<?php if (isset($_POST['Nature_Of_Duties'])) echo $_POST['Nature_Of_Duties']; ?>"/></td>
	 </tr>
	 <tr>    
     	 <td class="button"><input type="submit" name="submit" value="Add record" size = "15" <?php if($confirmed) echo "disabled"; ?>/></td>   

		<?php $cancel_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user'); ?>
		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $cancel_url; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
         </tr>
 </table>
 </fieldset>
 </form>
				<?php
					include($includes_path.'/js/form_validators/industrial_exp.js');
				?>
    
<div id="navbuttons">
			<input type="button" value="Back" onclick="parent.location.href = '../index.php'" size = "15" />
			<input type="button" value="Next" onclick="parent.location.href = '../user/research_papers.php'" size = "15" />
</div>

</div>
</div>
</div>
<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>
<div id="rightcolumn1">
<div id="help">
<h3>Note</h3>
<ul>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>Maximum allowed entries is <i>5</i>.</li>
<li>You can include your <i>Corporate Service</i> experience in <i>Industrial Experience</i>.</li>
</ul>
</div>
</div>



</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>

