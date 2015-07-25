<?php
    @session_start();

   //**********************************************************************************************************    
   function display_users_waiting_to_be_approved()  {
  
        $select1="SELECT roles.user_id, first_name, last_name, email, role,approved  "
                  ."FROM user_roles as roles "
                  ."LEFT JOIN user_profile as profile " 
                  ."ON roles.user_id = profile.user_id "
                  ."WHERE approved is null ";
      


       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query </p>');

       $check = mysql_num_rows($result);

       print("<table width=\"100%\" border=\"1\">\n");
       print("<tr>"
	             ."<th bgcolor=\"#6699000\">User Id</th>"
                 ."<th bgcolor=\"#6699000\">First Name</th>"
                 ."<th bgcolor=\"#6699000\">Last Name</th>"
                 ."<th bgcolor=\"#6699000\">Email</th>"
                 ."<th bgcolor=\"#6699000\">Role</th>"
	             ."<th bgcolor=\"#6699000\">Approve?</th>"
	             ."<th bgcolor=\"#6699000\">Delete?</th>\n"
	             ."</tr>\n");
       
       
       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=6>");
           print("Currently there are no users waiting to be approved");
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
                 ."<td>".$row['role']."</td>"
	             ."<td><a href=\"manageusers.php?action=approve&user_id=".$row['user_id']."&role=".$row['role']."\">Approve</a></td>\n"
	             ."<td><a href=\"manageusers.php?action=delete&user_id=".$row['user_id']."\">Delete</a></td>\n"
	             ."</tr>\n");
            }
       }
       print("</table>\n\n");
       

    } // end function display_profile 

   //**********************************************************************************************************    
   function display_users_by_type($role)  {
  
        $select1="SELECT roles.user_id, first_name, last_name, email, role,approved  "
                  ."FROM user_roles as roles "
                  ."LEFT JOIN user_profile as profile " 
                  ."ON roles.user_id = profile.user_id "
                  ."WHERE approved = 'YES' AND role = '".$role."'";
      


       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query </p>');

       $check = mysql_num_rows($result);

       print("<table width=\"100%\" border=\"1\">\n");
       print("<tr>"
	             ."<th bgcolor=\"#6699000\">User Id</th>"
                 ."<th bgcolor=\"#6699000\">First Name</th>"
                 ."<th bgcolor=\"#6699000\">Last Name</th>"
                 ."<th bgcolor=\"#6699000\">Email</th>"
                 ."<th bgcolor=\"#6699000\">Role</th>"
	             ."<th bgcolor=\"#6699000\">Unapprove</th>\n"
	             ."<th bgcolor=\"#6699000\">Delete</th>\n"
	             ."<th bgcolor=\"#6699000\">Teams</th>\n"
	             ."<th bgcolor=\"#6699000\">Tournaments</th>\n"
	             ."</tr>\n");
       
       
       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=8>");
           print("Currently There are no users waiting to be approved");
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
                 ."<td>".$row['role']."</td>"
	             ."<td><a href=\"manageusers.php?action=unapprove&user_id=".$row['user_id']."&role=".$row['role']."\">Unapprove</a></td>\n"
	             ."<td><a href=\"manageusers.php?action=delete&user_id=".$row['user_id']."\">Delete</a></td>\n" 	             
	             ."<td><a href=\"viewandeditteams.php?user_id=".$row['user_id']."\">View teams</a></td>\n"
	             ."<td><a href=\"tourn_mgr.php?user_id=".$row['user_id']."\">View tournaments</a></td>\n"
	             ."</tr>\n");
            }
       }
       print("</table>\n\n");
       

    } // end function display_profile 
     //**********************************************************************************************************
     function update_user_roles($user_id, $role, $approve)  {

 
        $update="UPDATE user_roles SET approved = '".$approve."'"
                 ." WHERE user_id = '".$user_id."' AND role = '".$role."'";
                         
        logger("<P>SQL:". $update ."\n");

        $errorMessage="Update Successful";
        $check = mysql_query($update) or $errorMessage = mysql_error();
        
        return $errorMessage;

      
     }
     //**********************************************************************************************************
     function delete_user($user_id)  {

 
     	$errorMessage = delete_user_roles($user_id);
     	$errorMeassage2 = delete_user_login($user_id);
     	
     	
        $errorMessage = $errorMessage.",".$errorMeassage2;
        
        
        return $errorMessage;

      
     }
     
     
     //**********************************************************************************************************
     function delete_user_roles($user_id)  {

 
        $update="DELETE FROM user_roles WHERE user_id = '".$user_id."'";
                         
        logger("<P>SQL:". $update ."\n");

        $errorMessage="Delete User Roles Successful";
        $check = mysql_query($update) or $errorMessage = mysql_error();
        
        return $errorMessage;

      
     }
     //**********************************************************************************************************
     function delete_user_login($user_id)  {

 
        $update="DELETE FROM user_login WHERE user_id = '".$user_id."'";
                         
        logger("<P>SQL:". $update ."\n");

        $errorMessage="Delete User Login Successful";
        $check = mysql_query($update) or $errorMessage = mysql_error();
        
        return $errorMessage;

      
     }
     //**********************************************************************************************************
     function display_users_delete_confirmation($user_id)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><P>Are you sure you want to delete the user ".$user_id."<a href=\"manageusers.php?action=deleteconfirmed&user_id=".$user_id."\">Yes</a>");
	     print("<P>If you wish to keep the user click here to return to manage users screen<a href=\"manageusers.php\">Cancel</a></td>");
	     print("</tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
     	     
	     
     //**********************************************************************************************************
     function display_users_main()  {
     
	  	 print("<h2>Users Waiting To Be Approved</h2>\n");
	   	 display_users_waiting_to_be_approved();
	   	 
	   	 print("<h2>Team Managers</h2>\n");
	   	 display_users_by_type("TEAM_MANAGER");
	
	   	 print("<h2>Tournament Managers</h2>\n");
	   	 display_users_by_type("TOURNAMENT_MANAGER");
	   	 
	   	 print("<h2>Super Users</h2>\n");
	   	 display_users_by_type("SUPERUSER");
     }
     //**********************************************************************************************************
     function users_main_controller()  {
     	include("common_functions.php");
     	include("dbconnect.php");
     	//if the login form is submitted
     	include("login.php");     	 
     	include("header.php");
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
     		$action = getPageParameter("action", "view");
     		$user_id = getPageParameter("user_id", "");
     		$role = getPageParameter("role", "");

     		 
     		if ($action == "approve")
     		{
     			$msg = update_user_roles($user_id,$role,"YES");

     			print("<P>".$msg."</P>\n");
     			display_users_main();

     		}
     		else if ($action == "delete")
     		{
     			print("<h2>Delete User</h2>\n");
     			display_users_delete_confirmation($user_id);
     		}
     		else if ($action == "deleteconfirmed")
     		{
     			$msg = delete_user($user_id);
     			print("<P>".$msg."</P>\n");
     			display_users_main();

     		}
     		else 
     		{
     			display_users_main();
     			
     		}
     		 

     	}
  	 	include("trailer.php");
     }
    //**************************************************************************************************************
    // Main
    //**************************************************************************************************************
	users_main_controller();

?>
