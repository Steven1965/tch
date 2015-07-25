<?php

   //****************************************************************************************
   function create_user_option_link($link, $name){

            print("<td style=\"vertical-align: top;\"><a href=\"".$link."?".SID."\">");
            print("    ".$name."</a></td>");
   }

   //****************************************************************************************

   
   //****************************************************************************************
   // Main
   //****************************************************************************************
   include("common_functions.php");
   @ session_start();

   //print_session_details();

   include("header.php");
   include("dbconnect.php");

   //print_session_details();


   include("login.php");

   login();
   
   if (isset($_SESSION['username']))
   {
   		$username=$_SESSION['username'];
   }
   else 
   {
   	     print("<P>Your session has timed out or you have not logged in.</P>\n");
         print("<P>");print_login_screen_link();print("</P>\n");
         exit;	
   }
 

//****************************************************************************************

?>
   
      <table width="90%" cellpadding="2" cellspacing="0" align="center" >
        <tbody>
          <tr>
            <td colspan="1" align="right" height="1" valign="top" width="100%"><br>
            </td>
          </tr>
          <tr><td> 
          <h1>Registration</h1>
			<iframe width="420" height="315" src="http://www.youtube.com/embed/shB_-0qtoJ0?rel=0" frameborder="0" allowfullscreen></iframe>
          
          
<?php
	 
		  if (checkRole($username,"TEAM_MANAGER") == "YES")
          {
          echo <<<UPLS
          
          <h1>Team Manager Help</h1>
			<iframe width="420" height="315" src="http://www.youtube.com/embed/shB_-0qtoJ0?rel=0" frameborder="0" allowfullscreen></iframe>
UPLS;
          }
          if (checkRole($username,"TOURNAMENT_MANAGER") == "YES")
          {
          	echo <<<UPLS1
          	
          <h1>Tournament Manager Help</h1>
			<iframe width="420" height="315" src="http://www.youtube.com/embed/shB_-0qtoJ0?rel=0" frameborder="0" allowfullscreen></iframe>
          	
	                
UPLS1;
          }
?>     
          
	          
	          
          </td>
          </tr> 
          
          	<tr align="center">
	            <td bgcolor="#669900" colspan=1></td>
	          </tr>          
	          
	      </table>

<?php
   //print_session_details();
   mysql_close();

   include("trailer.php");

?>