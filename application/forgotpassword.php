<?php




    //**************************************************************************************************************
    // forgot_password_form
    //**************************************************************************************************************
    function forgot_password_form()
    {
	print("	<TR>\n");
    print("	   <TD></TD>\n");
    print("	   <TD>\n");
    print("	   <P>If you have forgotten your password enter your username/email \n");
    print("	   <P>If the username/email matches our records we will send a new password to your email address\n");
    print("	   </TD>\n");
    print("	   <TD></TD>\n");
    print("	   <TD>\n");
    print("<!-------------------- Start Of Forgot Password Form -------------------->\n");
	print("			<P ALIGN=CENTER>Login: Please enter username/email address: </P>\n");
        print("			<FORM ACTION=");print_siteformaction("forgotpassword.php");print(" METHOD=\"POST\">\n");
        print("                 <table>\n");
        print("                    <tr>\n");
        print("                      <td> Username/Email: </td>\n");
        print("                      <td> <INPUT TYPE=TEXT NAME=\"username\" SIZE=50 LENGTH=30> </td>\n");
        print("                          </tr>\n");
        print("                          <TD></TD>\n");
	    print("				         <td>\n");
        print("                            <INPUT TYPE=SUBMIT NAME=\"submit\" VALUE=\"Submit\" >\n");
	    print("			           <INPUT TYPE=RESET VALUE=\"Reset\" > \n");
        print("                         </td>\n");
        print("                    </tr> \n");
        print("                    <tr><td colspan=2>\n");
		print("			       <P ALIGN=Left>");
		print_sitelink("register.php", "Register");
		print("			          &nbsp");
		print_sitelink("index.php","Return to login screen");
		print("                           </A></P>\n");
        print("                    </tr> \n");
        print("                  </table>\n");
	print("                  </FORM>\n");
	print("<!-------------------- End Of Forgot Password  Form -------------------->\n");
	print("	   </td>\n");
    print("	                        </TR>\n");
    }
    
   //**************************************************************************************************************
    function authenticate_user_email($email)
    {
         global $authentic_user;

         // here we encrypt the password and add slashes if needed
         if (!get_magic_quotes_gpc()) {
            $email = addslashes($email);
         }
         echo $email;

         logger ("Authenticate User Email");

         $authsql="SELECT email FROM user_profile WHERE user_id = '".$email."' OR email = '".$email."'";
         logger ("AuthSql:".$authsql);

         $check = mysql_query($authsql)
                   or die(mysql_error());
   
         //Gives error if user dosen't exist
         $check2 = mysql_num_rows($check);
         if ($check2 == 0) {
            $authentic_user = "false";
            die("Incorrect userid/email, please try again.".print_sitelink("forgotpassword.php","Click Here to return to the forgot password screen"));
         }
         else
         {
             $authentic_user = "true";
             //set_session_cookie($login_username,$login_password);
             //TODO here we will set reset the email and send back to the user
            die('Userid/email found a message has been sent to your Email account please try again'.print_sitelink("index.php","Click Here to return to the login screen"));             
            return 0;
         }
    }
         //**************************************************************************************************************
    // forgot password
    //**************************************************************************************************************
   
    function forgot_password()
    {
       //session_start();
       //if the login form is submitted
       //print_session_details();
 
       //print_array($_POST);
       if (isset($_POST['submit'])) 
       { // if form has been submitted
       
           // makes sure they filled it in
           if(!$_POST['username']) {
               die('You did not fill in a required field.');
           }
           if (!authenticate_user_email($_POST['username']))
           {
               /**/
               //include("useroptions.php");
           }
           else
           {
               //failed_to_find_email_action();
               //include("loginform.php");
               forgot_password_form();
           }
       }
       else 
       {
       		forgot_password_form();
       }
   } 
?>
    
//*****************************************************************************************************************
//main
<?php
	include ("global.php");
    include("common_functions.php");
    include("header.php");
    include("dbconnect.php");
    

?>
	<TABLE BORDERCOLOR = "#000000" CELLPADDING=2 CELLSPACING=0 BGCOLOR="#ffffff">
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=500>
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
        <TBODY>
		<TR>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
		</TR>
<?php
			forgot_password();
?>
		<TR>
			<TD COLSPAN=5 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
		</TR>
        </TABLE>

<?php
    include("trailer.php");
?>
