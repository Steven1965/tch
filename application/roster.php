<?php
	 @session_start();
	include "global.php";
	
     //**********************************************************************************************************
     function display_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td><td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly />\n");
         print("</td></tr>\n");

     }
     //**********************************************************************************************************
     function display_form_row2 ($name,$title,$value,$length,$size,$type, $readonly) {

         print("<td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" size=\"$size\" value=\"$value\" $readonly />\n");
         print("</td>\n");

     }
     //**********************************************************************************************************
     function display_form_hidden_field ($name,$value) {

         print("<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n");

     }
     

     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_roster_header ($title,$button1, $button2) {

         // this displays the result row from the team roster selection query

         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><th bgcolor=\"#6699000\" COLSPAN=10>".$title."</th></tr>\n");
         print("<tr>\n");
         print("<th bgcolor=\"#6699000\" >".$button1."</th>\n");
         print("<th bgcolor=\"#6699000\" >".$button2."</th>\n");
         //print("<th>Player Id</th>\n");
         //print("<th>Team Id</th>\n");
         print("<th bgcolor=\"#6699000\" >Jersey Number </th>\n");
         print("<th bgcolor=\"#6699000\" >First Name</th>\n");
         print("<th bgcolor=\"#6699000\" >Last Name</th>\n");
         print("<th bgcolor=\"#6699000\" >Telephone</th>\n");
         print("<th bgcolor=\"#6699000\" >Date Of Birth <p>(yyyy-mm-dd)</p></th>\n");
         print("<th bgcolor=\"#6699000\" >Pass No:</th>\n");
         print("<th bgcolor=\"#6699000\" >Type</th>\n");
         print("<th bgcolor=\"#6699000\" >Details</th>\n");
         print("</tr>\n");

     }
 
     //**********************************************************************************************************
     function display_roster_row ($rowresult) {

         // this displays the result row from the team slection query

         print("<tr>");
         print("<td><a href=\"roster.php?id=".$rowresult['id']."\"&action=delete>Delete</a></td>\n");
         print("<td><a href=\"roster.php?id=".$rowresult['id']."\"&action=modify>Modify</a></td>\n");
         print("<td>".$rowresult['id']."</td>\n");
         print("<td>".$rowresult['jersey_no']."</td>\n");
         print("<td>".$rowresult['first_name']."</td>\n");
         print("<td>".$rowresult['last_name']."</td>\n");
         print("<td>".$rowresult['telephone']."</td>\n");
         print("<td>".$rowresult['date_of_birth']."</td>\n");
         print("<td>".$rowresult['player_pass_no']."</td>\n");
         print("<td>".$rowresult['type']."</td>\n");
         print("</tr>\n");

     }
     //**********************************************************************************************************
     function display_roster_row2 ($rowresult) {
     	global $roster_item_type;
     	

         // this displays the result row from the team slection query

         //print("<tr>");
         //print("<td><a href=\"roster.php?id=".$rowresult['id']."\"&action=delete>Delete</a></td>\n");
         //print("<td><a href=\"roster.php?id=".$rowresult['id']."\"&action=modify>Modify</a></td>\n");
         //print("<td>".$rowresult['id']."</td>\n");
         //print("<td>".$rowresult['first_name']."</td>\n");
         //print("<td>".$rowresult['last_name']."</td>\n");
         //print("<td>".$rowresult['telephone']."</td>\n");
         //print("<td>".$rowresult['date_of_birth']."</td>\n");
         //print("<td>".$rowresult['player_pass_no']."</td>\n");
         //print("<td>".$rowresult['type']."</td>\n");
         //print("</tr>");

      print("<tr>");
      print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      display_form_hidden_field( "id",$rowresult['id']);
      display_form_hidden_field( "team_id",$rowresult['team_id']);
      print("<td><input type=\"submit\" name=\"modifyplayer\" value=\"Modify\"></td>\n");
      print("<td><input type=\"submit\" name=\"deleteplayer\" value=\"Delete\"></td>\n");
      //#display_form_row2( "id","Player Id",$rowresult['id'],"5","5","text","READONLY");
      //#display_form_row2( "team_id","Team Id",$rowresult['team_id'],"5","5","text","READONLY");
      display_form_row2( "jersey_no","Jersey Number",$rowresult['jersey_no'],"15","10","text","");
      display_form_row2( "first_name","First Name",$rowresult['first_name'],"15","10","text","");
      display_form_row2( "last_name","Last Name",$rowresult['last_name'],"15","10","text","");
      display_form_row2( "telephone","telephone",$rowresult['telephone'],"10","10","text","");
      display_form_row2( "date_of_birth","Date of Birth",$rowresult['date_of_birth'],"60","10","text","");
      display_form_row2( "player_pass_no","Player Pass No",$rowresult['player_pass_no'],"15","15","text","");
      print("<td>\n");
      display_selection_list($roster_item_type,"type", $rowresult['type']); 
      print("</td>\n");
      print("<td><a href=\"playerdetails.php?player_id=".$rowresult['id']."&team_id=".$rowresult['team_id']."\">Upload Player Card</a></td>\n");
      //display_form_row( "type","Type Of Player","","15","text",""); // We will make this a drop down
      print("</form>\n\n");
      print("</tr>");


     }
     //**********************************************************************************************************
     function display_roster($team_id, $player_type)  {
  
        $select1="SELECT * "
                 . "FROM roster_item "
                 . "WHERE team_id = '".$team_id."'" ;

       if ($player_type == "player")
       {
          $select1=$select1." AND type = 'PLAYER'";
       }
       else if ($player_type == "guest" )
       {
          $select1=$select1." AND type = 'GUEST'";
       }
       else if ($player_type == "official" )
       {
          $select1=$select1." AND type not in ( 'PLAYER','GUEST')";
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
              display_roster_row2($row);
            }
       }
       print("</table>\n\n");
       

    } // end function display_profile 
     //**********************************************************************************************************
     function display_add_player_form($team_id, $type)  {
     	
     global $roster_item_type;	

      print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      print("<table width=\"100%\" border=\"1\">");
      print("<tr><td colspan=2><h1>Add Player</h1></td></tr>");

      display_form_hidden_field( "team_id",$team_id);
      display_form_row( "first_name","First Name","","15","text","");
      display_form_row( "last_name","Last Name","","15","text","");
      
      if ( $type != "PLAYER" && $type != "GUEST") //team official
      {
      	display_form_row( "telephone","telephone","","10","text","");
      }
      else 
      {
      	display_form_row( "date_of_birth","Date of Birth","","60","text","");      	
      	display_form_row( "player_pass_no","Player Pass No","","15","text","");
      }
      
      print("<tr><td>$title:</td><td>\n");
      display_selection_list($roster_item_type, "type","Type Of Player");
      print("</td></tr>\n");
      //display_form_row( "type","Type Of Player","","15","text",""); // We will make this a drop down

      print("<tr><td colspan=\"2\" align=\"right\">\n");
      print("<input type=\"submit\" name=\"insertplayer\" value=\"Add\">\n");
      print("</td></tr>");
      print("</table>");
      print("</form>");
    } // end function display_profile 
     //**********************************************************************************************************
     function display_add_player_form2($team_id)  {

      //print("<table width=\"100%\" border=\"1\">");
      //print("<tr><td colspan=2><h1>Add To Roster</h1></td></tr>");
      global $roster_item_type;

      print("<tr>"); 
      print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      print("<td><input type=\"submit\" name=\"insertplayer\" value=\"Add\"></td>\n");
      print("<td><input type=\"reset\" value=\"Reset\"></td>\n");
      display_form_hidden_field( "team_id",$team_id);
      //display_form_row2( "player_id","Player Id","(auto)","5","5","text","READONLY");
      //display_form_row2( "team_id","Team Id",$team_id,"5","5","text","READONLY");
      display_form_row2( "jersey_no","Jersey Number","","5","5","text","");
      display_form_row2( "first_name","First Name","","15","10","text","");
      display_form_row2( "last_name","Last Name","","15","10","text","");
      display_form_row2( "telephone","telephone","","10","10","text","");
      display_form_row2( "date_of_birth","Date of Birth","","60","10","text","");
      display_form_row2( "player_pass_no","Player Pass No","","15","15","text","");
      print("<td>\n");
      display_selection_list($roster_item_type, "type","PLAYER"); 
      print("</td>\n");
       //display_form_row( "type","Type Of Player","","15","text",""); // We will make this a drop down

      print("</form>");
      //print("</td></tr>"); //BAD 
      print("</tr>"); //BAD 
      print("</table>");
    } // end function display_profile 

     //**********************************************************************************************************
     //**********************************************************************************************************
     //******* TOURNAMENT STUFF
     //**********************************************************************************************************
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_team_tournaments_header ($title,$button1) {

         // this displays the result row from the team roster selection query

         print("<table width=\"100%\" border=\"1\">\n");
         print("<tr><th bgcolor=\"#6699000\" COLSPAN=9>".$title."</th></tr>\n");
         print("<tr>\n");
         print("<th bgcolor=\"#6699000\">Id</th>\n");
         print("<th bgcolor=\"#6699000\">Title</th>\n");
         print("<th bgcolor=\"#6699000\">Registration<P>Deadline</P></th>\n");
         print("<th bgcolor=\"#6699000\">Start Date</th>\n");
         print("<th bgcolor=\"#6699000\">Age</th>\n");
         print("<th bgcolor=\"#6699000\">Gender</th>\n");
         print("<th bgcolor=\"#6699000\">Check-In<P>Status</P></th>\n");
         print("<th bgcolor=\"#6699000\">Next<P>Action</P></th>\n");
         print("<th bgcolor=\"#6699000\">".$button1."</th>\n");
         print("</tr>\n");

     }
     //**********************************************************************************************************
     function display_team_tournaments($team_id, $player_type)  {
  
       
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
                   display_tournament_row2($row, $row2);
               }
           }
       }
        print("</table>\n");

    } // end function display_profile 
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_tournament_row2 ($row1, $row2) {

         // this displays the result row from the registered tournament slection query

      print("<tr>");
      //print("<form action=\"tourn_roster.php\" method=\"post\" >\n");
      //print("<td><input type=\"submit\" name=\"view\" value=\"View And Edit\"></td>\n");
      //display_form_hidden_field("team_id",$row1['team_id']);
      //display_form_hidden_field("role","Team");
      //display_form_row2( "tournament_id","Tournament Id",$row1['tournament_id'],"4","4","text","READONLY");
      //display_form_row2( "title","Name",$row2['title'],"20","20","text","READONLY");
      //display_form_row2( "registration_deadline","Registration Deadline",$row2['registration_deadline'],"10","10","text","READONLY");
      //display_form_row2( "start_date","Start date",$row2['start_date'],"10","10","text","READONLY");
      //display_form_row2( "age","age",$row1['age'],"2","2","text","READONLY");
      //display_form_row2( "gender","gender",$row1['gender'],"5","5","text","READONLY");
      //display_form_row2( "status","status",$row1['status'],"10","10","text","READONLY");
      
      //display_form_hidden_field("team_id",$row1['team_id']);
      //display_form_hidden_field("role","Team");
      $currentStatus = $row1['status'];
      if ($currentStatus == "STARTED" )
      {
      	$nextAction = "Submit Check-In";
      }
      else if ($currentStatus == "REJECTED")
      {
      	$nextAction = "Fix and re-submit"; 
      }
      else if ($currentStatus == "SUBMITTED")
      {
      	$nextAction = "Wait for Approval"; 
      }
      else if ($currentStatus == "APPROVED")
      {
      	$nextAction = "Thanks you are good to go, enjoy your tournament"; 
      }
      
      
      print( "<td>".$row1['tournament_id']."</td>\n");
      print(  "<td>".$row2['title']."</td>\n");
      print(  "<td>".$row2['registration_deadline']."</td>\n");
      print(  "<td>".$row2['start_date']."</td>\n");
      print(  "<td>".$row1['age']."</td>\n");
      print(  "<td>".$row1['gender']."</td>\n");
      print(  "<td>".$row1['status']."</td>\n");
      print(  "<td>".$nextAction."</td>\n");
      print("<td><a href=\"tourn_roster.php?role=team&action=display&tournament_id=".$row1['tournament_id']."&team_id=".$row1['team_id']."\">Details</a></td>\n");
      
      
      
      print("</form>\n\n");

      print("</tr>\n\n");
     }
     //**********************************************************************************************************
     function display_team_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td>\n<td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly />\n");
         print("</td></tr>\n");

     }
     //**********************************************************************************************************
     function display_team_form_field ($name,$title,$value,$length,$type, $readonly) {

         print("<td>$title:</td>\n<td>\n");
         print("<input type=\"$type\" name=\"$name\" size=\"$length\"  maxlength=\"$length\" value=\"$value\" $readonly />\n");
         print("</td>\n");

     }
     //**********************************************************************************************************
     function display_team_form_field_with_colspan ($name,$title,$value,$length,$type, $readonly, $colspan) {

     	 print("<td>$title:</td>\n<td colspan=$colspan>\n");
         print("<input type=\"$type\" name=\"$name\" size=\"$length\"  maxlength=\"$length\" value=\"$value\" $readonly />\n");
         print("</td>\n");
     
     }
     //**********************************************************************************************************
     function display_tournament_selection_form($team_id)  {
  
      print("<form action=\"".$_SERVER['PHP_SELF']."#teamdocuments\" method=\"post\" >\n");
      print("<table width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#6699000\" colspan=5>Start Tournament Check-In</th></tr>");
      print("<tr>\n");
      print("<td><input type=\"submit\" name=\"inserttournament\" value=\"Start Check-In\"></td>\n");
      print("<td><input type=\"reset\" value=\"Reset\"></td>\n");
      display_form_hidden_field( "team_id",$team_id);
 
      print("<td>\n");
               print("<select name=\"gender\" size=\"1\" >\n");
               print("<option selected value=\"boys\">boys\n");
               print("<option selected value=\"girls\">girls\n");
               print("</select>\n");
       print("</td>\n");

      print("<td>\n");
               print("<select name=\"age\" size=\"1\" >\n");
               print("<option selected value=\"9\">U9\n");
               print("<option selected value=\"10\">U10\n");
               print("<option selected value=\"11\">U11\n");
               print("<option selected value=\"12\">U12\n");
               print("<option selected value=\"12\">U12\n");
               print("<option selected value=\"13\">U13\n");
               print("<option selected value=\"14\">U14\n");
               print("<option selected value=\"15\">U15\n");
               print("<option selected value=\"16\">U16\n");
               print("<option selected value=\"17\">U17\n");
               print("<option selected value=\"18\">U18\n");
               print("<option selected value=\"19\">U19\n");
               print("</select>\n");
       print("</td>\n");


      //ISSUE I am going to put some fancy criteria in later

       $select1="SELECT id, title from tournament ";
                 //. "WHERE id in "
                 //. "(select distinct tournament_id from tournament_age_groups " ;
                 //. "WHERE gender = '".$gender."'" ;


       logger("Select SQL : ".$select1 );
       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
       $check = mysql_num_rows($result);

       print("<td>\n");
       print("<select name=\"tournament_id\" size=\"1\" >\n");
       while ($row = mysql_fetch_array($result)) {
               print("<option selected value=\"".$row['id']."\">".$row['title']."(".$row['id'].")\n");
       }
       print("</select>\n");
       print("</td>\n");
       print("</tr>\n");
       print("</table>\n");
      print("</form>\n\n");

    } 
     //**********************************************************************************************************
     //**********************************************************************************************************
     //******* TEAM DETAIL STUFF
     //**********************************************************************************************************
     //**********************************************************************************************************
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_modify_team_form($team_id)  {
      $select1 = "SELECT * FROM team WHERE id = '".$team_id."'" ;
 
      $result1 = mysql_query($select1 ) or die('<p>Invalid query team does not exist</p>');

      $check = mysql_num_rows($result1);
      if ($check != 1)
      {
         print("<P> Number of rows does not equal 1 : ".$check."Team Not Found ROSTER101</P>\n");
      }
      $row = mysql_fetch_array($result1) ;


      print("\n<form action=\"".$_SERVER['PHP_SELF']."#details\" method=\"post\" >\n");
      print("<table width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#6699000\" colspan=6>Modify Team Details</th></tr>\n");

      print("<tr>\n");
      	display_team_form_field( "team_id","Team Id",$team_id,"10","text","READONLY");
      	display_team_form_field( "team_name","Team Name",$row['team_name'],"30","text","");
      print("</tr>\n");
      print("<tr>\n");      	
        display_team_form_field( "club_id","Club",$row['club_id'],"15","text","");
        //display_team_form_field_with_colspan( "website","Website",$row['website'],"100","text","","4");
        display_team_form_field( "website","Website",$row['website'],"60","text","");
        
      print("</tr>\n");
      
      print("<tr>\n");
      	$agegroup = calculate_age_group($row['cut_off_year']);
      	//display_team_form_field( "age_group","Age Group ","U".$agegroup,"4","text","READONLY");
      	
      	//display_team_form_field( "cut_off_year","Cut Of Year",$row['cut_off_year'],"4","text","");
      	print("<td>Cut Of Year</td>\n<td>\n");
      	display_selection_age_group( "cut_off_year",$agegroup);
	  
      	
        print("<td>Gender</td>\n<td>\n");
        display_selection_gender(gender, $row['gender']);
      	//display_team_form_field( "gender","Gender",$row['gender'],"4","text","");
      	print("</td></tr>\n");
      
        print("<tr>\n");
      	display_team_form_field( "telephone","Contact Tel:",$row['telephone'],"15","text","");
      	display_team_form_field( "cellphone","Mobile Phone",$row['cellphone'],"15","text","");
      	print("</tr>\n");
      
      	print("<tr>\n");
      	display_team_form_field_with_colspan( "email","Contact Email:",$row['email'],"50","text","", "4");
      	print("</tr>\n");
      
      
      print("<tr><td colspan=\"6\" align=\"right\">\n");
      print("<input type=\"submit\" name=\"modifyteam\" value=\"Modify\">\n");
      print("</td></tr>");
      print("</table>");
      print("</form>\n");
    } // end 

     //**********************************************************************************************************
     function display_modify_player_form($player_id)  {

      $select1="SELECT * "
                 . "FROM roster_item "
                 . "WHERE id = '".$player_id."'" ;

      logger("Select SQL : ".$select1 );

      $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

      $check = mysql_num_rows($result);
      if ($check == 0)
      {
          print("<P>Invalid Player Id\n");
          return;
      }

      $row = mysql_fetch_array($result);


      print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      print("<table width=\"100%\" border=\"1\">");
      print("<tr><th bgcolor=\"#6699000\" colspan=2>Modify Player</th></tr>");

      display_form_row( "id","Player Id",$player_id,"5","text","READONLY");
      display_form_row( "team_id","Team Id",$team_id,"5","text","READONLY");
      display_form_row( "first_name","First Name",$row['first_name'],"15","text","");
      display_form_row( "last_name","Last Name",$row['last_name'],"15","text","");
      display_form_row( "telephone","telephone",$row['telephone'],"10","text","");
      display_form_row( "date_of_birth","Date of Birth",$row['date_of_birth'],"60","text","");
      display_form_row( "player_pass_no","Player Pass No",$row['player_pass_no'],"15","text","");
      print("<tr><td>Type Of Player</td><td>\n");
      display_selection_list($roster_item_type, "type","");
      print("</td></tr>\n");
      print("<tr>");
      print("<td align=\"right\">\n");
      print("<input type=\"submit\" name=\"modifyplayer\" value=\"Modify\">\n");
      print("</td>");
      print("<td align=\"right\">");
      print("<input type=\"submit\" name=\"cancel\" value=\"Cancel\">\n");
      print("</td>");
      print("</tr>");
      print("</table>");
      print("</form>");
    } // end function display_profile 
 

     //**********************************************************************************************************
     function insert_player($team_id,$user_id)  {

        global $upsertcheck;


        $insert1="INSERT INTO roster_item "
                 ." (jersey_no,team_id,first_name,last_name,telephone,date_of_birth,player_pass_no,type) "
                 ." VALUES ( "
                 ." '".$_POST['jersey_no']."',"
                 ." '".$_POST['team_id']."',"
                 ." '".$_POST['first_name']."',"
                 ." '".$_POST['last_name']."',"
                 ." '".$_POST['telephone']."',"
                 ." '".$_POST['date_of_birth']."',"
                 ." '".$_POST['player_pass_no']."',"
                 ." '".$_POST['type']."')";
                         
        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());

      
     }

     //**********************************************************************************************************
     function insert_tournament_register($team_id)  {

        global $upsertcheck;


        $insert1="INSERT INTO tournament_register "
                 ." (tournament_id,team_id,gender,age,status) "
                 ." VALUES ( "
                 ." '".$_POST['tournament_id']."',"
                 ." '".$_POST['team_id']."',"
                 ." '".$_POST['gender']."',"
                 ." '".$_POST['age']."',"
                 ." 'STARTED')";
                         
        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());

      
     }
     //**********************************************************************************************************
     function update_player($user_id)  {

        global $upsertcheck;


        $insert1="UPDATE roster_item "
                 ." SET "
                 ." jersey_no='".$_POST['jersey_no']."',"
                 ." first_name='".$_POST['first_name']."',"
                 ." last_name='".$_POST['last_name']."',"
                 ." telephone='".$_POST['telephone']."',"
                 ." date_of_birth='".$_POST['date_of_birth']."',"
                 ." player_pass_no='".$_POST['player_pass_no']."',"
                 ." type='".$_POST['type']."'"
                 ." WHERE id = '".$_POST['id']."'";
                         
        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());

      
     }
     //**********************************************************************************************************
     function delete_player($user_id)  {

        global $upsertcheck;


        $delete1="DELETE FROM roster_item WHERE id = '".$_POST['id']."'";
                         
        logger("<P>Delete1 SQL:". $delete1 ."\n");

        $check = mysql_query($delete1) or die(mysql_error());

      
     }
     //**********************************************************************************************************
     function update_team()  {


        $update1="UPDATE team "
                 ." SET "
                 ." team_name    ='".$_POST['team_name']."',"
                 ." club_id      = '".$_POST['club_id']."',"
                 ." telephone    = '".$_POST['telephone']."',"
                 ." website      = '".$_POST['website']."',"
                 ." cut_off_year = '".$_POST['cut_off_year']."',"
                 ." cellphone =         '".$_POST['cellphone']."',"
                 ." email =         '".$_POST['email']."'"
                 ." WHERE id = '".$_POST['team_id']."'";
                         
        logger("<P>update1 SQL:". $update1 ."\n");

        $check = mysql_query($update1) or die(mysql_error());
     }
     
    //**********************************************************************************************************
     function print_roster_exit_options()  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><P><a href=\"useroptions.php\">Return to User Options Screen</a></td>");
	     print("<td align=\"left\"><td align=\"right\"><P><a href=\"viewandeditteams.php\">Return to Team Manager Screen</a></td>");
	     print("</tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
   //**********************************************************************************************************
     function display_roster_upload_form($team_id)
    {
 		global $roster_documentation_type;
    	
    	
        
    	print("\n\n<form action=\"roster.php#teamdocuments\" method=\"post\" enctype=\"multipart/form-data\" name=\"uploadform\">\n");
        print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"4000000\">\n") ;
        print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
        print("<input type=\"hidden\" name=\"associated_table\" value=\"team\">\n") ;
        print("<input type=\"hidden\" name=\"associated_id\" value=\"".$team_id."\">\n") ;
        display_selection_list($roster_documentation_type, "associated_name", "");
        print("<input name=\"picture\" type=\"file\" id=\"picture\" size=\"100\">\n") ;
		print("<input name=\"upload\" type=\"submit\" id=\"upload\" value=\"Upload Picture!\">\n") ;
		print("</form>\n\n") ;
    }
   
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_roster_documents_row ($row,$team_id) {

      print("<tr>");
      //print("<td><img width=\"100\"  height=\"100\" src=\"images/Player1CardFront.JPG\"></td>");// for testing purposes
      print("<td>");
      print_image($row['filename'], $row['width'], $row['height']);
      print("</td>");
      //print("<td><img width=\"750\"  height=\"544\" src=\"uploads/".$row['filename']."\"></td>");
      //print("<td><img  src=\"uploads/".$row['filename']."\"></td>");
      //print("<td><img src=\"getpicture.php?fid=".$row['fid']."\"></td>");
      print("</tr>\n");
      print("<tr>");
      print("<td>");
      display_roster_update_document_form($row,$team_id);
      print("</td>\n");
      //print("<td>".$row['associated_name']."</td>\n");
      //<a href=\"playerdetails.php?fid=".$rowresult['fid']."\">View ".$rowresult['associated_name']."</a></td>\n");      
      print("</tr>\n");


     }
        //********************************************************************************************************** 
    function display_roster_update_document_form($row,$team_id)
    {
 		global $roster_documentation_type;
    	
    	
        
    	print("<form action=\"roster.php#teamdocuments\" method=\"post\" enctype=\"multipart/form-data\" name=\"updatedocform\">\n");
        print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
        print("<input type=\"hidden\" name=\"fid\" value=\"".$row['fid']."\">\n") ;
        display_selection_list($roster_documentation_type, "associated_name", $row['associated_name']);
        print("<input name=\"updatedocument\" type=\"submit\" id=\"updatedocument\" value=\"Update\">\n") ;
		print("<input name=\"deletedocument\" type=\"submit\" id=\"deletedocument\" value=\"Delete\">\n") ;
		print("</form>") ;
    }  
     //**********************************************************************************************************
     function display_roster_documents($team_id)  {
  
       
       $select1="SELECT fid, associated_name, filename, width, height "
                 . "FROM files "
                 . "WHERE associated_id = '".$team_id."' " 
                 . "AND associated_table = 'team'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
	   print("<table width=\"100%\" border=\"1\">\n");
	   print("<tr><th bgcolor=\"#6699000\" colspan=2><h2>Team Documents</h2></th></tr>\n");
       if ($check == 0)
       {
           print("<tr>");
           print("<td colspan=2>");
           print("Currently There are no documents - use the upload form below to add documents");
           print("</td></tr>");
          
       }
       else
       {
            while ($row = mysql_fetch_array($result)) {
              display_roster_documents_row($row, $team_id);
            }
       }
       print("</table>\n");

    }  
    //**********************************************************************************************************
    function display_player_documents($team_id,$player_type)  {
  
     	
        $select1="SELECT a.* "
                 . "FROM roster_item a "
                 . "WHERE a.team_id = '".$team_id."'"; 

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
       $result = mysql_query($select1 ) or die('<p>Invalid query unable to retrieve player documents. </p>');
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
               print("<tr><td colspan=2>".$row['last_name'].",".$row['first_name'].":");
               print("<a href=\"playerdetails.php?player_id=".$row['id']."&team_id=".$row['team_id']."\">Upload Player Card</a>");
               print("</td></tr>\n");
      
               print("<tr><td>");
		       get_document($row['id'], "roster_item", "PLYRC_FRONT" );
		       print("</td>\n");
		       print("<td>");
		       get_document($row['id'], "roster_item", "PLYRC_BACK" );
		       print("</td></tr>\n");              
           }
       }
 
       print("</table>\n");
   //print_session_details();
       
    }  
    
     //**********************************************************************************************************
     // Main Controller
     //**********************************************************************************************************
     function main_controller_roster()
     {
		   include("common_functions.php");		
		   include("dbconnect.php");
		   include("header.php");
		   include("login.php");
		   
		   login();
		
		   if (isset($_POST['team_id']))
		   {
		      $team_id=$_POST['team_id'];
		   }
		   else if (isset($_GET['team_id']))
		   {
		      $team_id=$_GET['team_id'];
		   }
		
		   $username=$_SESSION['username'];
		   //print_array($_POST);
		   //print_array($_GET);
		
		
		   // Check that the user has right to view roster for this particular team.
		   check_user_is_team_admin($team_id,$username); 
		
		
		   //if the login form is submitted
		   if (isset($_POST['insertplayer'])) 
		   { // if form has been submitted
		        logger("Inserting Roster Data ");
		        insert_player($team_id,$username); 
		   }
		   if (isset($_POST['modifyplayer'])) 
		   { // if form has been submitted
		        logger("Inserting Roster Data ");
		        update_player($username); 
		   }
		   if (isset($_POST['deleteplayer'])) 
		   { // if form has been submitted
		        logger("Deleting Player Data ");
		        delete_player($username); 
		   }
		   if (isset($_POST['modifyteam'])) 
		   { // if form has been submitted
		        logger("Modifying Team Details Data ");
		        update_team($username); 
		   }
		   if (isset($_POST['inserttournament'])) 
		   { // if form has been submitted
		        logger("Registering For Tournament ");
		        insert_tournament_register($team_id,$username); 
		   }
		      if (isset($_POST['upload'])) 
		   { // if form has been submitted
		        logger("Uploading Data ");
		        $msg = handleUploadForm($returnlink); 
		        
		        print("<P>".$msg."<P>");
		   }
		   if (isset($_POST['updatedocument'])) 
		   { // if form has been submitted
		        logger("Updating Document Type ");
		        $msg = updateDocument(); 
		        
		        print("<P>".$msg."<P>");
		   }
		   
		   if (isset($_POST['deletedocument'])) 
		   { // if form has been submitted
		        logger("Deleting Document ");
		        $msg = deleteDocument(); 
		        
		        print("<P>".$msg."<P>");
   			}
   			
   			main_display_roster($team_id);
      	mysql_close();
   		include("trailer.php");
   
     }
     
     function main_display_roster($team_id)
     {
		print_roster_exit_options();
     	
echo <<<TABSTOP
			
	<ol id="toc">
		<li><a href="#details"><span>Team Info</span></a></li>
		<li><a href="#roster"><span>Roster</span></a></li>
		<li><a href="#tournaments"><span>Tournaments</span></a></li>
		<li><a href="#teamdocuments"><span>Team Documents</span></a></li>
		<li><a href="#playerdocuments"><span>Player Documents</span></a></li>
	</ol>
TABSTOP;
		   
		   
		print("<div class=\"content\" id=\"details\">");
			print("<h3>Team Details</h3>");       
			display_modify_team_form($team_id);
		print("</div>");  
			
		
		
		print("<div class=\"content\" id=\"roster\">");
			print("<h3>Team Details</h3>");       
			logger("Current Roster ");
		   print("<h2>Roster</h2>");
		   display_roster_header ("Team Officials", "modify","delete");
		   display_roster($team_id,"official");
		   
		   print("<P></P>");
		   display_roster_header ("Current Players", "modify","delete");
		   display_roster($team_id, "player");
		
		   print("<P></P>");
		   display_roster_header ("Current Guest Players", "modify","delete");
		   display_roster($team_id, "guest");
		
		   print("<P></P>");
		   logger("<P> Create New Roster Item \n");
		   display_roster_header ("Add To Roster", "add","reset");
		   display_add_player_form2($team_id);
		print("</div>");  
		   
		print("<div class=\"content\" id=\"tournaments\">");
			print("<h3>Team Tournaments</h3>");       
			print("<P></P>");
		   display_team_tournaments_header ("Current Tournaments", "View And Edit");
		   display_team_tournaments($team_id, "guest");
		   display_tournament_selection_form($team_id);    
		print("</div>");  
		   
		print("<div class=\"content\" id=\"teamdocuments\">");
			print("<h3>Team Details</h3>");       
		
		   //logger("Documents".$player_id);
		   print("<h2>Team Documents</h2>");
		   display_roster_documents($team_id);
		
		   print("<h2>Upload Team Documents</h2>");
		   display_roster_upload_form($team_id); 
		print("</div>");  
		   
		print("<div class=\"content\" id=\"playerdocuments\">");
			print("<h3>Team Details</h3>");       
		   print("<P>");
		   display_player_documents($team_id,"official");
		   print("<P>");
		   display_player_documents($team_id,"player");
		   print("<P>");
		   display_player_documents( $team_id,"guest");
		print("</div>");  
		   
echo <<<TABSBOTTOM

	</div>
	
	<script src="js/activatables.js" type="text/javascript"></script>
	<script type="text/javascript">
	activatables('section', ['details', 'roster', 'tournaments','teamdocuments', 'playerdocuments'  ]);
	</script>
TABSBOTTOM;
		   
		    print_roster_exit_options();
	 } 
     //**********************************************************************************************************
     // Main
     //**********************************************************************************************************
     main_controller_roster()
	     
   
?> 
