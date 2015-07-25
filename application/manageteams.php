<?php
        @session_start();

   //**********************************************************************************************************    
   function display_all_teams()  {
  
         $select1="SELECT profile.user_id, profile.email,profile.first_name, profile.last_name, "
                 ." team.id as team_id, team.team_name, team.cut_off_year " 
                 ." FROM object_admin as oa "
                 ." left join user_profile  as profile "
                 ." on oa.user_id = profile.user_id "
                 ." left join team as team "
                 ." on team.id = oa.object_id"
                 ." where object_type = 'team'";
        logger("<P>SQL:". $select1 ."\n");

        $result = mysql_query($select1 ) or die("<p>Invalid query:".$select1.":".mysql_error()."</p>");
        
 	       $check = mysql_num_rows($result);
	
	       print("<table width=\"100%\" border=\"1\">\n");
	       print("<tr>"
		             ."<th bgcolor=\"#6699000\">User Id</th>"
	                 ."<th bgcolor=\"#6699000\">First Name</th>"
	                 ."<th bgcolor=\"#6699000\">Last Name</th>"
	                 ."<th bgcolor=\"#6699000\">Email</th>"
	                 ."<th bgcolor=\"#6699000\">Team Id</th>"
		             ."<th bgcolor=\"#6699000\">Team Name</th>\n"
		             ."<th bgcolor=\"#6699000\">Cut Off Year</th>\n"
		             ."<th bgcolor=\"#6699000\">View</th>\n"
		             ."</tr>\n");
	       
       
	       if ($check == 0)
	       {
	           print("<tr>");
	           print("<td colspan=8>");
	           print("Currently there are no teams");
	           print("</td></tr>");
	          
	       }
	       else
	       {
	            while ($row = mysql_fetch_array($result)) {
	              	print("<tr>"
		             ."<td>".$row['user_id']."</td>"
	                 ."<td>".$row['first_name']."</td>"
	                 ."<td>".$row['last_name']."</td>"
	                 ."<td>".$row['email']."</td>"
	                 ."<td>".$row['team_id']."</td>"
		             ."<td>".$row['team_name']."</td>"
		             ."<td>".$row['cut_off_year']."</td>"
		             ."<td><a href=\"roster.php?user_id=".$row['user_id']."&team_id=".$row['team_id']."\">View</a></td>\n"
		             ."</tr>\n");
	            }
	       }
	       print("</table>\n\n");
       

    } // end function display_profile 


     //**********************************************************************************************************
     //**********************************************************************************************************
     // Main
     include("common_functions.php");

     include("dbconnect.php");
     include("header.php");
     include("login.php");
     login();

     $username=$_SESSION['username'];
     
     
     
     if (!check_if_super_user($username))
     {
     	   print("<P>You are not a superuser and do not have access to the requested screen.</P>\n");
           print("<P>Or your session has timed out.");
           print_login_screen_link();
           print("</P>\n");
           print("<P>If you think this is an error contact Tournament Clearing House Support</P>\n ");
           print("<P><a href=\"admin@tournamentclearinghouse.com\"> Tournament Clearing House Support </a></P>\n");
     }
     else
     {    
		// no actions at present     
	     
	     
	     
	  	 print("<h2>All teams</h2>\n");
	   	 display_all_teams();
	   	 
	   	
     }	 
   	 
   	 include("trailer.php");

?>
