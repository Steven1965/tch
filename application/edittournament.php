<?php
    include "global.php";

    //**************************************************************************************************************
    function print_text_box_readonly($title, $name, $size){
       print("<tr>\n");
       print("<td>".$title."</td>\n");
       print("<td><input type=\"text\" name=\"".$name."\" size=\"" .$size."\" value = \"".$_POST[$name]."\" readonly></td>\n");
       print("</tr>\n");
    }
    //**************************************************************************************************************
    function print_text_box($title, $name, $size){
       print("<tr>\n");
       print("<td>".$title."</td>\n");
       print("<td><input type=\"text\" name=\"".$name."\" size=\"" .$size."\" value = \"".$_POST[$name]."\"></td>\n");
       print("</tr>\n");
    }
    //**************************************************************************************************************
    function print_date_box($title, $name){
       print("<tr>\n");
       print("<td>".$title."</td>\n");
       print("<td><input type=\"text\" name=\"".$name."\" size=\"12\" value = \"".$_POST[$name]."\">\n");
       //print("<A HREF=\"#\" onClick=\"cal1.select(document.forms[0].date1,'anchor1','MM/dd/yyyy'); return false;\" \n");
       //print("       TITLE=\"cal1.select(document.forms[0].date1,'anchor1','MM/dd/yyyy'); return false;\" \n");
       //print("       ID=\"anchor1\">select</A>\n");
       print("Format yyyy-mm-dd</td>");       
       print("</tr>\n");
    }
    
    //**************************************************************************************************************
    function tournament_details_form_fields()
    {
    	print("<table border=\"1\">\n");
		print_text_box("Title","title","100");
		print_text_box("Address 1","address_1","50");
		print_text_box("Address 2","address_2","50");
		print_text_box("City","city","50");
		print_text_box("State","state","2");
		print_text_box("ZIP","zip","5");
		print_text_box("Telephone","telephone","13");
		print_text_box("Fax","fax","13");
		print_text_box("Email","email","100");
		print_text_box("Website","website","100");
		print_date_box("Registration Deadline", "registration_deadline");
		print_date_box("Check-In Deadline", "checkin_deadline");
		print_date_box("Start Date", "start_date");
		print_date_box("End Date", "end_date");
		print("</table>\n");
    }
    //**************************************************************************************************************
    function tournament_details_create(){
       
		
		
		print("\n");
		print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
		print("\n");
		tournament_details_form_fields();		
	    print("\n");
	    age_group_form_fields();
     	print("<input type=\"submit\" value=\"Submit Changes\" name=\"create\">");
		print("<input type=\"reset\" value=\"Reset Changes\" name=\"Reset\">");
	    print("</form>");
		print("\n");
		print("\n");


    }
    
    
    
    //**************************************************************************************************************
    function tournament_details($tournament_id){
       
		$action="update";
		if (isset($tournament_id))
		{
			$action="insert";
		}
		
		print("\n");
		print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
		print("<input type=\"hidden\" name=\"id\" value=\"".$tournament_id."\">\n") ;
		print("\n");
		tournament_details_form_fields();
		print("<input type=\"submit\" value=\"Submit Changes\" name=\"updatedetails\">");
		print("<input type=\"reset\" value=\"Reset Changes\" name=\"Reset\">");
	    print("</form>");
		print("\n");
		print("\n");


    }

    //**************************************************************************************************************
    function tournament_details_create_dummy_data()
    {
        $_POST['id'] = "";
        $_POST['title'] = "Enter Title Here";
        $_POST['address_1'] = "";
        $_POST['address_2'] = "";
        $_POST['city'] = "";
        $_POST['state'] = "";
        $_POST['zip'] = "";
        $_POST['registration_deadline'] = "";
        $_POST['checkin_deadline'] = "";
        $_POST['start_date'] = "";
        $_POST['end_date'] = "";
        $_POST['telephone'] = "";
        $_POST['fax'] = "";
        $_POST['email'] = "";
        $_POST['website'] = "";

        age_group_create_dummy_data("boys");
        age_group_create_dummy_data("girls");
        //print_array($_POST);
    }
    //**************************************************************************************************************
    function age_group_create_dummy_data($gender) 
    {
        $current_year=date("Y");
        for ($age = 9; $age <= 19; $age++) {
          $cut_off_year=$current_year - $age;
          $checkboxname="Select".$age.$gender;
          $cutoffdatename="CutOfDate".$age.$gender;
          $costname="Cost".$age.$gender;
          $_POST[$checkboxname]="1";
          $_POST[$cutoffdatename] =$cut_off_year."-08-01";
          $_POST[$costname] ="495";
       }
    }
    //**************************************************************************************************************
    function age_group_main($tournament_id){
    	
    	
       print("\n");
	   print("<form action=\"".$_SERVER['PHP_SELF']."?id=".$tournament_id."#section=agegroups\" method=\"post\" >\n");
	   print("<input type=\"hidden\" name=\"id\" value=\"".$tournament_id."\">\n") ;
        
	   print("\n");
	   age_group_form_fields();
	   
       print("<input type=\"submit\" value=\"Submit Changes\" name=\"updateagegroups\">");
	   print("<input type=\"reset\" value=\"Reset Changes\" name=\"Reset\">");
	   print("</form>");
	   print("\n");
	   print("\n");
       

    }
    //**************************************************************************************************************
    function age_group_form_fields(){
       print("\n<table width=\"448\">\n");
       print("<caption><b>Available Age Group Competitions</b></caption>\n");
       print("\n");
       print("<tr>\n");
       print("<th>Boys</th>\n");
       print("<th></th>\n");
       print("<th>Girls</th>\n");
       print("\n");
       print("</tr>\n");
       print("\n");
       print("<tr>\n");
       age_group_details_display("boys");
       print("<td>\n");
       print("</td>\n");
       age_group_details_display("girls");
       print("</tr>\n");
       print("</table>\n");
    }
    //**************************************************************************************************************
    //**************************************************************************************************************
    function age_group_print_header(){
       //print("<tr>\n");
       //print("<td>\n");
       //print("<table border=\"1\">\n");
       print("<tr>\n");
       print("<th>Selected</th>\n");
       print("<th>Age </th>\n");
       print("<th>Cut Off Date</th>\n");
       print("<th>Cost</th>\n");
       print("</tr>\n");
    }

    //**************************************************************************************************************
    //**************************************************************************************************************
    function age_group_details_display($gender){
       //print_array($_POST);

       $current_year=date("Y");
       print("<td>\n");
       print("<table border=\"1\">\n");
       //print("<table>\n");
       age_group_print_header();
       for ($age = 9; $age <= 19; $age++) {
          $cut_off_year=$current_year - $age;
          //$cut_off_date=$cut_off_year."-08-01";
          $checkboxname="Select".$age.$gender;
          $cutoffdatename="CutOfDate".$age.$gender;
          $costname="Cost".$age.$gender;
          $costvalue="";
          if (isset($_POST[$costname]))  $costvalue = $_POST[$costname];
          $cut_off_date="";
          if (isset($_POST[$cutoffdatename])) $cut_off_date=$_POST[$cutoffdatename];
          $checkboxvalue="";
          if (isset($_POST[$checkboxname])) $checkboxvalue = $_POST[$checkboxname];
          
          
          $checked="";
          if ($checkboxvalue == "1") {
              $checked="checked";
          }
          
          print("<tr>\n");
          print("<td align=\"center\"> <input type=\"checkbox\" name=\"".$checkboxname."\" value=\"1\" ".$checked." ></td>\n");
          print("<td>".$age."</td>\n");
          print("<td><input type=\"text\" name=\"".$cutoffdatename."\" value=\"".$cut_off_date."\" size=\"12\"></td>\n");
          print("<td><input type=\"text\" name=\"".$costname."\" value=\"".$costvalue."\" size=\"10\"></td>\n");
          print("</tr>\n");
          print("\n");
       }
       print("</table>\n");
       print("</td>\n");
    }

    //**********************************************************************************************************
    function document_upload_form($tournament_id)
    {
 		global $tournament_documentation_type;
    	
 		
 		//print_array($tournament_documentation_type);
    	
        
    	print("\n\n<form action=\"".$_SERVER['PHP_SELF']."?id=".$tournament_id."#section=documents\" method=\"post\" enctype=\"multipart/form-data\" name=\"uploadform\">\n");
        
        print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"4000000\">\n") ;
        print("<input type=\"hidden\" name=\"id\" value=\"".$tournament_id."\">\n") ;
        print("<input type=\"hidden\" name=\"associated_table\" value=\"tournament\">\n") ;
        print("<input type=\"hidden\" name=\"associated_id\" value=\"".$tournament_id."\">\n") ;
    	print("<table>");
    	
    	print("<tr>");
    	print("<td>File to load</td>");
        print("<td>"); 
        print("<input name=\"document\" type=\"file\" id=\"document\" size=\"75\">\n") ;
    	print("</td>");
        print("</tr>");
        
    	print("<tr>");
    	print("<td>Document Type</td>");
        print("<td>"); 
        display_selection_list($tournament_documentation_type, "associated_name", "");
        print("</td>");
        print("</tr>");
        print("<tr><td>Description</td>");
        print("<td>"); 
        print("<input type=\"text\" size=\"75\" name=\"description\" value=\"Enter description of the document here\">\n") ;
        print("</td><tr>"); 
        
		print("<tr><td>Is Mandatory</td>");
        print("<td>"); 
        print("<input type=\"checkbox\" name=\"mandatory\" value=\"Y\">\n") ;
        print("</td><tr>"); 
        
    	
		print("<tr><td colspan=2>");
        print("<input name=\"uploaddocument\" type=\"submit\"  value=\"Upload Document!\">\n") ;
        print("</td><tr>"); 
        print("</table>");
        
		print("</form>\n\n") ;
    }
    //**********************************************************************************************************
    function document_handle_upload_form ($tournament_id)
    {
		    //print_array($_FILES);
			// define the posted file into variables
			$name = $_FILES['document']['name'];
			$tmp_name = $_FILES['document']['tmp_name'];
			$type = $_FILES['document']['type'];
			$size = $_FILES['document']['size'];
			$associated_table = $_POST['associated_table'];
			$associated_id = $_POST['associated_id'];
			$associated_name = $_POST['associated_name'];
			$description = $_POST['description'];
			$mandatory = $_POST['mandatory'];
			
			//print_array($_FILES);
			
			logger("name=".$name.
			";tmp_name=".$tmp_name.
			";type=".$type.
			";size=".$size.
			";associated_table=".$associated_table.
			";associated_id=".$associated_id.
			";associated_name=".$associated_name.
			";description=".$description.
			";mandatory=".$mandatory
			);
			
			logger("Type:".$type);
			
			
			// if the file size is larger than 350 KB, kill it
			if($size>'40000000') {
				print( $name . " is over 350KB. Please make it smaller.");
				print( "?> <a href=\"".$_SERVER['PHP_SELF']."?action=edit&id=".$tournament_id."#section=documents\">Click here</a> to try again. <?") ;
				die();
			}
			// if your server has magic quotes turned off, add slashes manually
			if(!get_magic_quotes_gpc()){
				$description = addslashes($description);
			}

			// open up the file and extract the data/content from it
			$extract = fopen($tmp_name, 'r');
			$content = fread($extract, $size);
			logger("Lenghth of content".strlen($content));
			//$content = addslashes($content);
			fclose($extract);  
			
			//if(!get_magic_quotes_gpc()){
			//	logger("Adding slashes");
			//	logger("Lenghth of content".strlen($content));
			//	$content = addslashes($content);
			//}
			
			// connect to the database
			//include "connect.php";
			// let the calling process handle db connections
			logger('associated name='.$associated_name);
			
			// the query that will add this to the database
			$addfile = "INSERT INTO files (name, size, type, height, width, content, associated_table, associated_id, associated_name, inserted, description, mandatory ) ".
           				"VALUES ('$name', '$size', '$type','$height','$width', 'see file','$associated_table', '$associated_id', '$associated_name', curdate(),'$description', '$mandatory' )";

			//logger($addfile);
			mysql_query($addfile) or die("Failed to upload file:".mysql_error());

			// get the last inserted ID if we're going to display this image next
			$inserted_fid = mysql_insert_id(); 

			$updateFile= $inserted_fid."-".$associated_table."-".$associated_id.".".getFileExtension($name);
			logger("UpdateFile=".$updateFile); 
			
			$uploaddir = "uploads/";
			$path = $uploaddir.$updateFile;
			if(copy($_FILES['document']['tmp_name'], $path))
			{
				
				$updatefile = "UPDATE files SET filename='$updateFile' WHERE fid = '$inserted_fid'";
				mysql_query($updatefile) or die("Failed to update with filename:".mysql_error());	
				$msg = "File has been successfully uploaded";
				logger($msg);
				
			}		
			else
			{
				$msg = "Failed to copy file";
				logger($msg);
			}
			
			
			return $msg;
    }
    //**************************************************************************************************************
    function documents_get($tournament_id )
    {
           $select1="SELECT fid, associated_name, filename, description, type, size, mandatory "
                 . "FROM files "
                 . "WHERE associated_id = '".$tournament_id."' " 
                 . "AND associated_table = 'tournament'";

       logger("Select SQL : ".$select1 );
       
       $documentarray = array();
       

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the edit tournaments screen </p>');

       $check = mysql_num_rows($result);
       
       
       if ($check != 0)
       {       		
       		while ($row = mysql_fetch_array($result)) {
       			$document = array("filename" => $row['filename'], 
       			                    "type" => $row['type'], 
       			                    "description" => $row['description'],
       								"mandatory" => $row['mandatory'],
       			                    "fid" => $row['fid']);
       			array_push($documentarray, $document);   
       		}
       		return $documentarray;
       }
       else 
       {
       	  unset($documentarray);
       	  return;
       }
    }   
    //**********************************************************************************************************
     function documents_main($tournament_id)  {
  
       
       

	   $documentarray = documents_get($tournament_id);
	   
	   //print_array($documentarray);
	   
	   
	   print("<table  border=\"1\">\n");
	   //print("<tr><th bgcolor=\"#6699000\" colspan=3><h2>Documents</h2></th></tr>\n");
       print("<tr>");
       print("<th bgcolor=\"#6699000\">Mandatory</th>");
       print("<th bgcolor=\"#6699000\">Filename</th>");
       print("<th bgcolor=\"#6699000\">Description</th>");
       print("<th bgcolor=\"#6699000\">Delete?</th>");
       print("</tr>\n");
      if (!isset($documentarray))
       {
           print("<tr>");
           print("<td colspan=4>");
           print("Currently There are no documents - use the upload form below to add documents");
           print("</td></tr>");
          
       }
       else
       {
       	      foreach ($documentarray as $row)
       	      {
              	documents_print_row($row, $tournament_id);
       	      }
            
       }
       
       
       print("</table>\n");
       
       print("<P align=\"right\" >To upload a document use the form below. Enter a detailed description of how the form is to be used by the team. If the form is required then select mandatory.</P>");
   	   document_upload_form($tournament_id); 


    }

  
    //**********************************************************************************************************
    function accepted_teams_upload_form($tournament_id)
    {
 		global $tournament_documentation_type;
    	
    	
        
    	print("\n\n<form action=\"".$_SERVER['PHP_SELF']."?id=".$tournament_id."#section=accepted\" method=\"post\" enctype=\"multipart/form-data\" name=\"importform\">\n");
        print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"4000000\">\n") ;
        print("<input type=\"hidden\" name=\"id\" value=\"".$tournament_id."\">\n") ;
        print("<input name=\"document\" type=\"file\" id=\"document\" size=\"75\">\n") ;
		print("<input name=\"importaccepted\" type=\"submit\"  value=\"Import Accepted!\">\n") ;
		print("</form>\n\n") ;
    }  
    //**********************************************************************************************************
    function accepted_teams_handle_upload_form($tournament_id)
    {
			//print_array($_FILES);
			// define the posted file into variables
			$name = $_FILES['document']['name'];
			$tmp_name = $_FILES['document']['tmp_name'];
			$type = $_FILES['document']['type'];
			$size = $_FILES['document']['size'];
			//$tournament_id = $_POST['tournament_id'];
			
			print_array($_FILES);
			
			logger("name=".$name.
			";tmp_name=".$tmp_name.
			";type=".$type.
			"size=".$size.
			";tournament_id=".$tournament_id
			);
			
			logger("Type:".$type);
			// get the width & height of the file (we don't need the other stuff)
			
			if(!(
					$type=='application/octet-stream' 
				)) {
				print( $type .  " is not an acceptable file ttype.");
				print(" ?> <a href=\"".$_SERVER['PHP_SELF']."?action=edit&id=".$tournament_id."#section=accepted\">Click here</a> to try again. <?") ;
				die();
			}
			
			
			
			$teamarray = accepted_teams_read_from_file($tmp_name);
			
			print_array($teamarray);
			
			accepted_teams_insert($tournament_id, $teamarray);
			
			
			
			
			return $teamarray;
    }    
    //**************************************************************************************************************
    function accepted_teams_insert($tournament_id,$teamarray){

       
       $delete="DELETE FROM tournament_accepted WHERE tournament_id = '".$tournament_id."'";
       $check = mysql_query($delete) or die(mysql_error());
                 
       logger("entered accepted_team_insert");          
       foreach ($teamarray as $team) {
           $insert1="INSERT INTO tournament_accepted "
                 ."(tournament_id, team_name, age, gender, email)"
                 ." VALUES ( "
                 ."'".$tournament_id."',"
                 ."'".$team[0]."',"
                 ."'".$team[1]."',"
                 ."'".$team[2]."',"
                 ."'".$team[3]."'
                 )";

        	logger("<P>Insert1 SQL:". $insert1 ."\n");
        	$check = mysql_query($insert1);
        	
        	
        	logger("Mysql error=".mysql_error());
       }
    }

     
    //**************************************************************************************************************
    function accepted_teams_main($tournament_id){
    	
   	
	   $teamarr = accepted_teams_get($tournament_id);
       //print("<table border=\"1\">\n");
       print("<table border=\"1\">\n");
       print("<tr>\n");
          		print("<th bgcolor=\"#6699000\">Team Name</th>\n");
          		print("<th bgcolor=\"#6699000\">Age</th>\n");
          		print("<th bgcolor=\"#6699000\">Gender</th>\n");
        		print("<th bgcolor=\"#6699000\">Email</th>\n");
        		print("<th bgcolor=\"#6699000\">Status</th>\n");
       print("</tr>\n");
       
       if (isset($teamarr))
       {
	       foreach ($teamarr as $team) {
	       		print("<tr>\n");
	          		print("<td>".$team[0]."</td>\n"); 
	          		print("<td>".$team[1]."</td>\n");
	          		print("<td>".$team[2]."</td>\n");
	          		print("<td>".$team[3]."</td>\n");
	          		print("<td>".$team[4]."</td>\n");
	          		print("</tr>\n");
	       }
       }
       else 
       {
       	   print("<tr>\n");
	          		print("<td colspan=5><P>There are currently no teams imported into the accepted list</P>");
	          		print("<P>Use the import form below</P></td>\n");
	       print("</tr>\n");
       }
       print("</table>\n");
       
       print("<P align=\"left\">Import accepted fields from comma separated file</P>");
   	   print("<P align=\"left\">To download a template file <a href=\"uploads/AcceptedTemplate.csv\">Click Here</a> </P>");
   	   accepted_teams_upload_form($tournament_id); 
 

          
         
       
    }
    
    //**************************************************************************************************************
    function accepted_teams_send_reminder($tournament_id){
    	
   	
	   $teamarr = accepted_teams_get($tournament_id);
	   
	   if (isset($teamarr))
	   {
	       foreach ($teamarr as $team) {
	       	
	       		if ($status != "APPROVED" && $status != "SUBMITTED")
	       		{
	       			$teamname = $team[0];
	       			$email = $team[3];
	       			$status = $team[4];
	       			send_reminder_email($tournament_id, $teamname, $registered_email, $team_id);
	   				print("<P>Sent notification email to team ".$teamname." with email".$email." status is".$status."</P>\n");
	       		}
	       }
	   }
    }
    
     
     
    //**********************************************************************************************************
    function documents_print_row ($row,$tournament_id) {

      print("<tr>");
      print("<td>".$row['mandatory']."</td>");
      print("<td>".$row['filename']."</td>");
      print("<td>".$row['description']."</td>");
      print("<td><a href=\"".$_SERVER['PHP_SELF']."?action=deletedocument&id=".$tournament_id.
                           "&fid=".$row['fid'].
                           "#section=documents\"#details\">Delete</a></td>");
      print("</tr>\n");
      

     }
    //**********************************************************************************************************
    
    function getTournamentId() {
     
       if (isset($_POST['id']))
       {
           $tournament_id=$_POST['id'];
       }
       else if (isset($_GET['id']))
       {
           $tournament_id=$_GET['id'];
       }
       else if (isset($_GET['tournament_id']))
       {
           $tournament_id=$_GET['tournament_id'];
       }
       else if (isset($_POST['tournament_id']))
       {
           $tournament_id=$_POST['tournament_id'];
       }
       return $tournament_id;
     }
    //**************************************************************************************************************
    function main_display ($tournament_id){ 
    	//
    	echo "";
echo <<<TABSTOP
			
	<ol id="toc">
		<li><a href="#details"><span>Details</span></a></li>
		<li><a href="#agegroups"><span>Age Groups</span></a></li>
		<li><a href="#documents"><span>Documents</span></a></li>
		<li><a href="#accepted"><span>Accepted Teams</span></a></li>
		<li><a href="#register"><span>Register</span></a></li>
	</ol>
TABSTOP;

	print ("<div class=\"content\" id=\"details\"><h3>Tournament Details</h3>");	       
	   tournament_details($tournament_id);    	
   	print("<p>To view or enter the age group details<a href=\"#agegroups\">Click Here</a></p></div>");
	   
	print ("<div class=\"content\" id=\"agegroups\"><h3>Age Groups</h3>");	       
	   age_group_main($tournament_id);
   	print("<p>To view or enter the tournament documents<a href=\"#documents\">Click Here</a></p></div>");
	   
	print ("<div class=\"content\" id=\"documents\"><h3>Documents</h3>");	       
		documents_main($tournament_id);
   	print("<p>To view or enter the accepted teams<a href=\"#accepted\">Click Here</a></p></div>");
       
	print ("<div class=\"content\" id=\"accepted\"><h3>Accepted Teams</h3>");	
       print("<P>Click here to send reminder email <a href=\"edittournament.php?action=sendreminder&id=".$tournament_id."\">Send Reminder</a></P>");		
       accepted_teams_main($tournament_id);          
    print("<p class=\"important\">To view the current registration details <a href=\"#register\">Click here</a>.</p></div>");
       
	print ("<div class=\"content\" id=\"register\"><h3>Register</h3>");	 
       print("<P>Click here to export register <a href=\"edittournament.php?action=export&id=".$tournament_id."\">export</a></P>");	
       main_display_tournament_register($tournament_id);          
    print("<p class=\"important\">To return to the main page <a href=\"#details\">Click here</a>.</p></div>");
    
       
echo <<<TABSBOTTOM

	
	<script src="js/activatables.js" type="text/javascript"></script>
	<script type="text/javascript">
	activatables('section', ['details', 'agegroups', 'documents', 'accepted','register']);
	</script>
TABSBOTTOM;

 
    	
   		
    }
    //**************************************************************************************************************
    //| id                    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    //| owner_user_id         | varchar(40)      | NO   |     |         |                |
    //| title                 | varchar(100)     | YES  |     | NULL    |                |
    //| registration_deadline | date             | NO   |     |         |                |
    //| checkin_deadline       | date             | NO   |     |         |                |
    //| start_date            | date             | NO   |     |         |                |
    //| end_date              | date             | NO   |     |         |                |
    //| address_1             | varchar(50)      | YES  |     | NULL    |                |
    //| address_2             | varchar(50)      | YES  |     | NULL    |                |
    //| city                  | varchar(50)      | YES  |     | NULL    |                |
    //| zip                   | varchar(10)      | YES  |     | NULL    |                |
    //| state                 | varchar(2)       | YES  |     | NULL    |                |
    //| telephone              | varchar(13)      | YES  |     | NULL    |                |
    //| fax                   | varchar(13)      | YES  |     | NULL    |                |
    //| email                 | varchar(100)     | YES  |     | NULL    |                |
    //| website               | varchar(100)     | YES  |     | NULL    |                |
    //$_POST['id']
    //$_POST['owner_user_id']
    //$_POST['title']
    //$_POST['registration_deadline']
    //$_POST['checkin_deadline']
    //$_POST['start_date']
    //$_POST['end_date,']
    //$_POST['address_1']
    //$_POST['address_2']
    //$_POST['city']
    //$_POST['zip']
    //$_POST['state']
    //$_POST['telephone']
    //$_POST['fax']
    //$_POST['email']
    //$_POST['website']
    //
    //+---------------+------------------+------+-----+---------+-------+
    //| Field         | Type             | Null | Key | Default | Extra |
    //+---------------+------------------+------+-----+---------+-------+
    //| tournament_id | int(10) unsigned | NO   | PRI |         |       |
    //| gender        | varchar(5)       | NO   | PRI |         |       |
    //| age           | int(5)           | NO   | PRI |         |       |
    //| cut_of_date   | date             | YES  |     | NULL    |       |
    //| cost          | int(5)           | YES  |     | NULL    |       |
    //| selected      | int(1)           | YES  |     | NULL    |       |
    //|
    //tournament_id, gender, age, cut_of_date, cost, selected

    //$_POST['tournament_id']
    //$_POST['gender']
    //$_POST['age']
    //$_POST['cut_of_date']
    //$_POST['cost']
    //$_POST['selected']


    //**************************************************************************************************************
    function age_group_insert($tournament_id, $gender){
       //print_array($_POST);

       for ($age = 9; $age <= 19; $age++) {
          $checkboxname="Select".$age.$gender;
          $cutoffdatename="CutOfDate".$age.$gender;
          $costname="Cost".$age.$gender;
          $cost=$_POST[$costname];
          $cut_off_date=$_POST[$cutoffdatename];
          $selected=$_POST[$checkboxname];
          
          $insert1="INSERT INTO tournament_age_groups "
                 ."(tournament_id, gender, age, cut_off_date, cost, selected)"
                 ." VALUES ( "
                 ."'".$tournament_id."',"
                 ."'".$gender."',"
                 ."'".$age."',"
                 ."'".$cut_off_date."',"
                 ."'".$cost."',"
                 ."'".$selected."')";

        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());
       }
    }
 
    //**************************************************************************************************************
     function tournament_details_insert($user_id)  {

        global $upsertcheck;

        $insert1="INSERT INTO tournament "
                 ."(owner_user_id, title, registration_deadline, checkin_deadline, start_date, end_date,"
                 ."address_1, address_2, city, zip, state, telephone, fax, email, website)"
                 ." VALUES ( "
                 ."'".$user_id."',"
                 ."'".$_POST['title']."',"
                 ."'".$_POST['registration_deadline']."',"
                 ."'".$_POST['checkin_deadline']."',"
                 ."'".$_POST['start_date']."',"
                 ."'".$_POST['end_date,']."',"
                 ."'".$_POST['address_1']."',"
                 ."'".$_POST['address_2']."',"
                 ."'".$_POST['city']."',"
                 ."'".$_POST['zip']."',"
                 ."'".$_POST['state']."',"
                 ."'".$_POST['telephone']."',"
                 ."'".$_POST['fax']."',"
                 ."'".$_POST['email']."',"
                 ."'".$_POST['website']."')";
                         
        logger("<P>Insert1 SQL:". $insert1 ."\n");

        $check = mysql_query($insert1) or die(mysql_error());
        $id = mysql_insert_id(); 
        $_POST['id']=$id; 


        $insert2="INSERT INTO object_admin "
                 ." (object_id,user_id,object_type,type) "
                 ." VALUES ( '".$id."',"
                 ." '".$user_id."',"
                 ." 'TOURNAMENT','OWNER')";
   
        logger("<P>Insert1 SQL:". $insert2 ."\n");
   
   
        $check = mysql_query($insert2) or die(mysql_error());

        age_group_insert($id,"boys");
        age_group_insert($id,"girls");
        print("<P> Tournament Successfully Inserted </P>");
        
        return $id;
      
     }
     //**********************************************************************************************************
     function accepted_teams_read_from_file($filename )  {
       $fp = fopen($filename, "r") or die("Couldn't open $filename");
       $teamarray = array();
       $linecount = 1;
       while (!feof($fp)) {
	      //$chunk = fread($fp, 8);
	      $line=fgets($fp,80);	      
	      logger($line."<br/>");
          if ($linecount > 1) // ignore the first line
          {          	
                $team1 = accepted_teams_read_line($line);
                if (isset($team1)) array_push($teamarray, $team1); 
          }                   
          $linecount++;
          
       } // end line read loop 
       fclose($fp); 

       return $teamarray;
       
             
     } 
     //**********************************************************************************************************
     function accepted_teams_read_line($line )  {
     	  $delims = ",";      
          $word = strtok($line, $delims);
          $count = 1;
          while (is_string($word)) {
	          	   
		           //if ($word) {
			       //logger($count.":".$word."<br/>");
		           //}
	          	   switch ($count) {
	          	   	case 1:
	                    $teamName = trim($word);
	                    $teamName = str_replace('"','',trim($word)); 
	          	   		break;
	          	   	case 2:	
	          	   		$ageGroup = str_replace('"','',trim($word));;
	          	   		break;
	          	   	case 3:
	          	   		$gender = str_replace('"','',trim($word));;          	   	
	          	   		break;
	          	   	case 4:
	          	   		$contactEmail = str_replace('"','',trim($word));;          	   	
	          	   	break;
	          	   		default :
	          			//echo "ignore:".$word;
	          			break;
	          	   }   
		           $word = strtok($delims);
	          	   $count++;
          } // end tokenizer loop
          if ($count < 4)
          {
          	logger( "Token Count=".$count." Incorrect line=".$line );
          	return;         	
          }
          else 
          {
          	logger( "teamName:".$teamName." ageGroup:".$ageGroup." gender:".$gender." contactEmail:".$contactEmail);
          	$team1 = array($teamName, $ageGroup, $gender, $contactEmail);
          	return $team1;
          }
     }
     
     
     //**********************************************************************************************************
     function accepted_teams_get($tournament_id)  {
  
       
       $select1="SELECT ta.team_name, ta.age, ta.gender, ta.email,tr.status, tr.team_id from tournament_accepted ta "
				." LEFT JOIN tournament_register tr "
				." ON tr.accepted_name = ta.team_name "
				." WHERE ta.tournament_id = '".$tournament_id."'";

       logger("Select SQL : ".$select1 );
       $teamarray=array();

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the edit tournaments screen </p>');

       $check = mysql_num_rows($result);
       
       if ($check == 0)
       {
       	  unset($teamarray);
	      return;
       }
       else
       {
	       while ($row = mysql_fetch_array($result)) {
	       	        //print_array($row);
	       	        $teamName = $row['team_name'];
	       			$ageGroup = $row['age'];
	       			$gender = $row['gender'];
	       			$email = $row['email'];
	       			if (isset($row['status']))
	       			{
	       				$status = $row['status'];
	       			}
	       			else 
	       			{
	       				$status = "NOT FOUND";
	       			}
	       			 
	       			
	            	logger( "teamName:".$teamName." ageGroup:".$ageGroup." gender:".$gender." contactEmail:".$email." status:".$status);
	          		$team1 = array($teamName, $ageGroup, $gender, $email, $status);
	          		array_push($teamarray, $team1);  
	       }
	        return $teamarray;
       }
               

    }

  //**************************************************************************************************************
    function age_group_update($tournament_id){
       
        age_group_update_gender($tournament_id,"boys");
        age_group_update_gender($tournament_id,"girls");
    }
    //**************************************************************************************************************
    function age_group_update_gender($tournament_id, $gender){
       //print_array($_POST);

       for ($age = 9; $age <= 19; $age++) {
          $checkboxname="Select".$age.$gender;
          $cutoffdatename="CutOfDate".$age.$gender;
          $costname="Cost".$age.$gender;
          $cost=""; 
          if (isset($_POST[$costname]))  $cost = $_POST[$costname];
          $cut_off_date="";
          if (isset($_POST[$cutoffdatename])) $cut_off_date=$_POST[$cutoffdatename];
          $selected="";
          if (isset($_POST[$checkboxname])) $selected = $_POST[$checkboxname];
          
          $update1="UPDATE tournament_age_groups "
                 ."SET "
                 ."cut_off_date = '".$cut_off_date."',"
                 ."cost = '".$cost."',"
                 ."selected = '".$selected."'"
                 ."WHERE "
                 ."tournament_id = '".$tournament_id."' AND "
                 ."gender = '".$gender."' AND "
                 ."age = '".$age."'";

        logger("<P>update1 SQL:". $update1 ."\n");

        $check = mysql_query($update1) or print("<P>Unable to update tournament age groups (".mysql_error().")</P>");
       }
    }

    //**************************************************************************************************************
     function tournament_details_update()  {

        global $upsertcheck;

        $update1="UPDATE tournament "
                 ."SET "
                 ."title = '".$_POST['title']."',"
                 ."registration_deadline = '".$_POST['registration_deadline']."',"
                 ."checkin_deadline = '".$_POST['checkin_deadline']."',"
                 ."start_date = '".$_POST['start_date']."',"
                 ."end_date = '".$_POST['end_date,']."',"
                 ."address_1 = '".$_POST['address_1']."',"
                 ."address_2 = '".$_POST['address_2']."',"
                 ."city = '".$_POST['city']."',"
                 ."zip = '".$_POST['zip']."',"
                 ."state ='".$_POST['state']."',"
                 ."telephone ='".$_POST['telephone']."',"
                 ."fax = '".$_POST['fax']."',"
                 ."email = '".$_POST['email']."',"
                 ."website = '".$_POST['website']."'"
                 ."WHERE "
                 ."id = '".$_POST['id']."'";
                         
        logger("<P>update1 SQL:". $update1 ."\n");

        $check = mysql_query($update1) or die(mysql_error());

        print("<P> Tournament Successfully Updated </P>");
      
     }
    //**************************************************************************************************************
    function age_group_get($tournament_id){
       //print_array($_POST);


       $select1="SELECT * "
                 . "FROM tournament_age_groups "
                 . "WHERE tournament_id = '".$tournament_id."'" ;

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);


       while ($row = mysql_fetch_array($result)) {
          $postfix=$row['age'].$row['gender'];
          $costname="Cost".$postfix;
          $cutoffdatename="CutOfDate".$postfix;
          $checkboxname="Select".$postfix;
          $_POST[$costname]=$row['cost'];
          $_POST[$cutoffdatename]=$row['cut_off_date'];
          $_POST[$checkboxname]=$row['selected'];
       }

    } 
    //**************************************************************************************************************
    function tournament_details_get($tournament_id){
       //print_array($_POST);


       $select1="SELECT * "
                 . "FROM tournament "
                 . "WHERE id = '".$tournament_id."'" ;

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);


       $row = mysql_fetch_array($result);
       foreach($row as $item => $value)
       {
          $_POST[$item]=$value;
       }
       age_group_get($tournament_id);

    } // 
    //**********************************************************************************************************
     function tournament_export_file($tournament_id, $filename)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr><td>");
	   	 
	   	 if (isset($filename))
	   	 {
		   	 print("<P><a href=\"".$filename."\" target=\"_blank\">Click Here To Download Document</a></P>");
		 }
		 else
		 {
		   	 print("<P>Unable to export file</P>");
		 }
	     print("<P>Click here to return to the tournament details <a href=\"edittournament.php?action=edit&id=".$tournament_id."\">Return</a></P>");
	   	 
	     print("</td></tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
    
    
     //**********************************************************************************************************
     function tournament_delete_confirmation($tournament_id)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><P>Are you sure you want to delete the tournament all data will be lost. <a href=\"edittournament.php?action=deleteconfirmed&id=".$tournament_id."\">Yes</a>");
	     print("<P>If you wish to keep the tournament click here to view the tournament details<a href=\"edittournament.php?action=edit&id=".$tournament_id."\">Cancel</a></td>");
	     print("</tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
     //**********************************************************************************************************
     function tournament_send_reminder_confirmation($tournament_id)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\">Are you sure you want to send a reminder email to all teams <a href=\"edittournament.php?action=sendreminderconfirmed&id=".$tournament_id."\">Yes</a>");
	     print("<P><a href=\"edittournament.php?action=edit&id=".$tournament_id."#accepted\">Cancel</a></td>");
	     print("</tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
    //**********************************************************************************************************
     function tournament_exit_options($tournament_id)  {

	     print("<table width=\"100%\" border=\"0\">");
	   	 print("<tr>");
	     print("<td align=\"left\"><a  align=\"left\" href=\"useroptions.php\">Return to User Options Screen</a></td>");
	     //print("<td align=\"center\"><a align=\"center\" href=\"tourn_mgr.php\">Return to Tournament Manager Screen</a></td>");
	     print("<td align=\"right\"><a align=\"right\" href=\"edittournament.php?action=edit&id=".$tournament_id."\">Refresh</a></td>");	   
	     print("</tr>\n");
	     print("<tr>");
	     print("</tr>\n");
	     print("</table>\n");
     }
    //**************************************************************************************************************
     function tournament_delete($tournament_id)  {

        global $upsertcheck;

        $delete1="DELETE FROM tournament WHERE id = '".$tournament_id."'";
        logger("<P>delete1 SQL:". $delete1 ."\n");

        $check = mysql_query($delete1) or die(mysql_error());

        $delete2="DELETE FROM tournament_age_groups WHERE tournament_id = '".$tournament_id."'";
        logger("<P>delete2 SQL:". $delete2 ."\n");

        $check = mysql_query($delete2) or die(mysql_error());

        $delete2="DELETE FROM object_admin WHERE object_id = '".$tournament_id."' AND object_type = 'TOURNAMENT'";
        logger("<P>delete2 SQL:". $delete2 ."\n");

        $check = mysql_query($delete2) or die(mysql_error());

        print("<P> Tournament Successfully Deleted </P>");
      
     }
    //**************************************************************************************************************
     function main_controller()
    {
       include("common_functions.php");
	   include("tourn_register_common.php");
       include("dbconnect.php");
	   include("notifications.php");
	   //if the login form is submitted
	   include("login.php");
	   
	   if (!isset($_SESSION[$username]))
	   {
	   	@session_start();
	   }
	   
	
	
	   include("header.php");
	   
	
	   $username=$_SESSION['username'];
	   
	   $tournament_id = getTournamentId();
	   
	   
	   
	   tournament_exit_options($tournament_id);
	   
	   $action = getPageParameter("action", "view");
	   if ( checkRole($username, "TOURNAMENT_MANAGER") != "YES")
	   {
	   	   print("<P>You (".$username.")are not an Tournament Manager and do not have access to the requested screen.</P>\n");
           print("<P>Or your session has timed out.");
           print_login_screen_link();
           print("</P>\n");
           print("<P>If you think this is an error contact :</P>\n ");
           print("<P><a href=\"info@tournamentclearinghouse.com\"> Tournament Clearing House Support </a></P>\n");
	   }
	   else if ($action ==  "new" ) 
	   { // if form has been submitted
	        print("<h1>Creating New Tournament </h1> \n");
	        tournament_details_create_dummy_data();
	        unset($tournament_id);
	        tournament_details_create($tournament_id);
	        
	   } 
	   else if (isset($_POST['create']) ) 
	   { // if form has been submitted
		   		print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		        
		   		print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        $tournament_id = tournament_details_insert($username);
		        print("<P>Message Successfully created</P>\n");
		        print("</div>");
		        tournament_details_get($tournament_id); 
		        main_display($tournament_id);
	   } 
	   else { 
			// Check that the user has right to view roster for this particular team.
   	   	   check_user_is_tournament_admin($tournament_id,$username); 
	   	
	   
		   if ($action == "edit") 
		   { // if form has been submitted
		        print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		        tournament_details_get($tournament_id);
		        main_display($tournament_id);
	
		   } 
		   else if ($action == "copy") 
		   { // if form has been submitted
	
		        print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		   		print ("<div class=\"messages\" id=\"messages\">");	
		   		tournament_details_get($tournament_id); 
		               		   		
		        $tournament_id = tournament_details_insert($username);	        
		        print("</div>");
		        tournament_details_get($tournament_id);
		        main_display($tournament_id);
		        
		   } 
		   else if (isset($_POST['updatedetails'])) 
		   { // if form has been submitted
		        print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        tournament_details_update();
		        //print("<P>Tournament details successfully updated \n");
		        print("</div>");
		        tournament_details_get($tournament_id);	        
		        main_display($tournament_id);
		   } 
		   else if (isset($_POST['updateagegroups'])) 
		   { // if form has been submitted
		        print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");		        
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        age_group_update($tournament_id);
		        print("<P>Age Group data successfully updated \n");
		        print("</div>");
		        tournament_details_get($tournament_id);	        
		        main_display($tournament_id);
		   }
	       else if (isset($_POST['importaccepted'])) 
		   { // if form has been submitted
		   	    print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        
		        accepted_teams_handle_upload_form($tournament_id);
		        print("</div>");
		        tournament_details_get($tournament_id);	        
		        main_display($tournament_id);
		   } 
	       else if (isset($_POST['uploaddocument'])) 
		   { // if form has been submitted
		        print("<h1>View And Edit Tournament (ID:".$tournament_id.")</h1>\n");
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        document_handle_upload_form($tournament_id);
		        tournament_details_get($tournament_id);	        
		        print("</div>");
		        main_display($tournament_id);
		   } 
	   	   else if ($action == "export") 
		   { // if form has been submitted
		        $filename = export_tournament_teams($tournament_id);
		        tournament_export_file($tournament_id,$filename);		     
		   }
	   	   else if ($action == "sendreminder") 
		   { // if form has been submitted
		        tournament_send_reminder_confirmation($tournament_id);		     
		   }
	       else if ($action == "sendreminderconfirmed") 
		   { // if form has been submitted
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        accepted_teams_send_reminder($tournament_id);
		        tournament_details_get($tournament_id);	        
		        print("</div><br>");
		        main_display($tournament_id);
		   }
		   else if ($action == "delete") 
		   { // if form has been submitted
		        print("<h3> Delete Tournament </h3>\n");
		        //TODO need to print confirmation message before deleting
		        tournament_delete_confirmation($tournament_id);
		   }
	       else if ($action == "deleteconfirmed") 
		   { // if form has been submitted
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        tournament_delete($tournament_id);
		        print("<P align=\"left\">Tournament Successfully Deleted!!<a href=\"tourn_mgr.php\">Return to Tournament Manager Screen</a></P>");
		   		print("</div>");
		   }
	       else if ($action == "deletedocument") 
		   { // if form has been submitted
		        //TODO need to print confirmation message before deleting
		        $fid = getPageParameter("fid", "");	        	     
		        print ("<div class=\"messages\" id=\"messages\">");	       		   		
		        deleteDocument($fid);
		        print("<P>File Successfully deleted \n");
		        tournament_details_get($tournament_id);	  
		        print("</div>");
		        main_display($tournament_id);      
		   }	   	   
		   else
		   {
		       print("<P>No Tournament Edit Screen Entered - You must provide a valid command to access this screen");
		   }
	   }
	   tournament_exit_options($tournament_id);
	   mysql_close();
	   include("trailer.php");
    }
    //**************************************************************************************************************
    // Main
    //**************************************************************************************************************
    main_controller();
?>



