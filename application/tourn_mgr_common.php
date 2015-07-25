<?php

     //**********************************************************************************************************
     function display_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td><td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly>\n");
         print("</td></tr>\n");

     }
     //**********************************************************************************************************

     //**********************************************************************************************************
 

     //**********************************************************************************************************
     function main_controller_tourn_mgr () {
	   include("common_functions.php");
	   include("dbconnect.php");
	   include("header.php");
	
	   @session_start();
	   //print_session_details();	
	   //if the login form is submitted
	   include("login.php");
	
	
	   $username=$_SESSION['username'];
	   
	   if(isset($_GET['user_id']))
	   {
	   		$user_id=$_GET['user_id'];
	   }
	   else 
	   {
	   		$user_id = $username;
	   }
	
	   if ( checkRole($username, "TOURNAMENT_MANAGER") == "YES")
	   {
	   		//if the login form is submitted
	   		logger("Current Assigned Tournament for ".$user_id);
	   		display_user_tournaments($user_id);
	   		
	   }
	   else 
	   {
	   	       print("<P>You (".$username.")are not an Tournament Manager and do not have access to the requested screen.</P>\n");
	           print("<P>Or your session has timed out.");
	           print_login_screen_link();
	           print("</P>\n");
	           print("<P>If you think this is an error contact :</P>\n ");
	           print("<P><a href=\"info@tournamentclearinghouse.com\"> Tournament Clearing House Support </a></P>\n");
	   	
	   }
	   //print_session_details();
	   mysql_close();
	   include("trailer.php");
	     
     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_user_tournaments($user_id)  {
       global $insert_required;
       $insert_required="false";
  
       //logger("username:".$_POST['username']."\n");

       $select1="SELECT id,title,start_date,object_id "
                 . "FROM object_admin "
                 . "LEFT JOIN tournament ON "
                 . "object_admin.object_id = tournament.id "
                 . "WHERE user_id = '".$user_id."' AND "
                 . "type in ( 'OWNER' ,'OFFICIAL') AND "
                 . "object_type = 'TOURNAMENT'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       // this displays the result row from the team slection query

       print("<div  class=\"tch\"><table  class=\"tch\" width=\"100%\" ><tr>\n");      
       print("<th class=\"tch\">Id</th>\n");
       print("<th class=\"tch\">Title</th>\n");
       print("<th class=\"tch\">Start&nbsp;Date</th>\n");
       print("<th class=\"tch\">View</th>\n");
       print("<th class=\"tch\">Copy</th>\n");
       print("<th class=\"tch\">Delete</th>\n");
       //print("<th class=\"tch\">Register</th>");
       print("</tr>\n");
        
       if ($result)
       {
       	//$check = mysql_num_rows($result);
       	while ($row = mysql_fetch_array($result))
       	{
       		 // this displays the result row from the team slection query
	         print("<tr>\n");         
	         print("<td class=\"tch\">".$row['id']."</td>\n");
	         print("<td class=\"tch\">".$row['title']."</td>\n");
	         print("<td class=\"tch\">".$row['start_date']."</td>\n");
	         print("<td class=\"tch\"><a href=\"edittournament.php?action=edit&id=".$row['id']."\">View</a></td>\n");
	         print("<td class=\"tch\"><a href=\"edittournament.php?action=copy&id=".$row['id']."\">Copy</a></td>\n");
	         print("<td class=\"tch\"><a href=\"edittournament.php?action=delete&id=".$row['id']."\">Delete</a></td>\n");
	         //print("<td class=\"tch\"><a href=\"tourn_register.php?action=view&id=".$rowresult['id']."\">View Register</a></td>\n");
	         print("</tr>\n");
       	}
       }
       else
       {
       		print("<tr><td colspan=\"6\">You currently do not have any tournaments assigned - use the link below to create a tournament</td></tr>\n");
       }
        
       print("</table>");
       print("<P><a href=\"edittournament.php?action=new\">Create New Tournament</a>\n");
       print("</div>");
       

    } // end function 



?> 
