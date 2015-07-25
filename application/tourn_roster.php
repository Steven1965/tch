<?php
	@session_start();


     //**********************************************************************************************************
     function display_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td><td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly>\n");
         print("</td></tr>\n");

     }
     //**********************************************************************************************************
     function display_form_row2 ($name,$title,$value,$length,$size,$type, $readonly) {

         print("<td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" size = \"$size\" value=\"$value\" $readonly>\n");
         print("</td>\n");

     }
     //**********************************************************************************************************
     function display_form_hidden_field ($name,$value) {

         print("<input type=\"hidden\" name=\"$name\" value=\"$value\" >\n");

     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_roster_header ($title,$button1,$status) {

         // this displays the result row from the team roster selection query
         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><th bgcolor=\"#6699000\" COLSPAN=8>".$title."</th></tr>\n");
         print("<tr>\n");
         //print("<th>Player Id</th>\n");
         //print("<th>Team Id</th>\n");
         print("<th bgcolor=\"#6699000\" >No.</th>\n");
         print("<th bgcolor=\"#6699000\" >First Name</th>\n");
         print("<th bgcolor=\"#6699000\" >Last Name</th>\n");
         print("<th bgcolor=\"#6699000\" >Telephone</th>\n");
         print("<th bgcolor=\"#6699000\" >D.O.B.</th>\n");
         print("<th bgcolor=\"#6699000\" >Pass No:</th>\n");
         print("<th bgcolor=\"#6699000\" >Type</th>\n");
         if ($status != "APPROVED" && $status != "SUBMITTED")
         {
         	print("<th bgcolor=\"#6699000\" >".$button1."</th>\n");
         }
         print("</tr>\n");
         

     }
     //**********************************************************************************************************
     function display_roster_row ($tournament_id, $team_id, $rowresult, $status) {

         // this displays the result row from the team slection query

         print("<tr>");
         //print("<td>".$rowresult['id']."</td>\n");
         print("<td>".$rowresult['jersey_no']."</td>\n");
         print("<td>".$rowresult['first_name']."</td>\n");
         print("<td>".$rowresult['last_name']."</td>\n");
         print("<td>".$rowresult['telephone']."</td>\n");
         print("<td>".$rowresult['date_of_birth']."</td>\n");
         print("<td>".$rowresult['player_pass_no']."</td>\n");
         print("<td>".$rowresult['type']."</td>\n");
         if ($status != "APPROVED" && $status != "SUBMITTED")
         {
         	print("<td><a href=\"tourn_roster.php?tournament_id=".$tournament_id
                                               ."&team_id=".$team_id
                                               ."&player_id=".$rowresult['id']
                                               ."&role=Team"
                                               ."&action=deleteplayer\">Delete</a></td>\n");
         }
         print("</tr>");

     }
     //**********************************************************************************************************
     function display_roster($tournament_id, $team_id, $player_type,$status)  {
  
       //logger("username:".$_POST['username']."\n");

       $select1="SELECT a.* "
                 . "FROM roster_item a, tournament_roster b "
                 . "WHERE b.team_id = '".$team_id."'  AND "
                 . "b.tournament_id = '".$tournament_id. "' AND "
                 . "a.id = b.player_id "; 

       if ($player_type == "player")
       {
          $select1=$select1." AND a.type in ('PLAYER')";
       }
       else if ($player_type == "guest" )
       {
          $select1=$select1." AND a.type = 'GUEST'";
       }
       else if ($player_type == "official" )
       {
          $select1=$select1." AND a.type not in ( 'PLAYER','GUEST')";
       }
       else
       {
          $select1=$select1.$player_type;
       }
      


       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);

       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=10>");
           print("Currently There are no players in this team roster, please use add form below to add players");
           print("</td></tr>");
          
       }
       else
       {
            while ($row = mysql_fetch_array($result)) {
              display_roster_row($tournament_id, $team_id, $row,$status);
            }
       }
       print("</table>");

    } // end function display_profile 

     //**********************************************************************************************************
     //**********************************************************************************************************
     //******* TOURNAMENT STUFF
     //**********************************************************************************************************
     //**********************************************************************************************************
     function update_status($tournament_id, $team_id, $user_id, $status, $reasons) {

  
       //logger("username:".$_POST['username']."\n");
       $event_type = "STS";
       $event_detail = "Status Changed To ".$status;

       $update1="UPDATE tournament_register "
                ." SET status = '".$status."'"
                ." WHERE team_id = '".$team_id. "'"
                ." AND tournament_id = '".$tournament_id. "'";

       logger("Update SQL : ".$update1 );
       if(!mysql_query($update1 ))
       {
           print("<p>Unable to perform user action </p>");
           $event_type = $event_type.":F";
       }

       if ($reasons != "")
       {
            $event_detail = $event_detail. " Reasons:".$reasons;
       }
       $insert1="INSERT INTO tournament_register_log "
               ."        (event_date, tournament_id, team_id, event_type, event_details, user_id) "
               ." VALUES ("
               ."CURRENT_TIMESTAMP,"
               ."'".$tournament_id ."',"
               ."'".$team_id ."',"
               ."'".$event_type ."',"
               ."'".$event_detail ."',"
               ."'".$user_id ."')";

       logger("Insert SQL : ".$insert1 );
       if (!mysql_query($insert1 ) )
       {
           print("<p>Unable to insert entry into tournament_register_log </p>");
         
       }

     }
     function  update_accepted_team_name($user_id, $tournament_id, $team_id, $accepted_name){
     	

  
       //logger("username:".$_POST['username']."\n");
       $event_type = "DTL";
       $event_detail = "Registered Name Changed to ".$accepted_name;

       $update1="UPDATE tournament_register "
                ." SET accepted_name = '".$accepted_name."'"
                ." WHERE team_id = '".$team_id. "'"
                ." AND tournament_id = '".$tournament_id. "'";

       logger("Update SQL : ".$update1 );
       if(!mysql_query($update1 ))
       {
           print("<p>Unable to perform user action </p>");
           $event_type = $event_type.":F";
       }

       
       $insert1="INSERT INTO tournament_register_log "
               ."        (event_date, tournament_id, team_id, event_type, event_details, user_id) "
               ." VALUES ("
               ."CURRENT_TIMESTAMP,"
               ."'".$tournament_id ."',"
               ."'".$team_id ."',"
               ."'".$event_type ."',"
               ."'".$event_detail ."',"
               ."'".$user_id ."')";

       logger("Insert SQL : ".$insert1 );
       if (!mysql_query($insert1 ) )
       {
           print("<p>Unable to insert entry into tournament_register_log </p>");
         
       }

     }
     //**********************************************************************************************************
     function add_comment($tournament_id, $team_id, $user_id, $comment) {

  
       //logger("username:".$_POST['username']."\n");

       $insert1="INSERT INTO tournament_register_comments "
               ."        (inserted, tournament_id, team_id, comments, user_id) "
               ." VALUES ("
               ."CURRENT_TIMESTAMP,"
               ."'".$tournament_id ."',"
               ."'".$team_id ."',"
               ."'".$comment ."',"
               ."'".$user_id ."')";


       logger("Insert SQL : ".$insert1 );
       if (!mysql_query($insert1 ))
       {
            print("<p>Failed to add user comment: </p>");
            print("<p>".$comment."</p>");
       }


       $event_type = "COM";
       $event_details = "Comment Added: ".$comment;
       $insert2="INSERT INTO tournament_register_log "
               ."        (event_date, tournament_id, team_id, event_type, event_details, user_id) "
               ." VALUES ("
               ."CURRENT_TIMESTAMP,"
               ."'".$tournament_id ."',"
               ."'".$team_id ."',"
               ."'".$event_type ."',"
               ."'".$event_details ."',"
               ."'".$user_id ."')";

       logger("Insert SQL : ".$insert2 );
       if(!mysql_query($insert2 ))
       {
           print("<p>Unable to insert entry into tournament_register_log </p>");
         
       }

     }
     //**********************************************************************************************************
     function display_tournament_roster_history($tournament_id, $team_id) {

  
       //logger("username:".$_POST['username']."\n");

       $select1="SELECT *  "
                ." FROM tournament_register_log "
                ." WHERE team_id = '".$team_id."'"
                ." AND tournament_id = '".$tournament_id. "' ORDER BY event_date DESC";

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

//| id            | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
//| event_date    | date             | YES  |     | NULL    |                |
//| tournament_id | int(10)          | NO   |     |         |                |
//| team_id       | varchar(40)      | NO   |     |         |                |
//| event_type    | varchar(5)       | NO   |     |         |                |
//| event_details | varchar(100)     | YES  |     | NULL    |                |
//| user_id       | varchar(40)      | NO   |     |         |                |

	       print("<table width=\"100%\" border=\"1\">\n");
	       print("<tr><th bgcolor=\"#6699000\" COLSPAN=5>History</th></tr>\n");
	       print("<tr>\n");
	       print("<th bgcolor=\"#6699000\" >Id</th>\n");
	       print("<th bgcolor=\"#6699000\" >Date</th>\n");
	       print("<th bgcolor=\"#6699000\" >Type</th>\n");
	       print("<th bgcolor=\"#6699000\" >Details</th>\n");
	       print("<th bgcolor=\"#6699000\" >User Id</th>\n");
	       print("</tr>\n");
	
	       if ($check == 0)
	       {
	           print("<tr>");
	           print("<td colspan=5>");
	           print("<P>Currently there are no records in the tournament log");
	           print("</td></tr>");
	          
	       }
	       else
	       {
	            while ( $row = mysql_fetch_array($result) ) {
	               print("<tr>\n");
	               print("<td>".$row['id']."</td>\n");
	               print("<td>".$row['event_date']."</td>\n");
	               print("<td>".$row['event_type']."</td>\n");
	               print("<td>".$row['event_details']."</td>\n");
	               print("<td>".$row['user_id']."</td>\n");
	               print("</tr>\n");
	            }
	
	       }
	       print("</table>");

     }
     //**********************************************************************************************************
     function display_tournament_roster_comments($tournament_id, $team_id, $role) {
  
       //logger("username:".$_POST['username']."\n");

       $select1="SELECT *  "
                ." FROM tournament_register_comments "
                ." WHERE team_id = '".$team_id."'"
                ." AND tournament_id = '".$tournament_id. "' ORDER BY INSERTED DESC" ;

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

	       print("<table width=\"100%\" border=\"1\">\n");
	       print("<tr><th bgcolor=\"#6699000\" COLSPAN=4>Comments/Additional Information</th></tr>\n");
	       print("<tr>\n");
	       print("<th bgcolor=\"#6699000\" >Id</th>\n");
	       print("<th bgcolor=\"#6699000\" >Date</th>\n");
	       print("<th bgcolor=\"#6699000\" >Comment</th>\n");
	       print("<th bgcolor=\"#6699000\" >User Id</th>\n");
	       print("</tr>\n");
	
	       if ($check == 0)
	       {
	           print("<tr>");
	           print("<td colspan=4>");
	           print("<P>Currently there are no comments");
	           print("</td></tr>");
	          
	       }
	       else
	       {
	            while ( $row = mysql_fetch_array($result) ) {
	               print("<tr>\n");
	               print("<td>".$row['id']."</td>\n");
	               print("<td>".$row['inserted']."</td>\n");
	               print("<td>".$row['comments']."</td>\n");
	               print("<td>".$row['user_id']."</td>\n");
	               print("</tr>\n");
	            }
	
	       }
	       print("</table>");
	       
	       display_add_comments($tournament_id, $team_id, $role);
 
     }
     
     //**********************************************************************************************************
     function display_add_comments($tournament_id, $team_id, $role) {
  
     
     print("<P>Add Comment </P>");
      print("<form action=\"tourn_roster.php\" method=\"post\" >\n");
      display_form_hidden_field("tournament_id",$tournament_id);
      display_form_hidden_field("team_id",$team_id);
      display_form_hidden_field("role",$role);
      
      print("<table>\n");
      print("<tr><th  bgcolor=\"#6699000\"  colspan=2>Add Comment </th></tr>\n");
 

      print("<tr>\n");
      print("<td width = \"50\" ><input type=\"submit\" name=\"addcomment\" value=\"Add Comment\" size=\"50\" ></td>\n");
      print("<td><input type=\"text\" name=\"comment\" maxlength=\"200\"  ></td>\n");
      print("</tr>\n");



      print("</table>\n");
      print("</form>\n\n");
      //print("<P><a href=\"roster.php?team_id=$team_id\">Return to Team Roster Screen</a>");
      //print("<P><a href=\"viewandeditteams.php\">Return to Team Manager Screen</a>");
     }
     //**********************************************************************************************************
     function display_team_tournaments_header ($title) {

         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><th BGCOLOR=\"#6699000\" COLSPAN=7>".$title."</th></tr>\n");
         print("<tr>\n");
         print("<th>Id</th>\n");
         print("<th>Title</th>\n");
         print("<th>Registration Deadline</th>\n");
         print("<th>Start Date</th>\n");
         print("<th>Age</th>\n");
         print("<th>Gender</th>\n");
         print("<th>Status</th>\n");
         print("</tr>\n");

     }
     //**********************************************************************************************************
     function get_team_tournament_details($tournament_id, $team_id)  {
  
//       logger("username:".$_POST['username']."\n");

       $select1="SELECT a.title, a.start_date, a.registration_deadline, b.age, b.gender, b.status, b.accepted_name "
                ." FROM tournament a, tournament_register b"
                ." WHERE b.team_id = '".$team_id."'"
                ." AND b.tournament_id = '".$tournament_id. "'"
                ." AND a.id = '".$tournament_id. "'";
                
                

       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

       if ($check == 0)
       {
       	   return;
           
       }
       else
       {
            $row = mysql_fetch_array($result);
            
            $teamdetails=array("tournament_id" => $tournament_id,
                               "title" => $row['title'],
            				   "registration_deadline" => $row['registration_deadline'],
                               "start_date" => $row['start_date'],
                               "age" => $row['age'],
                               "gender" => $row['gender'],
                               "status" => $row['status'],
                               "accepted_name" => $row['accepted_name']);
           return $teamdetails;

       }

    } 
     
     
     //**********************************************************************************************************
     function display_team_tournaments($tournament_id, $team_id, $teamdetails)  {
  
//       logger("username:".$_POST['username']."\n");

  
       display_team_tournaments_header ("Tournament");
	        
       if (!isset($teamdetails))
       {
           print("<tr>");
           print("<td colspan=7>");
           print("<P>Currently there are no current tournaments for this team,");
           print("<P>please use tournament add form below to start the registration process");
           print("</td></tr>");
          
       }
       else
       {
            print("<tr>\n");
            print("<td>".$tournament_id."</td>\n");
            print("<td>".$teamdetails['title']."</td>\n");
            print("<td>".$teamdetails['registration_deadline']."</td>\n");
            print("<td>".$teamdetails['start_date']."</td>\n");
            print("<td>".$teamdetails['age']."</td>\n");
            print("<td>".$teamdetails['gender']."</td>\n");
            print("<td>".$teamdetails['status']."</td>\n");
            print("</tr>\n");

       }
       print("</table>");

    } 
    //**********************************************************************************************************
    function display_player_documents_main($tournament_id, $team_id)
    {
		   print("<P>");
		   display_player_documents($tournament_id, $team_id,"player");
		
		   print("<P>");
		   display_player_documents($tournament_id, $team_id,"guest");
		
		   print("<P>");
		   display_player_documents($tournament_id, $team_id,"official");
    }
    //**********************************************************************************************************
    function display_player_documents($tournament_id, $team_id,$player_type)  {
  
     	
        $select1="SELECT a.* "
                 . "FROM roster_item a, tournament_roster b "
                 . "WHERE b.team_id = '".$team_id."'  AND "
                 . "b.tournament_id = '".$tournament_id. "' AND "
                 . "a.id = b.player_id "; 

       if ($player_type == "player") {
          $select1=$select1." AND a.type in ('PLAYER')";
          $title="Player";
       }
       else if ($player_type == "guest" ) {
          $select1=$select1." AND a.type = 'GUEST'";
          $title="Guest Players";
       }
       else if ($player_type == "official" ) {
          $select1=$select1." AND a.type not in ( 'PLAYER','GUEST')";
          $title="Team Officials";
       }
       else {
          $select1=$select1.$player_type;
       }
       logger("Select SQL : ".$select1 );

	   print("<table width=\"100%\" border=\"1\">\n");
	   print("<tr><th bgcolor=\"#6699000\" colspan=2><h2>".$title."</h2></th></tr>\n");
       $result = mysql_query($select1 ) or die('<p>Invalid query unable to retrieve player documents </p>');
       $check = mysql_num_rows($result);
       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=2>");
           print("Currently There are no players in this team roster, please use use import button to add players");
           print("</td></tr>");
          
       }
       else
       {
		     while ($row = mysql_fetch_array($result)) 
            {
               print("<tr><td colspan=2>".$row['last_name'].",".$row['first_name']."</td></tr>\n");
               print("<tr><td>");
		       get_document($row['id'], "roster_item", "PLYRC_FRONT" );
		       print("</td>\n");
		       print("<td>");
		       get_document($row['id'], "roster_item", "PLYRC_BACK" );
		       print("</td></tr>\n");              
           }
       }
 
       print("</table>\n");

    }  
    
    //**********************************************************************************************************
    function display_team_documents($tournament_id, $team_id)  {
  
	   		print("<table width=\"100%\" border=\"1\">\n");
	   		print("<tr><th bgcolor=\"#6699000\" colspan=1><h2>Roster Documents</h2></th></tr>\n");
    	
  
               print("<tr><td>Front of the Current Roster</td></tr>");
               print("<tr><td>");
		       get_document($team_id, "team", "RSTR_FRONT" );
		       print("</td></tr>");              
               print("<tr><td>Back of the Current Roster</td></tr>");
               print("<tr><td>");
		       get_document($team_id, "team", "RSTR_BACK" );
		        print("</td></tr>");   
		        print("<tr><td>Permission to travel</td></tr>");
               print("<tr><td>");
		       get_document($team_id, "team", "TMNT_SIGN_OFF" );
		        print("</td></tr>");             
    
          print("</table>\n");

    }  
    
    //**********************************************************************************************************
    function display_accepted_team_form($tournament_id, $team_id, $accepted_name, $gender, $agegroup)  {
    	
    	
    	print("<P align=\"left\">Please enter the team name that was you to register for the tournament </P>\n");
      
    	
       	print("\n");
		print("<form action=\"".$_SERVER['PHP_SELF']."#details\" method=\"post\" >\n");
      
    	
    	print("<table width=\"100%\" border=\"1\">\n");
	    print("<tr>\n");
        print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Registered Name</font></th><td colspan=4 >");

	    
	      display_selection_teams_tournament($tournament_id, $accepted_name, $gender, $agegroup);
	      print("</td>");
	      print("</tr>\n");
	      
	      print("<tr>\n");
        		print("<th bgcolor=\"#6699000\" colspan = 5>");	    
	    		print("<input type=\"submit\" value=\"Submit Accepted\" name=\"SubmitAccepted\">");
				print("<input type=\"reset\" value=\"Reset Changes\" name=\"Reset\">");
        		print("</th>");
	      print("</tr>\n");
	      
	    print("</table>");
	    print("<input type=\"hidden\" name=\"tournament_id\" value=\"".$tournament_id."\">\n") ;
	    print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
	    print("</form>");
		print("\n");
    }
    //**********************************************************************************************************
    function display_team_tournament_documents($tournament_id, $team_id)  {
  
       		    $select2="SELECT * "
		                 . "FROM files "
		                 . "WHERE associated_id = '$tournament_id' " 
		                 . "AND associated_table = 'tournament' ";
		
		       //logger("Select SQL : ".$select2 );
		       print("<table width=\"100%\" border=\"1\">\n");
		   	   print("<tr><th bgcolor=\"#6699000\" colspan=3></th></tr>\n");
    	
          
               
		       $result2 = mysql_query($select2 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
		       $check = mysql_num_rows($result2);
		       if ($check == 0)
		       {
		    	    print("<tr><td colspan=3>");
					print("No Tournament Documents\n");
		       		print("</td></tr>");             
		       }
		       else
		       {
		       	    while($row = mysql_fetch_array($result2))
		       	    {
		       	    	 
		       	    	
		       	    	 $select3="SELECT * "
		                 . "FROM files "
		                 . "WHERE associated_id = '$team_id' " 
		                 . "AND associated_table = 'team' "
		                 . "AND associated_name = '".$row['name']."'";
		       			$result3 = mysql_query($select3 ) or print('<p>Invalid query Click here to return to the user options screen </p>');
		       			$check3 = mysql_num_rows($result3);
		       			
		       			 
		       	    	
		       	    	
		       	    	print("<tr><th bgcolor=\"#6699000\" >Mandatory</th><td>".$row['mandatory']."</td></tr>");
		       	    	print("<tr><th bgcolor=\"#6699000\" >Description</th><td>".$row['description']."</td></tr>");
		       	    	print("<tr><th bgcolor=\"#6699000\" >Download Document</th>".
		       	    	       "<td><a href=\"uploads/".$row['filename']."\" target=\"_blank\">Click Here</a></td></tr>");
		       	    	print("<tr><th bgcolor=\"#6699000\" >Team Document Uploaded</th>");
		       	    	
		       	    	if ($check3 == 0)
		       	    	{
		       	    		print("<td>");
		       	    		print("<form action=\"".$_SERVER['PHP_SELF']."#tournamentdocs\" method=\"post\" enctype=\"multipart/form-data\" name=\"updatedocform\">\n");
		       	    		print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"650000\">\n") ;        
					        print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
					        print("<input type=\"hidden\" name=\"tournament_id\" value=\"".$tournament_id."\">\n") ;
					        print("<input type=\"hidden\" name=\"associated_name\" value=\"". $row['name']."\">\n");
					        print("<input name=\"tourndoc\" type=\"file\" id=\"document\" size=\"50\">\n") ;
							print("<input name=\"upload\" type=\"submit\" id=\"uploadtourndoc\" value=\"Upload Picture!\">\n") ;
					        print("</form>") ;
		
		       	    		print("</td>");
		
		       	    	}
		                else 
		                {
		                	$row3 = mysql_fetch_array($result3);
		                	print("<td><a href=\"uploads/".$row3['filename']."\" target=\"_blank\">Click Here To Download Document</a></td></tr>");
		                	
		                }
		       	    	
		   	   			print("<tr><th bgcolor=\"#6699000\" colspan=3></th></tr>\n");
		       	    }
  	       	        		       	   	       	    
		       }		
		       		
    
          print("</table>\n");
		       
    }	
 
    
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_tournament_manager_options ($tournament_id, $team_id, $current_status) {

      print("<P>");
      print("<form action=\"tourn_roster.php\" method=\"post\" >\n");
      print("<table>\n");
      print("<tr><th  bgcolor=\"#6699000\"  colspan=3>Tournament Manager Options </th></tr>\n");
      print("<tr>\n");
      display_form_hidden_field("tournament_id",$tournament_id);
      display_form_hidden_field("team_id",$team_id);
      display_form_hidden_field("role","Tournament");

      if ($current_status == "STARTED" )
      {
          print("<tr>\n");
          print("<td colspan=\"2\" alignment=\"center\"><input type=\"submit\" name=\"View\" value=\"Wait List\"></td>\n");
          print("<td><input type=\"submit\" name=\"acceptroster\" value=\"Accept\"></td>\n");
          print("</tr>\n");

      }
      //else if ($current_status == "ACCEPTED" )
      //{
      //    print("<tr>\n");
      //    print("<td><input type=\"submit\" name=\"waitlist\" value=\"Wait List\"></td>\n");
      //    print("</tr>\n");
      //
      //    print("<tr>\n");
      //    print("<td><input type=\"submit\" name=\"declineroster\" value=\"Decline\"></td>\n");
      //    print("<td colspan=2>\n");
      //    print("<input type=\"text\" name=\"reason\" maxlength=\"200\" size = \"50\" >\n");
      //    print("</td>\n");
      //    print("</tr>\n");
      //}
      else if ($current_status == "SUBMITTED" )
      {
 
          print("<tr>\n");
          print("<td width = \"50\" ><input type=\"submit\" name=\"approveroster\" value=\"Approve\" size=\"50\" ></td>\n");
          print("<td></td>\n");
          print("</tr>\n");
         
          print("<tr>\n");
          print("<td><input type=\"submit\" name=\"rejectroster\" value=\"Reject\" size=\"50\"></td>\n");
          print("<td><input type=\"text\" name=\"reason\" maxlength=\"200\" size=\"100\" ></td>\n");
          print("</tr>\n");
      }
      else if ($current_status == "APPROVED")
      {
          print("<tr>\n");
          print("<td><input type=\"submit\" name=\"rejectroster\" value=\"Reject\"></td>\n");
          print("<td colspan=2>\n");
          print("<input type=\"text\" name=\"reason\" maxlength=\"200\" size=\"50\" >\n");
          print("</td>\n");
          print("</tr>\n");
      }
      else if ($current_status == "REJECTED" || $current_status == "REJECT")
      {
          print("<tr>\n");
          print("<td><input type=\"submit\" name=\"approveroster\" value=\"Approve\"></td>\n");
          print("</tr>\n");
      }

      print("<tr>\n");
      print("</tr>\n");

      print("<tr>\n");
      print("<td width = \"50\" ><input type=\"submit\" name=\"addcomment\" value=\"Add Comment\" size=\"50\" ></td>\n");
      print("<td><input type=\"text\" name=\"comment\" maxlength=\"200\"  ></td>\n");
      print("</tr>\n");



      print("</tr>\n");
      print("</table>\n");
      print("</form>\n\n");
      //print("<P><a href=\"roster.php?team_id=$team_id\">Return to Team Roster Screen</a>");
      //print("<P><a href=\"viewandeditteams.php\">Return to Team Manager Screen</a>");
     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     //******* TEAM DETAIL STUFF
     //**********************************************************************************************************
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_team_row ($title,$value) {

         print("<tr><td>$title</td><td>$value<td><tr>\n");

     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_team_details($team_id, $tournament_id)  {
      $select1 = "SELECT * FROM team WHERE id = '".$team_id."'" ;
 
      $result1 = mysql_query($select1 ) or die('<p>Invalid query team does not exist</p>');

      $check = mysql_num_rows($result1);
      if ($check != 1)
      {
         print("<P> Number of rows does not equal 1 : ".$check."Team Not Found ROSTER101</P>\n");
      }
      $row = mysql_fetch_array($result1) ;


      print("\n\n<table width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#6699000\" colspan=6>Team Details</th></tr>");

      //display_team_row( "Team Id",$team_id);
      //display_team_row( "Team Name",$row['team_name']);
      //display_team_row( "club_id",$row['club_id'],"15");
      //display_team_row( "telephone",$row['telephone']);
      //display_team_row( "Website",$row['website']);
      //display_team_row( "Cut Of Year",$row['cut_off_year']);
      print("<tr>\n");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Team Id</font></th><td>".$team_id."</td>");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Team Name</font></th><td>".$row['team_name']."</td>");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Club Id</font></th><td>".$row['club_id']."</td>");
      print("</tr>\n");
      
      print("<tr>\n");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Telephone</font></th><td>".$row['telephone']."</td>");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Cell Phone</font></th><td>".$row['cellphone']."</td>");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Email</font></th><td>".$row['email']."</td>");
      print("</tr>\n");
      
      print("<tr>\n");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Gender</font></th><td>".$row['gender']."</td>");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Cut Of Year</font></th><td>".$row['cut_off_year']."</td>");
      $agegroup = calculate_age_group($row['cut_off_year']);
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Age Group</font></th><td>"."U".$agegroup."</td>");
      print("</tr>\n");
      
	  print("<tr>\n");
      print("<th bgcolor=\"#6699000\" ><font color=\"#000000\">Website</font></th><td colspan=4 >".$row['website']."</td>");
      print("</tr>\n");
     
           
      print("</table>\n");
     

      
      } // end 
     //**********************************************************************************************************
     function display_team_details2($team_id)  {
      $select1 = "SELECT * FROM team WHERE id = '".$team_id."'" ;
 
      $result1 = mysql_query($select1 ) or die('<p>Invalid query team does not exist</p>');

      $check = mysql_num_rows($result1);
      if ($check != 1)
      {
         print("<P> Number of rows does not equal 1 : ".$check."Team Not Found ROSTER101</P>\n");
      }
      $row = mysql_fetch_array($result1) ;


      print("<table width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#6699000\" colspan=6>Team Details</th></tr>\n");

      print("<tr>\n");
      	print("<td>Team Id</td><td>".$team_id."</td");
      	print("<td>Team Name</td><td>".$row['team_name']."</td");
        print("<td>Club</td><td>".$row['club_id']."</td");
      print("</tr>\n");
      
      print("<tr>\n");
      	$agegroup = calculate_age_group($row['cut_off_year']);
      	print("<td>Age Group </td><td>"."U".$agegroup."</td");
      	print("<td>Cut Of Year</td><td>".$row['cut_off_year']."</td");
      	print("<td>Gender</td><td>".$row['gender']."</td");
      print("</tr>\n");
      
      print("<tr>\n");
      	print("<td>telephone</td><td>".$row['telephone']."</td");
      	print("<td>Website</td><td>".$row['website']."</td");
      print("</tr>\n");
      print("</table>");
     
    } // end     
     //**********************************************************************************************************
     function display_team_manager_options ($tournament_id, $team_id, $current_status) {


      print("<P>\n");
      print("<form action=\"tourn_roster.php\" method=\"post\" >\n");
      display_form_hidden_field("tournament_id",$tournament_id);
      display_form_hidden_field("team_id",$team_id);
      display_form_hidden_field("role","Team");
      
      print("<table width=\"75%\">\n");
      print("<tr>\n");
      print("</tr>\n");
      print("<tr><th bgcolor=\"#6699000\" colspan=3>Team Manager Options (Current Status:".$current_status. ")</th></tr>\n");
      print("<tr>\n");
      print("</tr>\n");
      if ($current_status == "STARTED" || $current_status == "REJECTED" || $current_status == "REJECT" )
      {
          print("<tr>\n");
          print("<td><input type=\"submit\" name=\"importteam\" value=\"Import Team Roster\"></td>\n");
          print("<td><input type=\"submit\" name=\"submitroster\" value=\"Submit For Approval\"></td>\n");
          print("<td><input type=\"submit\" name=\"withdrawroster\" value=\"Withdraw Application\"></td>\n");
          print("</tr>\n");
      }
      else if ($current_status == "SUBMITTED" || $current_status == "APPROVED")
      {
          print("<tr>\n");
      	  print("<td><input type=\"submit\" name=\"restart\" value=\"Restart\"></td>\n");
          print("<td colspan=2>\n");
          print("<input type=\"text\" name=\"reason\" maxlength=\"200\" size = \"50\" >\n");
          print("</td>\n");
          print("</tr>\n");
      }
      else if ($current_status == "WAITLIST")
      {
        print("<tr>\n");
      	print("<td><input type=\"submit\" name=\"withdrawroster\" value=\"Withdraw Application\"></td>\n");
        print("</tr>\n");
      }
      print("<tr>\n");
      print("<td><input type=\"submit\" name=\"addcomment\" value=\"Add Comment\"></td>\n");
      print("<td colspan=2>\n");
      print("<input type=\"text\" name=\"comment\" maxlength=\"200\" size = \"50\" >\n");
      print("</td>\n");
      print("</tr>\n");      
      print("</table>\n");

      print("</form>\n\n");
      
      print("<P></P>");
     }





     //**********************************************************************************************************
     function delete_player($tournament_id, $team_id, $player_id)  {


        $delete1="DELETE FROM tournament_roster WHERE tournament_id = '".$tournament_id."' AND " 
                                                      ." team_id = '" .$team_id ."' AND "
                                                      ." player_id = '" .$player_id ."'";
                         
        logger("<P>Delete1 SQL:". $delete1 ."\n");

        $check = mysql_query($delete1) or die(mysql_error());

      
     }

     //**********************************************************************************************************
     function import_roster($tournament_id, $team_id)  {

        $delete1="DELETE FROM tournament_roster WHERE tournament_id = '".$tournament_id."' AND " 
                                                      ." team_id = '" .$team_id ."'";
                         
        logger("<P>Delete1 SQL:". $delete1 ."\n");

        $check = mysql_query($delete1) or die(mysql_error());



        $insert1="INSERT INTO tournament_roster (tournament_id, team_id, player_id) "
                 . "SELECT '".$tournament_id."', '".$team_id."', id FROM roster_item WHERE team_id = '".$team_id."'";
                         
        logger("<P>insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());

      
     }

     //**********************************************************************************************************
     function perform_team_manager_options($action, $team_id,$tournament_id,$username, $myarray,$current_status)
     {
        print("<H2>Tournament Check-In Management: Team Manager</H2>");
 
	    $returnlink=$_SERVER['PHP_SELF']."?tournament_id=".$tournament_id."&team_id=".$team_id;
        
        print("<table><tr>\n"); // This is used for messages following user action
        if ($action == "deleteplayer" )
        {
             logger("Deleting Player Data ");
             delete_player($tournament_id, $team_id, $myarray['player_id']); 
        }
        else if ($action == "updateacceptedteamname" )
        {
             logger("Deleting Player Data ");
             update_accepted_team_name($username, $tournament_id, $team_id, $myarray['accepted_name']); 
        }
        else if ( $action == "importteam" )
        { // if form has been submitted
             logger("Importing Team Roster to Tournament Roster");
             import_roster($tournament_id,$team_id); 
        }
        else if ( $action == "SUBMIT" )
        { // if form has been submitted
             logger("Submitting Team Roster to Tournament Roster");
             update_status($tournament_id,$team_id, $username, "SUBMITTED",""); 
             send_submit_email($tournament_id,$team_id,$username);
        }
        else if ( $action == "RESTART" )
        { // if form has been submitted
             logger("Submitting Team Roster to Tournament Roster");
             $reason=getyPageParameter("reason", "");
             update_status($tournament_id,$team_id, $username, "STARTED",$reason); 
             send_restarted_email($tournament_id,$team_id,$username);
        }
        else if ( $action == "addcomment" )
        { // if form has been submitted
             logger("Adding Comment");
             add_comment($tournament_id,$team_id, $username, $myarray['comment']); 
        }
        else if ( $action == "uploadtourndoc" )
        { 
        	  // if form has been submitted
             logger("Adding Tournament Document");
             
             handleUploadForm( $returnlink."#tournament");
             
        }
        print("</tr></table>\n"); // End status message section
        
        print("<P>");
 
        display_team_manager_options($tournament_id, $team_id,$current_status);
        
               
        return $current_status;
     }
     //**********************************************************************************************************
     function perform_tournament_manager_options($action,$team_id,$tournament_id,$username,$myarray,$current_status)
     {
      
        print("<H2>Tournament Check-In: Tournament Manager</H2>");
        check_user_is_tournament_admin($tournament_id, $username);

        print("<table><tr>\n"); // This is used for messages following user action
        if ( $action == "APPROVED"  )
        { // if form has been submitted
             logger("Accepting/Approving/Wait Listing Team Roster");
             update_status($tournament_id,$team_id, $username,$action,""); 
             send_approved_email($tournament_id,$team_id,$username);
        }
        else if ( $action == "REJECT" || $action == "DECLINE" )
        { // if form has been submitted
             logger("Importing Team Roster to Tournament Roster");
             $reasons = $myarray['reason'];
             if ($reasons == "")
             {
                   print("<P>Request Not Submitted - if rejecting/declining you must enter a reason </P>");
             }
             else
             {
                   update_status($tournament_id,$team_id, $username, $action ,$reasons); 
                   send_rejected_email($tournament_id,$team_id,$username,$reasons);
             }
            
             logger("<P> Display Tournament Managers \n");
        }
        else if ( $action == "addcomment" )
        { // if form has been submitted
             logger("Adding Comment");
             add_comment($tournament_id,$team_id, $username, $myarray['comment']); 
        }
        
        print("</tr></table>\n"); // End status message section
                
        display_tournament_manager_options($tournament_id, $team_id, $current_status);
        
        return $current_status;
     }  
   //**********************************************************************************************************
     function print_tournament_roster_exit_options($team_id,$tournament_id,$role)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	   	 
	   	 
	   	 if ($role == "TEAM")
	   	 {
	     	print("<td align=\"left\"><a href=\"useroptions.php\">Return to User Options Screen</a></td>\n");
	     	print("<td align=\"left\"><a href=\"viewandeditteams.php\">Return to Team Manager Screen</a></td>\n");
	     	print("<td align=\"left\"><a href=\"roster.php?team_id=".$team_id."\">Return to Roster Management Screen</a></td>\n");
	   	 }
	   	 else
	   	 {
	     	print("<td align=\"left\"><a href=\"useroptions.php\">Return to User Options Screen</a></td>\n");
	     	print("<td align=\"left\"><a href=\"tourn_register.php?tournament_id=".$tournament_id."\">Return to Roster Management Screen</a></td>\n");
	   	 	
	   	 }
	     print("</tr>");
	     print("<tr>");
	     print("</tr>");
	     print("</table>\n\n");
     }

     //**********************************************************************************************************
     function getAction($myarray)
     { 
	    // Actions
	    logger("getAction");
	    print_array($myarray);
	   if (isset($myarray['action']))
	   {
	        $action=$myarray['action'];
	   }
	   else if (isset($myarray['deleteplayer']))
	   {
	        $action="deleteplayer";
	   }
	   else if (isset($myarray['importteam']))
	   {
	        $action="importteam";
	   }
	   else if (isset($myarray['acceptroster']))
	   {
	        $action="ACCEPT";
	   }
	   else if (isset($myarray['declineroster']))
	   {
	        $action="DECLINE";
	   }
	   else if (isset($myarray['waitlist']))
	   {
	        $action="WAITLIST";
	   }
	   else if (isset($myarray['rejectroster']))
	   {
	        $action="REJECT";
	   }
	   else if (isset($myarray['approveroster']))
	   {
	        $action="APPROVED";
	   }
	   else if (isset($myarray['SubmitAccepted']))
	   {
	        $action="updateacceptedteamname";
	   }
       else if (isset($myarray['submitroster']))
	   {
	        $action="SUBMIT";
	   }
	   else if (isset($myarray['withdrawroster']))
	   {    //Team Manager Option
	        $action="WITHDRAW";
	   }
	   else if (isset($myarray['restart']))
	   {    // Team Manager Option
	        $action="RESTART";
	   }
	   else if (isset($myarray['addcomment']))
	   {    // Team Manager Option
	        $action="addcomment";
	   }
       else if (isset($myarray['uploadtourndoc']))
	   {    // Team Manager Option
	        $action="addcomment";
	   }
	   else 
	   {    // Team Manager Option
	        $action="noaction";
	   }
	   return $action;
   	}
   //**********************************************************************************************************
   // Main Display
   //**********************************************************************************************************
   function main_display_tournament_roster($tournament_id, $team_id, $role, $teamdetails,$current_status)
   {  	
   	
echo <<<TABSTOP
	<div id="content">

	<ol id="toc">
		<li><a href="#details"><span>Team Info</span></a></li>
		<li><a href="#roster"><span>Roster</span></a></li>
		<li><a href="#teamdocuments"><span>Team Documents</span></a></li>
		<li><a href="#tournamentdocs"><span>Tournament Documents</span></a></li>
		<li><a href="#playerdocuments"><span>Player Documents</span></a></li>
		<li><a href="#comments"><span>Comments</span></a></li>
		<li><a href="#history"><span>History</span></a></li>
	</ol>
TABSTOP;
       
       print("\n<div class=\"content\" id=\"details\">");
       
       		print("<h3>Tourament Details</h3>");       
	        display_team_tournaments($tournament_id, $team_id, $teamdetails);
	        
			print("<h3>Team Details</h3>");       
	        display_team_details($team_id, $tournament_id);
	        
	             
        	 display_accepted_team_form($tournament_id, $team_id, $teamdetails['accepted_name'], $teamdetails['gender'], $teamdetails['age']);
  
       print("</div>\n\n");  
        
	   //logger("Current Roster ");
       print("<div class=\"content\" id=\"roster\">");
		   print("<h3>Roster</h3>");       
		   display_roster_header ("Team Official", "delete",$current_status);
		   display_roster($tournament_id, $team_id,"official",$current_status);
		   display_roster_header ("Current Players", "delete",$current_status);
		   display_roster($tournament_id, $team_id, "player",$current_status);
		   display_roster_header ("Guest Players", "delete",$current_status);
		   display_roster($tournament_id, $team_id, "guest",$current_status);
       print("</div>\n\n");  

       print("<div class=\"content\" id=\"teamdocuments\">");
		   print("<h3>Team Documentation</h3>");              	     
	   	   display_team_documents($tournament_id, $team_id);
       print("</div>\n\n");  
       
       print("<div class=\"content\" id=\"tournamentdocs\">\n");
		   print("<h3>Tournament Documentation</h3>\n");              	     
	   	   display_team_tournament_documents($tournament_id, $team_id);
       print("</div>\n\n");  
	   	   
       print("<div class=\"content\" id=\"playerdocuments\">\n");
		   print("<h3>Player Or Official Documents</h3>\n");
	       display_player_documents_main($tournament_id, $team_id);
       print("</div>\n\n");  
	       
       print("<div class=\"content\" id=\"comments\">");
		   print("<h3>Comments</h3>");
       	   display_tournament_roster_comments($tournament_id,$team_id,$role);
       print("</div>\n\n");  
       	   
       print("<div class=\"content\" id=\"history\">");
		   print("<h3>History</h3>");
       	   display_tournament_roster_history($tournament_id,$team_id);
       print("</div>\n\n");  
       	   
	
       
echo <<<TABSBOTTOM
	</div>
	
	<script src="js/activatables.js" type="text/javascript"></script>
	<script type="text/javascript">
	activatables('section', ['details', 'roster', 'teamdocuments', 'tournamentdocs', 'playerdocuments', 'comments','history' ]);
	</script>
TABSBOTTOM;
       print("\n\n");
	   print_tournament_roster_exit_options($team_id,$tournament_id, $role);

	   //print_session_details();
	   mysql_close();
	   include("trailer.php");
   }
   //**********************************************************************************************************
   // Main Controller
   //**********************************************************************************************************
   
   	function main_controller_tournament_roster()
   	{
	   include("common_functions.php");
	   include("notifications.php");	
	   include("dbconnect.php");
	   include("login.php");
	   include("header.php");
	   //print_session_details();
	
	
	   //if the login form is submitted
	   login();
	   
	   if (isset($_SESSION['username']))
	   {
	   		$username=$_SESSION['username'];
	   }
	   //print_array($_POST);
	   //print_array($_GET);
	
	
	   // Check that the user has right to view roster for this particular team.
	
	   //logger("_POST");
	   //print_array($_POST);
	   //logger("_GET");
	   //print_array($_GET);
	   // POST options
	   //if the login form is submitted
	   if (isset($_POST['tournament_id'])) {
	           $myarray=$_POST;
	   }
	   else if (isset($_GET['tournament_id'])) {
	           $myarray=$_GET;
	   }
	   else
	   {
	       print("<P>TournamentId Must be set to access this screen");
	       return;         
	   }
	   
	   if (isset($myarray['team_id']))
	   {
	        $team_id=$myarray['team_id'];
	   }
	   if (isset($myarray['tournament_id']))
	   {
	        $tournament_id=$myarray['tournament_id'];
	   }
	   $role = getPageParameter("role","TEAM");
	   //logger("role=".$role);
	   
	   $action=getAction($myarray);
	   //logger("role=".$role);
	   
	   $role=strtoupper($role);
	   logger("tournament_id:".$tournament_id);
	   logger("team_id:".$team_id);
	   logger("role:".$role);
	   logger("action:".$action);
	
	   check_user_is_team_admin($team_id, $username);
	   
	   
	   $teamdetails = get_team_tournament_details($tournament_id, $team_id);
	   print_tournament_roster_exit_options($team_id,$tournament_id, $role);
	   
	   
	   if (isset($teamdetails))
	   {
	   		logger("Team Details");
	   	
		   $current_status = $teamdetails['status'];
		   // Team Manager Options
		   if ($role == "TEAM")
		   {
		   		$current_status = perform_team_manager_options($action, $team_id,$tournament_id,$username, $myarray, $current_status);		 
		   }		
		   // Tournament Manager Options
		   if ($role == "TOURNAMENT")
		   {
				$current_status = perform_tournament_manager_options($action,$team_id,$tournament_id,$username, $myarray, $current_status);
		   }
		   
		   main_display_tournament_roster($tournament_id, $team_id, $role,$teamdetails, $current_status);
	   }
   	}
   //**********************************************************************************************************
   // Main
   //**********************************************************************************************************
   main_controller_tournament_roster();
   	
?> 