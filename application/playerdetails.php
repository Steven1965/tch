<?php

    @session_start();

	include "global.php";

     //**********************************************************************************************************
     function display_form_row ($name,$title,$value,$length,$type, $readonly) {

         print("<tr><td>$title:</td><td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" value=\"$value\" $readonly>\n");
         print("</td></tr>\n");

     }

     
     //**********************************************************************************************************
     function display_form_row2 ($name,$title,$value,$length,$size,$type, $readonly) {

         print("<td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" size=\"$size\" value=\"$value\" $readonly>\n");
         print("</td>\n");

     }
     //**********************************************************************************************************
     function display_form_hidden_field ($name,$value,$readonly) {

         print("<input type=\"hidden\" name=\"$name\" value=\"".$value."\" $readonly>\n");

     }
     //**********************************************************************************************************
     function display_details_type_selection2 ($name,$current_value) {
     	global $roster_item_type;

         print("<tr><td>$title:</td><td>\n");
         display_selection_list($roster_item_type, $name, $current_value);

         print("</select></td></tr>\n");
       

     }
     //**********************************************************************************************************
     function display_details_row2 ($name,$title,$value,$length,$size,$type, $readonly) {

         print("<tr><td>$title</td>\n");
         print("<td>\n");
         print("<input type=\"$type\" name=\"$name\" maxlength=\"$length\" size=\"$size\" value=\"$value\" $readonly>\n");
         print("</td></tr>\n");

     }
 
     //**********************************************************************************************************
     function display_roster_trailer () {

         // this displays the result row from the team slection query

         print("</table>\n");

     }
     //**********************************************************************************************************
     function display_documents_row2 ($row,$player_id, $team_id) {

      print("<tr>");
      //print("<td><img width=\"100\"  height=\"100\" src=\"images/Player1CardFront.JPG\"></td>");// for testing purposes
      print("<td><img width=\"200\"  height=\"150\" src=\"uploads/".$row['filename']."\"></td>");
      //print("<td><img src=\"getpicture.php?fid=".$row['fid']."\"></td>");
      print("<td>");
      displayPlayerUpdateDocumentForm($row,$player_id,$team_id);
      print("</td>\n");
      //print("<td>".$row['associated_name']."</td>\n");
      //<a href=\"playerdetails.php?fid=".$rowresult['fid']."\">View ".$rowresult['associated_name']."</a></td>\n");      
      print("</tr>\n");


     }
        //********************************************************************************************************** 
    function displayPlayerUpdateDocumentForm($row,$player_id,$team_id)
    {
 		global $player_documentation_type;
    	
    	
        
    	print("<form action=\"playerdetails.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"updatedocform\">\n");
        print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
        print("<input type=\"hidden\" name=\"player_id\" value=\"".$player_id."\">\n") ;
        print("<input type=\"hidden\" name=\"fid\" value=\"".$row['fid']."\">\n") ;
        display_selection_list($player_documentation_type, "associated_name", $row['associated_name']);
        print("<P><input name=\"updatedocument\" type=\"submit\" id=\"updatedocument\" value=\"Update\">\n") ;
		print("<input name=\"deletedocument\" type=\"submit\" id=\"deletedocument\" value=\"Delete\"></P>\n") ;
		print("</form>") ;
    }  
     //**********************************************************************************************************
     function display_documents($player_id,$team_id)  {
  
       
       $select1="SELECT fid,associated_name, filename "
                 . "FROM files "
                 . "WHERE associated_id = '".$player_id."' " 
                 . "AND associated_table = 'roster_item'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
	   print("<table width=\"100%\" border=\"1\">\n");
	   print("<tr><th bgcolor=\"#6699000\" colspan=2><h2>Player Documents</h2></th></tr>\n");
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
              display_documents_row2($row,$player_id, $team_id);
            }
       }
       print("</table>\n");

    }  
    
 
     //**********************************************************************************************************
     function display_modify_player_details_form($player_id)  {

       $select1="SELECT * "
                 . "FROM roster_item "
                 . "WHERE id = '".$player_id."' "; 

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
       if ($check == 0)
       {
           print("<table width=\"100%\" border=\"1\">");
	       print("<tr><th bgcolor=\"#6699000\" colspan=2><h2>Modify Player Details</h2></th></tr>");
	       print("<tr>");
           print("<td colspan=2>");
           print("Currently There are no players in this team roster, please use add form below to add players");
           print("</td></tr>");
           print("</tr>");  
           print("</table>");
            
       }
       else
       {
	        print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
       	    print("<table width=\"100%\" border=\"1\">");
	        print("<tr><th bgcolor=\"#6699000\" colspan=2><h2>Modify Player Details</h2></th></tr>");
	        $row = mysql_fetch_array($result);
	       //print_array($row);
	      	print("<tr>"); 
	        print("<td><input type=\"submit\" name=\"modifyplayer\" value=\"Modify\"></td>\n");
	        print("<td><input type=\"reset\" value=\"Reset\"></td>\n");
	        print("</tr>");  
            display_details_row2("player_id","Player Id",$row['id'],"5","5","text","READONLY");
	        display_details_row2( "team_id","Team Id",$row['team_id'],"5","5","text","READONLY");
	        display_details_row2( "jersey_no","Jersey Number",$row['jersey_no'],"5","5","text","");
	        display_details_row2( "first_name","First Name",$row['first_name'],"15","10","text","");
	        display_details_row2( "last_name","Last Name",$row['last_name'],"15","10","text","");
	        display_details_row2( "telephone","telephone",$row['telephone'],"10","10","text","");
	        display_details_row2( "date_of_birth","Date of Birth",$row['date_of_birth'],"60","10","text","");
	        display_details_row2( "player_pass_no","Player Pass No",$row['player_pass_no'],"15","15","text","");
	        display_details_type_selection2 ("type","Type",$row['type']);
	        //display_form_row( "type","Type Of Player","","15","text",""); // We will make this a drop down
	        print("</table>\n");
            print("</form>\n");
	    
	      
       }
      
    } //  

   
 

     
    //**********************************************************************************************************
     function print_playerdetails_exit_options($team_id)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><P><a href=\"useroptions.php\">Return to User Options Screen</a></td>");
	     print("<td align=\"left\"><td align=\"right\"><P><a href=\"viewandeditteams.php\">Return to Team Manager Screen</a></td>");
	     print("<td align=\"left\"><td align=\"center\"><P><a href=\"roster.php?team_id=".$team_id."\">Return to Roster Management Screen</a></td>");
	   	 print("</tr>");
	     print("<tr>");
	     print("</tr>");
	     print("</table>");
     }
    //**********************************************************************************************************
     
    function displayPlayerUploadForm($player_id,$team_id)
    {
 		global $player_documentation_type;
    	
    	
        
    	print("\n\n<form action=\"playerdetails.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"uploadform\">\n");
        print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"650000\">\n") ;
        print("<input type=\"hidden\" name=\"team_id\" value=\"".$team_id."\">\n") ;
        print("<input type=\"hidden\" name=\"player_id\" value=\"".$player_id."\">\n") ;
        print("<input type=\"hidden\" name=\"associated_table\" value=\"roster_item\">\n") ;
        print("<input type=\"hidden\" name=\"associated_id\" value=\"".$player_id."\">\n") ;
        display_selection_list($player_documentation_type, "associated_name", "");
        print("<input name=\"picture\" type=\"file\" id=\"picture\" size=\"100\">\n") ;
		print("<input name=\"upload\" type=\"submit\" id=\"upload\" value=\"Upload Picture!\">\n") ;
		print("</form>\n\n") ;
    }
    
 
     //**********************************************************************************************************
     //**********************************************************************************************************
     // Main
     //**********************************************************************************************************
   
   include("common_functions.php");
   include("playerDAO.php");

   include("dbconnect.php");
   include("header.php");
   include("login.php");
   
   login();
   
   $player_id = getPageParameter("player_id", "None");
   $team_id = getPageParameter("team_id", "None");
   
   $returnlink = $_SERVER['PHP_SELF']."?player_id=".$player_id."&team_id=".$team_id;
   logger("returnlink=".$returnlink);
   

   $username = $_SESSION['username'];
   print_array($_POST);
   //print_array($_GET);
   
   //logger("team_id=".$team_id);
   //logger("player_id=".$player_id);
   

   // Check that the user has right to view roster for this particular team.
   check_user_is_team_admin($team_id,$username); 
   
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
   
   print_playerdetails_exit_options($team_id);
   //logger("Team Details");
   display_modify_player_details_form($player_id);


   //logger("Documents".$player_id);
   print("<h2>Player Documents</h2>");
   display_documents($player_id,$team_id);

   print("<h2>Upload Player Documents</h2>");
   displayPlayerUploadForm($player_id,$team_id);
   
   print_playerdetails_exit_options($team_id);
    
   mysql_close();
    
   //print_session_details();
   include("trailer.php");

?> 
