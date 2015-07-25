<?php
   @session_start();


     //**********************************************************************************************************
     // Main
     //**********************************************************************************************************
   include("common_functions.php");
   include("userprofile_common.php");
   include("dbconnect.php");
   include("header.php");
   include("login.php");
   print_session_details();
   
   login();
   //if the login form is submitted



   $username=$_SESSION['username'];

   //if the login form is submitted
   if (isset($_POST['changeprofile'])) 
   { // if form has been submitted
        print("<P> Updating User Profile Data \n");
   
       // makes sure they filled it in
       if(!$_POST['email'] | !$_POST['tel']) {
           die('You did not fill in a required field.');
       }
   
     //print("<P>InsertRequired:". $_POST['insert_required']."\n");
     //if ($_POST['insert_required'] = "true" )
     if ($_POST['insert_required'] == "true" )
     {
        insert_profile($username);
     }
     else
     {
        update_profile($username);
     }
      
     //Gives error if user dosen't exist
     if ($upsertcheck == 0) {
             display_profile($username);
             echo "Failed to update user profile please try again.<a href=register.php>Click Here to Register</a>)";
     }
     else
     {
              display_profile($username);
              echo "<P>  User Profile Successfully updated <a href=useroptions.php>Click here to return to user options</a>";
     }
   }
   else
   {
        //print("<P> Displaying Change Profile Screen \n");
        display_profile($username);
   }

   print_session_details();
   mysql_close();
   include("trailer.php");

?> 
