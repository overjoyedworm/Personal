<?php
/*
=====================================================
 ExpressionEngine - by pMachine
-----------------------------------------------------
 http://www.pmachine.com/
-----------------------------------------------------
 Copyright (c) 2003,2004,2005 pMachine, Inc.
=====================================================
 THIS IS COPYRIGHTED SOFTWARE
 PLEASE READ THE LICENSE AGREEMENT
 http://eedocs.pmachine.com/license.html 
=====================================================
 File: wizard.php
-----------------------------------------------------
 Purpose: Server Wizard file
=====================================================
*/

error_reporting(E_ALL);
set_magic_quotes_runtime(0);

$requirements = array('php' 			=>	array(	'item'			=> "PHP Version 4.1 or greater",
										 			'severity'		=> "required",
									 				'supported'		=> 'n'),
									 
					 'mysql'			=>	array(	'item'			=> "MySQL Support in PHP",
					 								'severity'		=> "required",
					 								'supported'		=> 'n'),
					 						
					 'captchas'			=>	array(	'item'			=> "CAPTCHAs feature and watermarking in Image Gallery",
					 								'severity'		=> "suggested",
					 								'supported'		=> 'n'),
					 								
					 'pings'			=>	array(	'item'			=> "Ability to send Pings and Trackbacks",
					 								'severity'		=> "suggested",
					 								'supported'		=> 'n'),
					 						
					 'image_resizing'	=>	array(	'item'			=> "Image Thumbnailing using GD, GD2, Imagemagick or NetPBM",
					 								'severity'		=> "suggested",
					 								'supported'		=> 'n'),
					 						
					 'gif_resizing'		=>	array(	'item'			=> "GIF Image Resizing Using GD (or GD 2)",
					 								'severity'		=> "optional",
					 								'supported'		=> 'n'),
					 
					 'jpg_resizing'		=>	array(	'item'			=> "JPEG Image Resizing Using GD (or GD 2)",
					 								'severity'		=> "optional",
					 								'supported'		=> 'n'),
					 								
					 'png_resizing'		=>	array(	'item'			=> "PNG Image Resizing Using GD (or GD 2)",
					 								'severity'		=> "optional",
					 								'supported'		=> 'n'),
					 								
					 'spellcheck'		=>	array(	'item'			=> "Built in Spellchecker",
					 								'severity'		=> "optional",
					 								'supported'		=> 'n')
				);					 								


if (phpversion() > '4.1.0')
{
	$requirements['php']['supported'] = 'y';
}
if (function_exists('mysql_connect'))
{
	$requirements['mysql']['supported'] = 'y';
}
if (function_exists('imagejpeg'))
{
	$requirements['captchas']['supported'] = 'y';
}
if (function_exists('gd_info') OR function_exists('exec'))
{
	$requirements['image_resizing']['supported'] = 'y';
}
if (function_exists('imagegif'))
{
	$requirements['gif_resizing']['supported'] = 'y';
}
if (function_exists('imagejpeg'))
{
	$requirements['jpg_resizing']['supported'] = 'y';
}
if (function_exists('imagepng'))
{
	$requirements['png_resizing']['supported'] = 'y';
}
if (function_exists('fsockopen') && 
	function_exists('xml_parser_create') &&
	@fsockopen('www.google.com', 80, $errno, $errstr, 2))
{
	$requirements['pings']['supported'] = 'y';
	$requirements['spellcheck']['supported'] = 'y';
}
if (function_exists('pspell_check'))
{
	$requirements['spellcheck']['supported'] = 'y';
} 



// HTML HEADER
page_head();


if ( ! isset($_GET['mysql']))
{
?>
<div id='innercontent'>

<h3>Check Requirements for ExpressionEngine</h3>

<p>Thank you for considering ExpressionEngine. This script will check to see if 
your server and database meet ExpressionEngine's requirements. You will need to 
have a MySQL database created to complete this test. Your web host can help you 
set one up.</p>

<p style="padding-top:15px;"><strong>Step 1: Server Check</strong></p>

<p>The information on this page will tell you if your web host has everything 
you need to run ExpressionEngine. If all the "required" features are "checked" 
then you can run ExpressionEngine. In addition, we recommend that all the 
"suggested" features be present as well in order to use ExpressionEngine to 
its full potential.</p>


<table border="0" cellspacing="0" cellpadding="0" style="width:100%;" class="tableBorder">

<tr>
<td class="tableHeading">Requirement</td>
<td class="tableHeading">Importance</td>
<td class="tableHeading">Supported</td>
<td class="tableHeading">Unsupported</td>
</tr>

<?php

$i = 0;

foreach($requirements as $required)
{
	$style = ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo';
	
	echo "\n<tr><td class='{$style}'><b>".$required['item']."</b></td>\n<td class='{$style}'>";
	
	switch($required['severity'])
	{
		case 'required'		: echo "<strong><span class='red'>required</span></strong>"; break;
		case 'suggested'	: echo "<strong><span class='blue'>suggested</span></strong>"; break;
		case 'optional'		: echo "optional"; break;
	}
		 
	echo "</td>\n<td class='{$style}' align='center'>".
		 (($required['supported'] == "y") ? '<strong><span class="green">X</span></strong>' : '')."</td>\n<td class='{$style}' align='center'>".
		 (($required['supported'] == "n") ? '<strong><span class="red">X</span></strong>' : '')."</td></tr>";	
}
?>

</table>

<p style="padding-top:15px;"><strong>Step 2: Check Database</strong></p>

<p>In addition to checking your web host's server its important to check the MySql database you want to install ExpressionEngine on. You will need the following to check the Database.</p>

<p>MySQL Server address (usually 'localhost')<br />
Database User name<br />
Database Password<br />
Database Name</p>

<p>Please, check with your web host if you are not sure what these settings are and they can assist you further.</p>

<p>If you are satisifed with your server's support and you have your MySQL information, then 
<a href="wizard.php?mysql=check">check your MySQL settings now.</a></b></p>
</div>
<?php
}

// No Server Problems, Yo!
// --------------------------------------------------------------------
// --------------------------------------------------------------------

elseif( ! isset($_GET['mysql']) && sizeof($errors) == 0)
{
?>
<div id='innercontent'>

<h3>You're Good To Go!</h3>

<p><b>There were no server configuration problems found, so everything seems fine so far.</b></p>

<p><b>There is one last thing to check though and that is whether MySQL user is set up correctly and you are able
to connect to your site's database.</b></p>

<p><b>If you would like to proceed and check your MySQL
settings, <a href="wizard.php?mysql=check">click here.</a></b></p>
</div>
<?php
}




// MySQL Configure
// --------------------------------------------------------------------
// --------------------------------------------------------------------


elseif(isset($_GET['mysql']) && $_GET['mysql'] == 'check')
{

	$data = array(
					'db_hostname'			=> 'localhost',
					'db_username'			=> '',
					'db_password'			=> '',
					'db_name'				=> ''
				);



	foreach ($_POST as $key => $val)
	{
		if (isset($data[$key]))
		{
			if ( ! get_magic_quotes_gpc())
			{
				$val = addslashes($val);
			}
			
			$data[$key] = trim($val);	
		}
	}

	$attempt = 'n';
	$mysql_errors = array();
	
	if ($data['db_hostname'] != '' && $data['db_username'] != '' && $data['db_password'] != '' && $data['db_name'] != '')
	{
		$attempt = 'y';
		$conn = mysql_connect($data['db_hostname'], $data['db_username'], $data['db_password']);
		
		if ( ! $conn)
		{
			$mysql_errors[] = 'Unable to connect to your database server';
		}
		else
		{
			if ( ! mysql_select_db($data['db_name'], $conn))
			{
				$mysql_errors[] = 'Unable to select your database';
			}
			else
			{
				$Q = array();
				$Q['create'] = "CREATE TABLE IF NOT EXISTS ee_test (
						ee_id int(2) unsigned NOT NULL auto_increment,
						ee_text char(2) NOT NULL default '',
						PRIMARY KEY (ee_id))";
				$Q['alter'] = "ALTER TABLE ee_test CHANGE COLUMN ee_text ee_text char(3) NOT NULL";
				$Q['insert'] = "INSERT INTO ee_test (ee_id, ee_text) VALUES ('', 'hi')";
				$Q['update'] = "UPDATE ee_test SET ee_id = 'hey'";
				$Q['drop'] = "DROP TABLE IF EXISTS ee_test";
				
				foreach($Q as $type => $sql)
				{
					if ( ! $query = @mysql_query($sql, $conn))
					{
						$mysql_errors[] = "Your MySQL user does not have ".strtoupper($type)." permissions";
					}
				}
			}
		}
	}

	
	if ($attempt == 'y' && sizeof($mysql_errors) == 0)
	{
?>
<div id='innercontent'>
<h3>Congratulations!  Your Server is Ready for ExpressionEngine!</h3>
<p>The MySQL server test was successful.  You MySQL user was able to connect to your database properly and all permission were found
to be correct.  Congratulations, your server is ready for <a href="http://www.pmachine.com/ee/" title="More information about EE">ExpressionEngine</a>!</p>
<br />
<p>If you would like to purchase ExpressionEngine now, then go to the <a href="https://secure.pmachine.com">pMachine Store</a> where you can purchase and download ExpressionEngine in under ten minutes.</p>

</div>
<?php
		return page_footer();
	}
	elseif ($attempt == 'y' && sizeof($mysql_errors > 0))
	{
?>
<div id='innercontent'>

<div class="error">Error:&nbsp;&nbsp;MySQL Server Problems</div>
<ul>
<?php

	foreach($mysql_errors as $crappie)
	{
		echo "\n<li>".$crappie."</li>\n";
	}

?>
</ul>
<?php
	}
?>

<div id='innercontent'>
<h2>Enter Your Database Settings for MySQL</h2>
<form method='post' action='wizard.php?mysql=check'>


<div class="shade">
<h5>MySQL Server Address</h5>
<p>Usually you will use 'localhost', but your hosting provider may require something else</p>

<p><input type='text' name='db_hostname' value='<?php echo $data['db_hostname']; ?>' size='40' maxlength='60' class='input' /></p>


<h5>MySQL Username</h5>
<p>The username you use to access your MySQL database</p>
<p><input type='text' name='db_username' value='<?php echo $data['db_username']; ?>' size='40'  maxlength='60' class='input' /></p>


<h5>MySQL Password</h5>
<p>The password you use to access your MySQL database</p>
<p><input type='text' name='db_password' value='<?php echo $data['db_password']; ?>' size='40'  maxlength='50' class='input' /></p>


<h5>MySQL Database Name</h5>
<p>The name of the database where you want ExpressionEngine installed.</p>
<p class="red">Note: ExpressionEngine's Server Wizard will not create the database for you so you must specify the name of a database that exists.</p>
<p><input type='text' name='db_name' value='<?php echo $data['db_name']; ?>' size='40' maxlength='60' class='input' /></p>

</div>


<p><input type='submit' value=' Click Here to Check MySQL Compatiblity! '  class='submit'></p>

</form>

</div>


<?php
}


// HTML FOOTER

page_footer();





//  HTML HEADER
// --------------------------------------------------------------------
// --------------------------------------------------------------------

function page_head()
{
	global $data;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">

<head>
<title>ExpressionEngine | Server Compatibility Wizard</title>

<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />

<style type='text/css'>


body {
  margin:             0;
  padding:            0;
  font-family:        Verdana, Geneva, Helvetica, Trebuchet MS, Sans-serif;
  font-size:          12px;
  color:              #333;
  background-color:   #8084B2;
  }
  
 
a {
  font-size:          12px;
  text-decoration:    underline;
  font-weight:        bold;
  color:              #330099;
  background-color:   transparent;
  }
  
a:visited {
  color:              #330099;
  background-color:   transparent;
  }

a:active {
  color:              #ccc;
  background-color:   transparent;
  }

a:hover {
  color:              #000;
  text-decoration:    none;
  background-color:   transparent;
  }
  
#content {
background:   #fff;
width:        760px;
margin-top: 25px;
margin-right: auto;
margin-left: auto;
border: 1px solid #000;
}

#innercontent {
margin: 20px 30px 0 20px;
}

#pageheader {  
 background: #696EA4 url(http://www.pmachine.com/themes/cp_global_images/header_bg.jpg) repeat-x left top;
 border-bottom: 1px solid #000;
}
.solidLine { 
  border-top:  #999 1px solid;
}
.rightheader {  
 background-color:  transparent;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         12px;
 font-weight:		bold;
 color:				#fff;
 padding:			0 22px 0 20px;
}


.error {
  font-family:        Verdana, Trebuchet MS, Arial, Sans-serif;
  font-size:          13px;
  margin-bottom:      8px;
  font-weight:        bold;
  color:              #990000;
}

.shade {
  background-color:   #f6f6f6;
  padding: 0 0 10px 22px;
  margin-top: 10px;
  margin-bottom: 20px;
  border:      #7B81A9 1px solid;
}

.stephead {
  font-family:        Arial, Trebuchet MS, Verdana, Sans-serif;
  font-size:          18px;
  font-weight:		  bold;
  color:              #999;
  letter-spacing:     2px;
  margin:      			0;
  background-color:   transparent;
}


.settingHead {
  font-family:        Arial, Trebuchet MS, Verdana, Sans-serif;
  font-size:          18px;
  font-weight:		  bold;
  color:              #990000;
  letter-spacing:     2px;
  margin-top:         10px;
  margin-bottom:      10px;
  background-color:   transparent;
}

h1 {
  font-family:        Verdana, Trebuchet MS, Arial, Sans-serif;
  font-size:          16px;
  font-weight:        bold;
  color:              #5B6082;
  margin-top:         15px;
  margin-bottom:      16px;
  background-color:   transparent;
  border-bottom:      #7B81A9 2px solid;
}

h2 {
  font-family:        Arial, Trebuchet MS, Verdana, Sans-serif;
  font-size:          14px;
  color:              #000;
  letter-spacing:     2px;
  margin-top:         6px;
  margin-bottom:      6px;
  background-color:   transparent;
}
h3 {
  font-family:        Arial, Trebuchet MS, Verdana, Sans-serif;
  font-size:          18px;
  color:              #000;
  letter-spacing:     2px;
  margin-top:         15px;
  margin-bottom:      15px;
  border-bottom:      #7B81A9 1px dashed;
  background-color:   transparent;
}

h4 {
  font-family:        Verdana, Geneva, Trebuchet MS, Arial, Sans-serif;
  font-size:          16px;
  font-weight:        bold;
  color:              #000;
  margin-top:         5px;
  margin-bottom:      14px;
  background-color:   transparent;
}
h5 {
  font-family:        Verdana, Geneva, Trebuchet MS, Arial, Sans-serif;
  font-size:          12px;
  font-weight:        bold;
  color:              #000;
  margin-top:         16px;
  margin-bottom:      0;
  background-color:   transparent;
}

p {
  font-family:        Verdana, Geneva, Trebuchet MS, Arial, Sans-serif;
  font-size:          12px;
  font-weight:        normal;
  color:              #333;
  margin-top:         4px;
  margin-bottom:      8px;
  background-color:   transparent;
}

.botBorder {
  margin-bottom:      8px;
  border-bottom:      #7B81A9 1px dashed;
  background-color:   transparent;
}


li {
  font-family:        Verdana, Trebuchet MS, Arial, Sans-serif;
  font-size:          11px;
  margin-bottom:      4px;
  color:              #000;
  margin-left:		  10px;
}

.pad {
padding:  1px 0 4px 0;
}
.center {
text-align: center;
}
strong {
  font-weight: bold;
}

i {
  font-style: italic;
}
  
.red {
  color:              #990000;
}

.green {
  color:              #009933;
}

.blue {
  color:              #0000FF;
}
 
.copyright {
  text-align:         center;
  font-family:        Verdana, Geneva, Helvetica, Trebuchet MS, Sans-serif;
  font-size:          9px;
  color:              #999999;
  line-height:        15px;
  margin-top:         20px;
  margin-bottom:      15px;
  padding:            20px;
  }
  
.border {
  border-bottom:      #7B81A9 1px dashed;
}


form {
 margin:            0;
 padding:           0;
 border:            0;
}
.hidden {
 margin:            0;
 padding:           0;
 border:            0;
}
.input {
 border-top:        2px solid #979AC2;
 border-left:       2px solid #979AC2;
 border-bottom:     1px solid #979AC2;
 border-right:      1px solid #979AC2;
 color:             #333;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         11px;
 height:            1.7em;
 padding:           0;
 margin:        	0;
} 
.textarea {
 border-top:        2px solid #979AC2;
 border-left:       2px solid #979AC2;
 border-bottom:     1px solid #979AC2;
 border-right:      1px solid #979AC2;
 color:             #333;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         11px;
 padding:           0;
 margin:        	0;
}
.select {
 background-color:  #fff;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         11px;
 font-weight:       normal;
 letter-spacing:    .1em;
 color:             #333;
 margin-top:        2px;
 margin-bottom:     2px;
} 
.multiselect {
 border-top:        2px solid #979AC2;
 border-left:       2px solid #979AC2;
 border-bottom:     1px solid #979AC2;
 border-right:      1px solid #979AC2;
 background-color:  #fff;
 color:             #333;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         11px;
 margin-top:        2px;
 margin-top:        2px;
} 
.radio {
 color:             transparent;
 background-color:  transparent;
 margin-top:        4px;
 margin-bottom:     4px;
 padding:           0;
 border:            0;
}
.checkbox {
 background-color:  transparent;
 color:				transparent;
 padding:           0;
 border:            0;
}
.submit {
 background-color:  #fff;
 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
 font-size:         11px;
 font-weight:       normal;
 border-top:		1px solid #989AB6;
 border-left:		1px solid #989AB6;
 border-right:		1px solid #434777;
 border-bottom:		1px solid #434777;
 letter-spacing:    .1em;
 padding:           1px 3px 2px 3px;
 margin:        	0;
 background-color:  #6C73B4;
 color:             #fff;
}  

.tableBorder {
 border-left:      1px solid #B1B6D2;
 border-right:     1px solid #B1B6D2;
 margin:		   12px 0 12px 0;
 padding:			0;
}

.tableHeading {
 font-family:       Lucida Grande, Verdana, Geneva, Sans-serif;
 font-size:         11px;
 font-weight:       bold;
 color:             #fff;
 padding:           5px 6px 5px 6px;
 background-color: 	#6E73A5;
 border-top:        1px solid #696E9E;
 border-bottom:     1px solid #535782;
 margin-bottom:		1px;
}

.tableCellOne, .tableCellOneBold {
 font-family:       Lucida Grande, Verdana, Geneva, Sans-serif;
 font-size:         11px;
 color:             #333;
 padding:           4px 10px 4px 6px;
 border-top:        2px solid #fff;
 border-bottom:     1px solid #B1B6D2;
 background-color: 	#F0F0F2;
}
.tableCellTwo, .tableCellTwoBold {
 font-family:       Lucida Grande, Verdana, Geneva, Sans-serif;
 font-size:         11px;
 color:             #333;
 padding:           4px 10px 4px 6px;
 border-top:        2px solid #fff;
 border-bottom:     1px solid #B1B6D2;
 background-color: 	#ECEEF3;
}

.tableCellOneBold {
 font-weight:       bold;
}
.tableCellTwoBold {
 font-weight:       bold;
}

</style>

</head>

<body>
<div id='content'>
<div id='pageheader'>
<table style="width:100%;" height="50" border="0" cellpadding="0" cellspacing="0">
<tr>
<td style="width:45%;"><img src="http://www.pmachine.com/themes/cp_global_images/ee_logo.jpg" width="260" height="80" border="0" alt="ExpressionEngine" /></td>
<td style="width:55%;" align="right" class="rightheader"><?php echo $data['app_full_version']; ?></td>
</tr>
</table>
</div>
<?php
}
// END




//  HTML FOOTER
// --------------------------------------------------------------------
// --------------------------------------------------------------------

function page_footer()
{
	global $data;
?>

<div class='copyright'>ExpressionEngine Server Wizard - &#169; copyright 2003 - 2005 pMachine, Inc. - All Rights Reserved</div>

</div>

</body>
</html>
<?php
}



?>