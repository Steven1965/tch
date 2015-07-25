<?php
	@session_start();


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
   include("tourn_mgr_common.php");
   include("team_functions.php");
   include("login.php");
   print_session_details();
   
   include("header.php");
   include("dbconnect.php");
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
          
<?php
	 
		  $optionsFound="NO";
          if (checkRole($username,"TEAM_MANAGER") == "YES")
          {
          	$optionsFound="YES";
          echo <<<UPLSa
          
			  <tr align="center">
	            <th bgcolor="#669900" >Team Manager Options</th>
	          </tr>          
	          <tr>
	            <td style="vertical-align: top;">
	            <h3>Manage Teams</h3>

UPLSa;

          		display_user_teams($username);
          
	       echo <<<UPLSb
	            </td>
	          </tr>
	          <tr> <td colspan="1" align="right" height="1" valign="top" width="100%"><br></td>
          </tr>
UPLSb;
          }
          if (checkRole($username,"TOURNAMENT_MANAGER") == "YES")
          {
          	$optionsFound="YES";
          	echo <<<UPLS1
          	
			  <tr align="center">
	            <th bgcolor="#669900" >Tournament Director Options</th>
	          </tr>          
	          <tr>
	            <td style="vertical-align: top;">
	            <h3>Manage Tournaments</h3>
UPLS1;

          	display_user_tournaments($username);
          	//<a href="tourn_mgr.php">View And Edit My Tournaments</a><br>
          	echo <<<UPLS1b
          	
	            </td>
	          </tr>
	          <tr> <td colspan="1" align="right" height="1" valign="top" width="100%"><br></td>
	          
	          
          
UPLS1b;
          }
          if (checkRole($username,"SUPERUSER") == "YES")
          {
            $optionsFound="YES";
          	echo <<<UPLS2
          	
			  <tr align="center">
	            <th bgcolor="#669900">Administrator Options</th>
	          </tr>          
	          <tr>
	            <td style="vertical-align: top;">
	                   <a href="manageusers.php">Manager Users</a><br>
	            </td>
	          </tr>
	          <tr>
	            <td style="vertical-align: top;">
	                   <a href="manageteams.php">Manage Teams</a><br>
	            </td>
	          </tr>
          	  <tr> <td colspan="1" align="right" height="1" valign="top" width="100%"><br></td>
	          
	          
          
UPLS2;
          }     
          if ($optionsFound == "NO")
          {
          	echo <<<UPLS3
          	
			  <tr align="center">
	            <th bgcolor="#669900" >Administrator Options</th>
	          </tr>          
	          <tr>
	            <td style="vertical-align: top;">
	                   <P>You have registered however your registration has not been approved for any actions to be performed</P>
	                   <P>Please keep checking back. If you do not receive any email notification or still do not have access to any functions within 2 business days of your registration please contact us
	                   at the contact details below</P>
	            </td>
	          </tr>
          	  <tr> <td colspan="1" align="right" height="1" valign="top" width="100%"><br></td>
	          
UPLS3;
	          
          }
?>     
          
			  <tr align="center">
	            <th bgcolor="#669900">General Options</th>
	          </tr>          
	          <tr>
	            <td style="vertical-align: top;">
	                   <a href="changeprofile.php">Change Profile</a><br>
	            </td>
	          </tr>
          	  <tr> <td colspan="1" align="right" height="1" valign="top" width="100%"><br></td>
	          
	          
          
          
          	<tr align="center">
	            <td bgcolor="#669900" colspan=1></td>
	          </tr>          
	          
	      </table>

<?php
   //print_session_details();
   mysql_close();

   include("trailer.php");

?>