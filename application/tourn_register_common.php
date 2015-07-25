<?php

     //**********************************************************************************************************
     function display_tournament_teams_header ($title) {

         // this displays the result row from the team roster selection query

         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><td bgcolor=\"#6699000\"  COLSPAN=7>".$title."</td></tr>\n");
         print("<tr>\n");
         print("<th bgcolor=\"#6699000\" >View Details</th>\n");
         //print("<th>Tournament ID</th>\n");
         print("<th bgcolor=\"#6699000\" >Team Id</th>\n");
         print("<th bgcolor=\"#6699000\" >Team Name</th>\n");
         print("<th bgcolor=\"#6699000\" >Age</th>\n");
         print("<th bgcolor=\"#6699000\" >Gender</th>\n");
         print("<th bgcolor=\"#6699000\" >Status</th>\n");
         print("<th bgcolor=\"#6699000\" >Roster</th>\n");
         print("</tr>\n");

     }


     //**********************************************************************************************************
     function display_tournament_team_row ($rowresult) {

         // this displays the result row from the team slection query

         print("<tr>");
         print("<td><a href=\"tourn_roster.php?tournament_id=".$rowresult['tournament_id']
                     ."&team_id=".$rowresult['team_id']
                     ."&role=tournament\">View Details</a></td>\n");
         print("<td>".$rowresult['team_id']."</td>\n");
         print("<td>".$rowresult['team_name']."</td>\n");
         print("<td>".$rowresult['age']."</td>\n");
         print("<td>".$rowresult['gender']."</td>\n");
         print("<td>".$rowresult['status']."</td>\n");
         print("<td>");
           print("<a href=\"printpicture.php?file=".$rowresult['filename'].
                     "&width=".$rowresult['width']."&height=".$rowresult['height']."\" target=\"_blank\">Print Roster</a>");
 		 print("</td>\n");
         print("</tr>");

     }
     //**********************************************************************************************************
     function display_tournament_teams($tournament_id, $status)  {
  
       
       $select1="SELECT a.tournament_id,a.team_id, b.team_name,a.age,a.gender,a.status, f.width,f.height, f.filename "
                 . " FROM tournament_register a "
                 . " LEFT JOIN team b"
                 . " ON a.team_id = b.id"
                 . " LEFT JOIN files f"
                 . " ON b.id = f.associated_id AND f.associated_table = 'TEAM' AND f.associated_name = 'RSTR_FRONT'"
                 . " WHERE tournament_id = '".$tournament_id."'" 
                 .        " AND status = '".$status."'";

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=6>");
           print("Currently There are no teams in this status");
           print("</td></tr>");
          
       }
       else
       {
            while ($row = mysql_fetch_array($result)) {
              display_tournament_team_row($row);
            }
       }
       print("</table>\n");
       print("<P></P>\n");

    } // end function display_profile 
    //**********************************************************************************************************
     function export_tournament_teams($tournament_id)  {
  
       
       $select1="SELECT a.tournament_id,a.team_id, b.team_name,a.age,a.gender,a.status, f.width,f.height, f.filename "
                 . " FROM tournament_register a "
                 . " LEFT JOIN team b"
                 . " ON a.team_id = b.id"
                 . " LEFT JOIN files f"
                 . " ON b.id = f.associated_id AND f.associated_table = 'TEAM' AND f.associated_name = 'RSTR_FRONT'"
                 . " WHERE tournament_id = '".$tournament_id."'" 
                 . " GROUP BY  a.status, a.gender,a.age ";

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

       if ($check == 0)
       {
       	  logger("No Teams found");
          return;
          
       }
       else
       {
       		 $filename = "uploads/Export_".$tournament_id. ".csv";
       		 $fp = fopen($filename, "w") or die("Couldn't open $filename");
       		 $header="Team Id, Team Name, Age, Gender, Status\n";
       		 fputs($fp, $header);
             while ($row = mysql_fetch_array($result)) {
                $lineStr=$row['team_id'].",".
                         $row['team_name'].",".
                         $row['age'].",".
                         $row['gender'].",".
                         $row['status']. "\n";
                       
                       
                        
                fputs($fp, $lineStr);
            }
            fclose($fp); 
       	    return $filename; 
       }

    } // end function display_profile 

   //**********************************************************************************************************
     function display_register_exit_options()  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><P><a href=\"useroptions.php\">Return to User Options Screen</a></td>");
	     print("<td align=\"left\"><td align=\"right\"><P><a href=\"tourn_mgr.php\">Return to Tournament Manager Main Screen</a></td>");
	     print("</tr>");
	     print("<tr>");
	     print("</tr>");
	     print("</table>");
     }
   //**********************************************************************************************************
     function main_display_tournament_register($tournament_id)  {
		   
		   //logger("CONSIDERING TEAMS ");
		   //display_tournament_teams_header ("Teams Considering Application");
		   //display_tournament_teams($tournament_id,"CONSIDER")
		   
     	;
		
		   logger("APPLIED TEAMS ");
		   display_tournament_teams_header ("Check-In Started");
		   display_tournament_teams($tournament_id,"STARTED");
		
		   logger("ROSTER SUBMITTED TEAMS ");
		   display_tournament_teams_header ("Check-In Submitted");
		   display_tournament_teams($tournament_id,"SUBMITTED");
		   
		   logger("APPROVED SUBMITTED TEAMS ");
		   display_tournament_teams_header ("Check-In Approved");
		   display_tournament_teams($tournament_id,"APPROVED");
		   
		   //logger("DENIED TEAMS ");
		   //display_tournament_teams_header ("Team Application Denied");
		   //display_tournament_teams($tournament_id,"DENIED");
		
		   //logger("WAIT LISTED TEAMS ");
		   //display_tournament_teams_header ("Team Put On Wait List");
		   //display_tournament_teams($tournament_id,"WAITLIST");
		
		   //logger("WITHDRAWN TEAMS ");
		   //display_tournament_teams_header ("Teams Withdrawn Application");
		   //display_tournament_teams($tournament_id,"WITHDRAWN");
		
		 
		   logger("REJECTED TEAMS ");
		   display_tournament_teams_header ("Check-In Rejected");
		   display_tournament_teams($tournament_id,"REJECTED");

     }
        //**********************************************************************************************************
     function main_controller_tournament_register()
     {
		   include("common_functions.php");
		
		   include("dbconnect.php");
		   include("header.php");
		
		   @session_start();
		   //print_session_details();
		
		
		   //if the login form is submitted
		   include("login.php");
		
		   if (isset($_POST['id']))
		   {
		      $tournament_id=$_POST['id'];
		   }
		   else if (isset($_GET['id']))
		   {
		      $tournament_id=$_GET['id'];
		   }
		
		   $username=$_SESSION['username'];
		   //print_array($_POST);
		   //print_array($_GET);
		
		
		   // Check that the user has right to view roster for this particular team.
		   check_user_is_tournament_admin($tournament_id,$username); 
		   display_register_exit_options();
		   
		   main_display_tournament_register($tournament_id);
		
		  
		   display_register_exit_options();
		   include("trailer.php");
 		
		   //print_session_details();
		   mysql_close();
  	 }
  

?> 
