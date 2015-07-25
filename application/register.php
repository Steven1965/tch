<?php
// Connects to your Database
include("common_functions.php");
include("dbconnect.php");
include("userprofile_common.php");


include("header.php");
//This code runs if the form has been submitted
if (isset($_POST['submit'])) {

 	registerUser();
    


?>
    
    
    <h1>Registered</h1>
    <p>Thank you, you have registered - you may now login</p>
    <p><a href="<? print_webroot();?>index.php">Click Here to return to the login screen:</a></p>

<?php
}
else
{
	displayRegisterNewUserForm();
}
include("trailer.php");
mysql_close();
?>
