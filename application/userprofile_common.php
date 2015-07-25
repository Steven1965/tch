<?php
     //**********************************************************************************************************
     function display_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td><td>");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly>");
         print("</td></tr>");

     }
     //**********************************************************************************************************
     
     
	function displayRegisterNewUserForm()
	{
	    print("<form action=\"register.php\" method=\"post\">");
	    print("<table border=\"0\">");
	    print("<tr><td colspan=\"2\"><h2 align=\"center\" >User Registration Form</h2></td></tr>\n");
		
	    display_form_row("user_id", "Username", "" ,40,"text","");
	    display_form_row("pass", "Password", "" ,40,"password","");
	    display_form_row("pass2", "Confirm Password", "" ,40,"password","");
	    
         print("<tr><td colspan=\"2\" height=\"20\"></td></tr>\n");  
	    print("<tr><td colspan=\"2\">".
         "Enter your contact details. "
	     ."Enter a vlaid email address this will be used to notify you of any important status updates"
         ."</td></tr>\n");
           //print user Roles 
           display_form_row("first", "First Name", "",40,"text","");
           display_form_row("last", "Last Name", "",50,"text","");
           display_form_row("email", "Email", "",60,"text","");
           display_form_row("alt_email", "Alternative Email", "",60,"text","");
           display_form_row("tel", "Telephone", "",10,"text","");
           
         print("<tr><td colspan=\"2\" height=\"20\"></td></tr>\n");  
         print("<tr><td colspan=\"2\">".
         "Enter a security question and the corresponding answer. "
         ."This will be used if you forget your password. "
         ."</td></tr>\n");

           display_form_row("secq", "Security Question", "",60,"text","");
           display_form_row("seca", "Security Answer","",60,"password","");
           display_form_row("seca2", "Confirm Security Answer","",60,"password","");

         print("<tr><td colspan=\"2\" height=\"20\"></td></tr>\n");  
         print("<tr><td colspan=\"2\">".
         "Select the role that you want to perform within Tournament Clearing House. "
         ."For any change in role or new registration an administrator will approve your request within 2 business days. "
         ."Until then you will not be able to perform the functions requested".
         "</td></tr>");
           //print user Roles 
         print("<tr><td> User Role</td><td>\n");
         print("<SELECT ID=\"UserRoles\" NAME=\"UserRole\" SIZE=3 NOFINSIDE=\"~!   ~!\" >\n");
           print("    <OPTION VALUE=\"TEAM_MANAGER\" SELECTED>Team Manager</OPTION>\n");
           print("    <OPTION VALUE=\"TOURNAMENT_MANAGER\">Tournament Director</OPTION>\n");
           print("</SELECT>\n");
        print("</td></tr>\n");
	    print("<tr><th colspan=2><input type=\"submit\" name=\"submit\" value=\"Register\"></th></tr> </table>\n");
	    print("</table>\n");
	    print("</form>\n");
    
	}
	 //**********************************************************************************************************
     function display_profile($user_id)  {
       global $insert_required;
       $insert_required="false";
  
       //print("username:".$_POST['username']."\n");

       $select1="SELECT "
                   . "first_name, "
                   . "last_name, "
                   . "email, "
                   . "alternative_email, "
                   . "telephone, "
                   . "security_question, "
                   . "security_answer "
                 . "FROM user_profile "
                 . "WHERE "
                   . "user_id = '".$user_id."'";

       //print("<P> Select SQL : ".$select1. ":\n");

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);


      //print("<form action=\"$_SERVER['PHP_SELF']\" method=\"post\" >\n");
      print("<form action=\"changeprofile.php \" method=\"post\" >\n");
      print("<table border=\"0\">");
      print("<tr><td colspan=2><h1 align=center>Change Profile</h1></td></tr>");
      //print("<form action=\"$_SERVER['PHP_SELF']\" method=\"post\" >\n");

     if ($check == 0) {
         // Not necessarily an error condition - just means no user profile previously set up
         // in this case we will force an insert from the global insert_required


           display_form_row("user_id", "Username", $user_id ,40,"text","READONLY");//need to make this hidden
           display_form_row("first", "First Name", "",40,"text","");
           display_form_row("last", "Last Name", "",50,"text","");
           display_form_row("email", "Email", "",60,"text","");
           display_form_row("alt_email", "Alternative Email", "",60,"text","");
           display_form_row("tel", "Telephone", "",10,"text","");
           display_form_row("secq", "Security Question", "",60,"text","");
           display_form_row("seca", "Security Answer","",60,"password","");
           display_form_row("insert_required", "","true",4,"text","");//need to make this hidden


           echo "<P><P> No user profile - creating new profile" ;
           $insert_required="true";

      }
      else
      {     


           $row = mysql_fetch_array($result);
           display_form_row("user_id", "Username", $user_id,40,"text","READONLY");//need to make this hidden 
           display_form_row("first", "First Name", $row["first_name"],40,"text","");
           display_form_row("last", "Last Name", $row["last_name"],50,"text","");
           display_form_row("email", "Email", $row["email"],60,"text","");
           display_form_row("alt_email", "Alternative Email", $row["alternative_email"],60,"text","");
           display_form_row("tel", "Telephone", $row["telephone"],10,"text","");
           display_form_row("secq", "Security Question", $row["security_question"],60,"text","");
           display_form_row("seca", "Security Answer", $row["security_answer"],60,"password","");
           display_form_row("insert_required", "","",4,"hidden",""); //need to make this hidden
       }


           print("<tr><td colspan=\"2\" align=\"right\">\n");
           print("<input type=\"submit\" name=\"changeprofile\" value=\"change\">\n");
           print("<input type=\"reset\" name=\"resetprofile\" value=\"reset\">\n");
           print("</td></tr>");
           print("</table>");
           print("</form>");
    } // end function display_profile 
	
     //**********************************************************************************************************
     function registerUser()  {
     
        //This makes sure they did not leave any fields blank
        $invalid="NO";
	    if (!$_POST['user_id'] )  {
	    	$message="<P>User Id You did not complete all of the required fields</P>\n";
	    	$invalid="YES";
	    }
	    
	    if (!$_POST['pass'] | !$_POST['pass2'] )
	    {
	    	$message=$message."<P>Password and Confirm Passwords need to be populated</P>\n";
	    	$invalid="YES";
	    	
	    }
	    
	    if ($_POST['pass'] != $_POST['pass2'] )
	    {
	    	$message=$message."<P>Password and Confirm Passwords must match</P>\n";
	    	$invalid="YES";
	    	
	    }
	    
	    // checks if the username is in use
	    if (!get_magic_quotes_gpc()) {
	    	$_POST['user_id'] = addslashes($_POST['user_id']);
	    }
	    
	    $usercheck = $_POST['user_id'];
	    $check = mysql_query("SELECT user_id FROM user_login WHERE user_id = '$usercheck'")
	    or die(mysql_error());
	    $check2 = mysql_num_rows($check);
	    
	    //if the name exists it gives an error
	    if ($check2 != 0) {
	       $message=$message."Sorry, the username ".$_POST['user_id']." is already in use.";
	       $invalid="YES";
	       
	    }
	    
	    
        
        // this makes sure both passwords entered match
	    if ($_POST['seca'] != $_POST['seca2']) {
	       $message=$message."Sorry, the security answers do not match";
	       $invalid="YES";
	    }
	    
	    if ($invalid != "YES")
	    {
	    
		    // here we encrypt the password and add slashes if needed
		    $_POST['pass'] = md5($_POST['pass']);
		    if (!get_magic_quotes_gpc()) {
		          $_POST['pass'] = addslashes($_POST['pass']);
		          $_POST['user_id'] = addslashes($_POST['user_id']);
		    }
		    
		    // now we insert it into the database
		    $insert = "INSERT INTO user_login (user_id, password)
		    VALUES ('".$_POST['user_id']."', '".$_POST['pass']."')";
		    $add_member = mysql_query($insert) or die("Error creating user id". mysql_error());
		
		    insert_profile($_POST['user_id']);
		    insert_role($_POST['user_id']);
		    $message="<P>You have successfully registered with the Tournamenent Clearing House. Click here to return to the login screen<P>";
		    send_registration_confirmation_email($_POST['user_id']);
		    display_profile($_POST['user_id']);
	    }
		else
		{
			print($message);
			displayRegisterNewUserForm();
		}
     }

     //**********************************************************************************************************
     function insert_profile($user_id)  {

        global $upsertcheck;
        // here we encrypt the security question and add slashes if needed
        $_POST['seca'] = md5($_POST['seca']);
        if (!get_magic_quotes_gpc()) {
          $_POST['seca'] = addslashes($_POST['seca']);
        }

        $insert1="INSERT INTO user_profile "
                 ." (user_id,first_name,last_name,email,alternative_email,telephone,security_question,security_answer) "
                 ." VALUES ( '".$_POST['user_id']."',"
                 ." '".$_POST['first']."',"
                 ." '".$_POST['last']."',"
                 ." '".$_POST['email']."',"
                 ." '".$_POST['alt_email']."',"
                 ." '".$_POST['tel']."',"
                 ." '".$_POST['secq']."',"
                 ." '".$_POST['seca']."')";
                         
   
        //print("<P>Insert SQL:". $insert1 ."\n");
   
   
        $upsertcheck = mysql_query($insert1) or die(mysql_error());
        
     }
         //**********************************************************************************************************
     function insert_role()  {


        $insert1="INSERT INTO user_roles "
                 ." (user_id,role) "
                 ." VALUES ( '".$_POST['user_id']."',"
                 ." '".$_POST['UserRole']."')";
                         
   
   
        $check = mysql_query($insert1) or die(mysql_error());
      
       
     }

     //**********************************************************************************************************
     function update_profile($user_id)  {

        global $upsertcheck;
        // here we encrypt the security question and add slashes if needed
        $_POST['seca'] = md5($_POST['seca']);
        if (!get_magic_quotes_gpc()) {
          $_POST['seca'] = addslashes($_POST['seca']);
        }

        $update1="UPDATE user_profile "
                 ." SET first_name='".$_POST['first']."',"
                 ."        last_name='".$_POST['last']."',"
                 ."        email='".$_POST['email']."',"
                 ."        alternative_email='".$_POST['alt_email']."',"
                 ."        telephone='".$_POST['tel']."',"
                 ."        security_question='".$_POST['secq']."',"
                 ."        security_answer='".$_POST['seca']."'"
                 ." WHERE user_id = '".$user_id."'";
   
        //print("<P>Update SQL:". $update1 ."\n");
   
   
        $upsertcheck = mysql_query($update1) or die(mysql_error());
        //print("<P>Upsertcheck:". $upsertcheck ."\n");
     }
     //**********************************************************************************************************
 ?>