<?php
    //**************************************************************************************************************
    function authenticate_user($login_username, $login_password)
    {
         global $authentic_user;
         

         // here we encrypt the password and add slashes if needed
         $login_password = md5($login_password);
         if (!get_magic_quotes_gpc()) {
            $login_password = addslashes($login_password);
            $login_username = addslashes($login_username);
         }
         //echo $login_password;
         //echo $login_username;

         logger ("Authenticate User");

         $authsql="SELECT * FROM user_login WHERE user_id = '".$login_username."' AND "
                   ."password = '".$login_password."'";
         logger ("AuthSql:".$authsql);

         $check = mysql_query($authsql)
                   or die(mysql_error());
   
         //Gives error if user dosen't exist
         $check2 = mysql_num_rows($check);
         if ($check2 == 0) {
            $authentic_user = "false";
            die("Incorrect userid/password, please try again.".print_sitelink("index.php","Click Here to return to the login screen"));
         }
         else
         {
             $authentic_user = "true";
             //set_session_cookie($login_username,$login_password);
             set_session($login_username,$login_password);
             
             return 0;
         }
    }
    
 
    
    //**************************************************************************************************************
    //**************************************************************************************************************
    function set_session($username, $password)
    {
           // if login is ok then we add a cookie
           //session_start();
           
           logger("Entered: set_session");
           logger("username:=".$username);
           logger("password:=".$password);

           $_SESSION['username']=$username;
           $_SESSION['password']=$password;
   
           logger("SESSION-username:=".$_SESSION['username']);
           logger("SESSION-password:=".$_SESSION['password']);
           session_write_close();
     }
    //**************************************************************************************************************
    //**************************************************************************************************************
    function set_session_cookie($username, $password)
    {
           // if login is ok then we add a cookie
           $username = stripslashes($username);
           $hour = time() + 3600;
           setcookie(ID_my_site, $username, $hour);
           setcookie(Key_my_site,$password, $hour);
   
     }
    //**************************************************************************************************************
    //**************************************************************************************************************
    function authenticate_session ($session_username, $session_password)
    {
         logger ("Authenticate Session");
   
         $sessionchecksql="SELECT * FROM user_login WHERE "
                           ." user_id = '".$session_username."' AND "
                           ." password = '".$session_password."'";

           logger("Sessionchecksql:".$sessionchecksql);

           $check = mysql_query($sessionchecksql)or die(mysql_error());
           //Gives error if user dosen't exist
           $check2 = mysql_num_rows($check);
           if ($check2 == 0) {
              die('Incorrect session userid/password, please try again'.print_sitelink("index.php","Click Here to return to the login screen"));
           }
    }
    //**************************************************************************************************************
    function failed_to_login_action()
    {
        echo "<P>Failed To Login ";
        echo "<P>Redirecting to main login page ";
        //print("<META HTTP-EQUIV=\"refresh\" content=\"2; URL=/TournamentRegistrar/index.php\"> ");
        //include("loginform.php");
        print("Incorrect cookie userid/password, please try again.\n");
        print("<P>".print_sitelink("index.php","Click Here to return to the login screen"));
    }
    //**************************************************************************************************************
    // login_form
    //**************************************************************************************************************
    function login_form()
    {
	print("<!-------------------- Start Of Login Form -------------------->\n");
	print("			<P ALIGN=CENTER>Login: Please enter username and password: </P>\n");
        print("			<FORM ACTION=");
        print_siteformaction("useroptions.php");
        print(" METHOD=\"POST\">\n");
        print("                 <table>\n");
        print("                    <tr>\n");
        print("                      <td> Username: </td>\n");
        print("                      <td> <INPUT TYPE=TEXT NAME=\"username\" SIZE=50 LENGTH=20> </td>\n");
        print("                    </tr>\n");
        print("                    <tr>\n");
        print("                      <td> Password: </td>\n");
        print("                      <td><INPUT TYPE=PASSWORD NAME=\"pass\" SIZE=30 LENGTH=20> </td>\n");
        print("                    </tr> \n");
        print("                    <tr>\n");
        print("                          <TD></TD>\n");
		print("				<td>\n");
        print("                            <INPUT TYPE=SUBMIT NAME=\"submitlogin\" VALUE=\"Login\" >\n");
		print("			           <INPUT TYPE=RESET VALUE=\"Reset\" > \n");
        print("                         </td>\n");
        print("                    </tr> \n");
        print("                    <tr><td colspan=2>\n");
		print("			       <P ALIGN=Left>");
		print_sitelink("register.php", "Register");
		print("			          &nbsp\n");
		print_sitelink("forgotpassword.php","Forgot Password");
		print("                           </A></P>\n");
        print("                          </td>\n");
        print("                    </tr> \n");
        print("                  </table>\n");
	print("                  </FORM>\n");
	print("<!-------------------- End Of Login Form -------------------->\n");
    }

    //**************************************************************************************************************
    // change password
    //**************************************************************************************************************
    function change_password()
    {
	print("<!-------------------- Start Of Login Form -------------------->\n");
	print("			<P ALIGN=CENTER>Login: Please enter username and password: </P>\n");
        print("			<FORM ACTION=".print_siteformaction("useroptions.php")." METHOD=\"POST\">\n");
        print("                 <table>\n");
        print("                    <tr>\n");
        print("                      <td> OldPassword: </td>\n");
        print("                      <td> <INPUT TYPE=TEXT NAME=\"oldpassword\" SIZE=30 LENGTH=20> </td>\n");
        print("                    </tr>\n");
        print("                    <tr>\n");
        print("                      <td> New Password: </td>\n");
        print("                      <td><INPUT TYPE=PASSWORD NAME=\"newpass\" SIZE=30 LENGTH=20> </td>\n");
        print("                    </tr> \n");
        print("                    <tr>\n");
        print("                      <td> Confirm New Password: </td>\n");
        print("                      <td><INPUT TYPE=PASSWORD NAME=\"confirmpass\" SIZE=30 LENGTH=20> </td>\n");
        print("                    </tr> \n");
        print("                    <tr>\n");
        print("                         <TD></TD>\n");
		print("							<td>\n");
        print("                            <INPUT TYPE=SUBMIT NAME=\"submit\" VALUE=\"ChangePassword\" >\n");
		print("			           		   <INPUT TYPE=RESET VALUE=\"Reset\" > \n");
        print("                         </td>\n");
        print("                    </tr> \n");
        print("                    <tr><td colspan=2>\n");
		print("			       <P ALIGN=Left>");
		print_sitelink("register.php", "Register");
		print("			          &nbsp");
		print_sitelink("forgotpassword.php","Forgot Password");
        print("                           </A></P>\n");
        print("                          </td>\n");
        print("                    </tr> \n");
        print("                  </table>\n");
	print("                  </FORM>\n");
	print("<!-------------------- End Of Login Form -------------------->\n");
    }
    //**************************************************************************************************************
    // login
    //**************************************************************************************************************
   
    function login()
    {
       //session_start();
       //if the login form is submitted
       print_session_details();
 
       //print_array($_POST);
       if (isset($_POST['submitlogin'])) 
       { // if form has been submitted
       
           // makes sure they filled it in
           if(!$_POST['username'] | !$_POST['pass']) {
               print('<P>You did not fill in a required field.</P>');
               failed_to_login_action();
           }
           if (!authenticate_user($_POST['username'], $_POST['pass']))
           {
               /**/
               //include("useroptions.php");
           }
           else
           {
               failed_to_login_action();
               //include("loginform.php");
           }
       }
       else if (isset($_SESSION['username']) )  // Check session 
       {
               logger("SESSION being checked ");
               //print_session_details();
               //authenticate_session($_SESSION['username'], $_SESSION['password']);
       }
       //else if(isset($_COOKIE['ID_my_site'])) // Check Cookie
       //{
       //        logger("COOKIE being checked ");
       //        logger($_COOKIE['ID_my_site']);
       //        logger($_COOKIE['Key_my_site']);
       //        authenticate_session($_COOKIE['ID_my_site'], $_COOKIE['Key_my_site']);
       //}
       else
       {
               failed_to_login_action();
       }
   } 
 
?> 


