<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>CSUS Racquetball</title>
<style type="text/css">
@import url(style.css);
</style>
</head>
<body>
<div id="container">
  <!--Header-->
  <div id="header"></div>
    <!--Menu-->
<?php include('menu.php') ?>
    <!--Content-->
	<div id="content">
	    <h3>Contact</h3>
		<br />
	      <div id="news">
<h2><?

 if($_POST[send]) { 
 if($_POST['name'] != "NULL" AND $_POST['email'] != "NULL" AND $_POST['message'] != "NULL") {
 if(preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $_POST['email'])) {

 $name = $_POST["name"];
 $email = $_POST["email"];
 $message = $_POST["message"];

 $forminfo =
 "Name: $name\n
 E-Mail Address: $email\n
 Message: $message\n";

 $recipient = "csusracquetball@yahoo.com";
 $subject = "Contact form from website";

 $formsend = mail("$recipient", "$subject", "$forminfo");

 echo("
 <div align=\"center\">

 Your message has been sent successfully! Thank you.

 </div>

 ");

 }else{

 echo("

 <div align=\"center\">
 You have specified an invalid e-mail address. Please hit the button below to check your e-mail address.<br>
 <br>
 <FORM>
 <INPUT TYPE=\"button\" VALUE=\"Back\" onClick=\"history.back()\">
 </FORM>
 </div>

 ");

 }
 }else{

 echo("

 <div align=\"center\">
 You have forgotten to fill out one or more fields. Please hit the button below to check your data.<br>
 <br>
 <FORM>
 <INPUT TYPE=\"button\" VALUE=\"Back\" onClick=\"history.back()\">
 </FORM>
 </div>

 ");

 }
 }else{

 echo ("

 <div align=\"center\">
 <form method=\"POST\">
 Your Name:<br>
 <input type=\"text\" size=\"25\" style=\"background-color:#ccc\" name=\"name\"><br>
 Your E-Mail Address:<br>
 <input type=\"text\" size=\"25\" style=\"background-color:#ccc\" name=\"email\"><br>
 Your Message:<br>
 <textarea name=\"message\" style=\"background-color:#ccc\" rows=\"7\" cols=\"50\"></textarea><br>
 <input name=\"send\" type=\"submit\" value=\"Send\"></td>
 </form>

 ");

 }

 ?></h2>
  </div>
  </div>
    <!--Footer-->
  <div id="footer">
    <?php include('footer.php') ?>
    </div>
  </div>
</div>
</body>
</html>