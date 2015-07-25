<?php
	   @session_start();

     //**********************************************************************************************************
     function display_team_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td class=\"tch\">$title:</td><td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" size=\"$length\" value=\"$value\" $readonly>\n");
         print("</td></tr>\n");

     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_team_header () {

         // this displays the result row from the team slection query

         print("<table  class=\"tch\" width=\"100%\" border=\"1\">");
         print("<tr>");
         print("<th  class=\"tch\">Delete</th>\n");
         //print("<th>Modify</th>\n");
         print("<th class=\"tch\">Roster</th>\n");
         print("<th  class=\"tch\">Team Id</th>\n");
         print("<th  class=\"tch\">Team Name</th>\n");
         print("<th  class=\"tch\">Club</th>\n");
         print("<th  class=\"tch\">Telephone</th>\n");
         print("<th  class=\"tch\">Website</th>\n");
         print("<th  class=\"tch\">Cut off year</th>\n");
         print("<th  class=\"tch\">gender</th>\n");
         print("</tr>");

     }

     

     //**********************************************************************************************************
     function display_team_trailer () {

         // this displays the result row from the team slection query

         print("</table>\n\n");

     }
     //**********************************************************************************************************
     function display_team_row ($rowresult) {

         // this displays the result row from the team slection query

         print("<tr>");
         print("<td><a href=\"viewandeditteams.php?action=delete&team_id=".$rowresult['id']."\">Delete</a></td>\n");
         //print("<td><a href=\"modifyteam.php?team_id=".$rowresult['id']."\">Modify</a></td>\n");
         print("<td><a href=\"roster.php?team_id=".$rowresult['id']."\">Roster</a></td>\n");
         print("<td>".$rowresult['id']."</td>\n");
         print("<td>".$rowresult['team_name']."</td>\n");
         print("<td>".$rowresult['club_id']."</td>\n");
         print("<td>".$rowresult['telephone']."</td>\n");
         print("<td>".$rowresult['website']."</td>\n");
         print("<td>".$rowresult['cut_off_year']."</td>\n");
         print("<td>".$rowresult['gender']."</td>\n");
         print("</tr>");

     }

     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_user_teams($user_id)  {
       global $insert_required;
       $insert_required="false";
  
       
       $select1="SELECT object_id "
                 . "FROM object_admin "
                 . "WHERE user_id = '".$user_id."' AND object_type = 'TEAM' AND type in ( 'OWNER' ,'OFFICIAL')" ;

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);

	   display_team_header () ;
	   while ($row = mysql_fetch_array($result)) {
	
	           $teamid = $row['object_id'];
	
	           $select2 = "SELECT * "
	                       . "FROM team "
	                       . "WHERE id = '".$teamid."'" ;
	 
	           $result2 = mysql_query($select2 ) or die('<p>Invalid query team does not exist</p>');
	
	           $check = mysql_num_rows($result2);
	           if ($check != 1)
	           {
	               print("<P> Number of rows does not equal 1 : ".$check."Serious Error VT101</P>\n");
	           }
	           $row2 = mysql_fetch_array($result2) ;
	
	           display_team_row($row2);
	   }
	   display_team_trailer();
	   
	    print("<P><a href=\"viewandeditteams.php?action=addteamform\">Create New Team</a>\n");

    } // end function display_user_teams 
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_tournaments_header ($title,$button1) {

         // this displays the result row from the team roster selection query

         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><th bgcolor=\"#008000\" COLSPAN=8>".$title."</th></tr>\n");
         print("<tr>\n");
         print("<th>".$button1."</th>\n");
         print("<th>Team</th>\n");
         print("<th>Title</th>\n");
         print("<th>Registration Deadline</th>\n");
         print("<th>Start Date</th>\n");
         print("<th>Age</th>\n");
         print("<th>Gender</th>\n");
         print("<th>Status</th>\n");
         print("</tr>\n");

     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_tournament_row ($row1, $row2) {

         // this displays the result row from the registered tournament slection query

      print("<tr>");
      print("<form action=\"tourn_roster.php\" method=\"post\" >\n");
      print("<td><input type=\"submit\" name=\"view\" value=\"View And Edit\"></td>\n");
      display_form_hidden_field("team_id",$row1['team_id']);
      display_form_hidden_field("role","Team");
      display_form_row2( "tournament_id","Tournament Id",$row1['tournament_id'],"4","4","text","READONLY");
      display_form_row2( "title","Name",$row2['title'],"20","20","text","READONLY");
      display_form_row2( "registration_deadline","Registration Deadline",$row2['registration_deadline'],"10","10","text","READONLY");
      display_form_row2( "start_date","Start date",$row2['start_date'],"10","10","text","READONLY");
      display_form_row2( "age","age",$row1['age'],"2","2","text","READONLY");
      display_form_row2( "gender","gender",$row1['gender'],"5","5","text","READONLY");
      display_form_row2( "status","status",$row1['status'],"10","10","text","READONLY");
      print("</form>\n\n");

      print("<tr>");
     }
     //**********************************************************************************************************
     function display_team_manager_tournaments($user_id)  {
  
       logger("username:".$_POST['username']."\n");

       $select1="SELECT object_id "
                 . "FROM object_admin "
                 . "WHERE user_id = '".$user_id."' AND object_type = 'TEAM' AND type in ( 'OWNER' ,'OFFICIAL')" ;

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);


       while ($row = mysql_fetch_array($result)) {

           $teamid = $row['object_id'];
           $select1="SELECT * FROM tournament_register WHERE team_id = '".$team_id."'" ;

           logger("Select SQL : ".$select1 );
           $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
           $check = mysql_num_rows($result);

           if ($check == 0)
           {
               print("<tr>");
               print("<td colspan=10>");
               print("<P>Currently there are no current tournaments for this team,");
               print("<P>please use tournament add form below to start the registration process");
               print("</td></tr>");

           }
           else
           {
                while ($row = mysql_fetch_array($result)) {

                   $select2="SELECT * FROM tournament WHERE id = '".$row['tournament_id']."'" ;
                   logger("Select SQL : ".$select2 );
                   $result2 = mysql_query($select2 ) or die('<p>Invalid query</p>ERROR_ACTION ');
                   $check = mysql_num_rows($result2);
                   if ($check == 0)
                   {
                       print("<tr>");
                       print("<td colspan=10>"); // ERROR_ACTION
                       print("<P>Error Condition - tournament Id has not been deleted from tournament register");
                       print("<P>please notify support");
                       print("</td></tr>");
                   }
                   else
                   {
                       $row2 = mysql_fetch_array($result2);
                       display_tournament_row($row, $row2);
                   }
               } //end while tournament_register loop
           }

       }

    } // end function display_user_tournaments 

     //**********************************************************************************************************
     function display_add_team_form($user_id)  {

      print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      print("<table class=\"tch\" width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#669900\"  colspan=2>Add New Team</th></tr>");

      display_team_form_row( "user_id","User Id",$user_id,"10","text","READONLY");
      display_team_form_row( "team_name","Team Name","","30","text","");
      display_team_form_row( "club_id","Club Id","","15","text","");
      display_team_form_row( "telephone","Telephone","","15","text","");
      display_team_form_row( "website","Website","","60","text","");
      print("<tr><td class=\"tch\">Age Group</td><td>\n");
      display_selection_age_group( "cut_off_year","");
	  print("</td></tr>\n");
      //display_form_row( "cut_off_year","Cut Of Year","","4","text","");
      print("<tr><td class=\"tch\">Gender</td><td>\n");
      display_selection_gender( "gender","GIRL");
	  print("</td></tr>\n");
      
      print("<tr><td class=\"tch\" colspan=\"2\" align=\"right\">\n");
      print("<input type=\"submit\" name=\"insertteam\" value=\"Add\">\n");
      print("</td></tr>");
      print("</table>");
      print("</form>\n\n");
    } // end function display_profile 

     //**********************************************************************************************************
     function insert_team($user_id)  {

        global $upsertcheck;

        $insert1="INSERT INTO team "
                 ." (team_name,club_id,telephone,website,cut_off_year,gender,notes) "
                 ." VALUES ( '".$_POST['team_name']."',"
                 ." '".$_POST['club_id']."',"
                 ." '".$_POST['telephone']."',"
                 ." '".$_POST['website']."',"
                 ." '".$_POST['cut_off_year']."',"
                 ." '".$_POST['gender']."',"
                 ." '".$_POST['notes']."'"
                 .")";
                         
        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());

        $selectteamid = "SELECT "
                              ."max(id) as id "
                       . "FROM team "
                       . "WHERE team_name = '".$_POST['team_name']."'" ;
 
        $result2 = mysql_query($selectteamid ) or die('mysql_error()');

        $check = mysql_num_rows($result2);
        if ($check == 0)
        {
             print("<P>Unable to get team_id from team inserted</P>");
             return;
        }
        $row2 = mysql_fetch_array($result2) ;

        print_array($row2);

         

        $insert2="INSERT INTO object_admin "
                 ." (object_id,user_id,object_type,type) "
                 ." VALUES ( '".$row2['id']."',"
                 ." '".$user_id."',"
                 ." 'TEAM','OWNER')";
   
        logger("<P>Insert1 SQL:". $insert2 ."\n");
   
   
        $check = mysql_query($insert2) or die(mysql_error());
      
     }

     //**********************************************************************************************************
     function delete_team($team_id)  {

        global $upsertcheck;

        $delete1="DELETE FROM team WHERE id = '".$team_id."'";
        logger("<P>delete1 SQL:". $delete1 ."\n");

        $check = mysql_query($delete1) or die(mysql_error());

        $delete2="DELETE FROM roster_item WHERE team_id = '".$team_id."'";
        logger("<P>delete2 SQL:". $delete2 ."\n");

        $check = mysql_query($delete2) or die(mysql_error());

        $delete2="DELETE FROM object_admin WHERE object_id = '".$team_id."' AND object_type = 'TEAM'";
        logger("<P>delete2 SQL:". $delete2 ."\n");

        $check = mysql_query($delete2) or die(mysql_error());

        print("<P> Team Successfully Deleted </P>");
      
     }
     //**************************************************************************************************************
     function display_exit_options()
     {
       print("<table width=\"100%\" border=\"0\">");
	   print("<tr>");
	   print("<td align=\"right\"><P><a href=\"useroptions.php\">Return to User Options Screen</a></td>");
	   print("</tr>");
	   print("<tr>");
	   print("</tr>");
	   print("</table>\n\n");
     }
  
     //**********************************************************************************************************
     // Main Display
     //**********************************************************************************************************
     
     function main_display_add_team_form($user_id)
     {
	   include("header.php");
       display_exit_options();
	   
	   display_add_team_form($user_id);
	   
	   display_exit_options();
	
	   
	
	   include("trailer.php");
     }
     //**********************************************************************************************************
     //Add Team
     //**********************************************************************************************************
     
     function main_team_manager_display($user_id)
     {
	   include("header.php");
       display_exit_options();
	   
	   //logger("Current Assigned Teams ");
	   display_user_teams($user_id);
	   print("<P></P>\n");
	
	   logger("<P> Create New Team \n");
	  
       //display_add_team_form($user_id);
	   
	   display_exit_options();
	
	   
	
	   //print_session_details();
	    mysql_close();
	   include("trailer.php");
     }
     //**********************************************************************************************************
     // Main Controller
     //**********************************************************************************************************
     function main_team_manager_controller()
     {
	   include("common_functions.php");
	   include("dbconnect.php");
       include("login.php");
       
	
	   $username=$_SESSION['username'];
	   login();
	   
	   
	   if(isset($_GET['user_id']))
	   {
	   		$user_id=$_GET['user_id'];
	   }
	   else 
	   {
	   		$user_id = $username;
	   }
	   
	   $action="view";
	   if(isset($_GET['action']))
	   {
	   		$action=$_GET['action'];
	   }
	   //if the login form is submitted
	   if (isset($_POST['insertteam'])) 
	   { // if form has been submitted
	        logger("Inserting Team Data ");
	   
	        insert_team($user_id); 
	   }
	   else if($action == "delete")
	   {
	   		check_user_is_team_admin($_GET['team_id'], $username);
	   	    //delete_team($_GET['team_id']);
	   	    print("<P>Are you sure you want to delete team:<a href=\"".$_SERVER['PHP_SELF']."?action=delete_confirm&team_id=".$_GET['team_id']."\">Confirm Delete</a></P>");
	   		
	   }
	   else if($action == "delete_confirm")
	   {
	   		check_user_is_team_admin($_GET['team_id'], $username);
	   	    delete_team($_GET['team_id']);
	   }
       else if($action == "addteamform")
	   {
	   	    main_display_add_team_form();
	   }
       main_team_manager_display($user_id);
       
       //print_session_details();
	 	mysql_close();
	    
     }

     
    
?> 
