<?php

   //**************************************************************************************************************
   function print_session_details()
   {
        return;  // Comment me out to turn loggin on
        //if the login form is submitted
        print("<P>SESSION-username:=".$_SESSION['username']."\n");
        print("<P>SESSION-password:=".$_SESSION['password']."\n");

        $safe_path = session_save_path();
        $session_id = session_id();
        $session_name = session_name();
        print("<P>session safe path:=".$safe_path."\n");
        print("<P>session id:=".$session_id."\n");
        print("<P>session name:=".$session_name."\n");
   }
    //**************************************************************************************************************
    function print_array ($array)
    {
       return;  // Comment me out to turn loggin on
       foreach($array as $item => $value)
       {
          logger("<P>".$item.":" .$value. "\n");
       } 
       
    }
    //**************************************************************************************************************
    //**********************************************************************************************************
     function display_selection_list ($namearray, $name, $current_value) {

         print("<select name=\"$name\" size=\"1\" >\n");

         foreach($namearray as $item => $value ){
            if ($item == $current_value)
            {
               print("<option selected value=\"".$item."\">".$value."</option>\n");
            }
            else
            {
               print("<option value=\"".$item."\">".$value."</option>\n");
            }   

         } 
         print("</select>\n");

         


     }
    
     //**********************************************************************************************************
     function display_selection_gender ($name,$current_value) {

         $gender_type=array("BOY" => "BOYS", 
                            "GIRL" => "GIRLS", 
                            "COED" => "COED");

         print("<select name=\"$name\" size=\"1\" >\n");

       
         foreach($gender_type as $item => $value ){

            if ($item == $current_value)
            {
               print("<option selected value=\"".$item."\">".$value."</option>\n");
            }
            else
            {
               print("<option value=\"".$item."\">".$value."</option>\n");
            }
             

         } 
         print("</select>\n");

       

     }
     //**********************************************************************************************************
     function display_selection_teams_tournament($tournament_id, $teamNameIn, $genderIn, $ageGroupIn)  {
  
       
       $select1="SELECT ta.* from tournament_accepted ta "
				 ." WHERE ta.tournament_id = '".$tournament_id."'"
                 ." AND  ta.gender = '".$genderIn."'"
                 ." AND  ta.age = '".$ageGroupIn."'"
       ;

       logger("Select SQL : ".$select1 );
       $teamarray=array();

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the edit tournaments screen </p>');

       $check = mysql_num_rows($result);
       
       //TODO Not quite sure if we should do this.
       if ($check == 0)
       {
       		$select1="SELECT ta.* from tournament_accepted ta ";
       		$result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the edit tournaments screen </p>');
       		$check = mysql_num_rows($result);
       		
       		
       }
       
        
       
       if ($check == 0)
       {
       		
       
       		print("<input type=\"text\" name=\"accepted_team\" size=\"30\"  maxlength=\"45\" value=\"".$teamNameIn."\"  />\n");
       }
       else
       {
		print("<select name=\"accepted_name\" size=\"1\" >\n");
      	       while ($row = mysql_fetch_array($result)) {
	       	        $teamName = $row['team_name'];
	       			$ageGroup = $row['age'];
	       			$gender = $row['gender'];
	          		
	        if ($teamName == $teamNameIn)
            {
               print("<option selected value=\"".$teamName."\">".$teamName."</option>\n");
            }
            else
            {
               print("<option value=\"".$teamName."\">".$teamName."</option>\n");
            }   
	          		
	       }
	    print("</select>\n");
	       
       }
       

    }
     
          //**********************************************************************************************************
     function display_selection_age_group ($name,$current_value) {

         $age_group=array("1994" => "1994 (U18)", 
                            "1995" => "1995 (U17)", 
                            "1996" => "1996 (U16)",
                            "1997" => "1997 (U15)",
                            "1998" => "1998 (U14)",
                            "1999" => "1999 (U13)",
                            "2000" => "2000 (U12)",
                            "2001" => "2001 (U11)",
                            "2002" => "2002 (U10)",
                            "2003" => "2003 (U9)"
                            );

         $date_array = getdate();
         $current_year = $date_array['year']; 
         $current_month = $date_array['month'];
         
         logger("current_month=" + $current_month);
         for ($age = 9; $age <= 19; $age++) {
            $cut_off_year=$current_year - $age;   

            $display_name = $cut_off_year."(U".$age.")";
            logger("display_name=".$display_name);
         }

         //TODO need to make this dynamic depending on the year and month
         // If > 8/1 then YYYY = YYYY + 1
         
         print("<select name=\"$name\" size=\"1\" >\n");
          foreach($age_group as $item => $value ){

            if ($item == $current_value)
            {
               print("<option selected value=\"".$item."\">".$value."</option>\n");
            }
            else
            {
               print("<option value=\"".$item."\">".$value."</option>\n");
            }
             

         } 
         print("</select>\n");

       

     }
    //**************************************************************************************************************
    function logger ($message)
    {
         print("<P>".$message."</P>\n"); // Uncomment me to turn logging on
       
    }
   //**************************************************************************************************************
     function getPageParameter($name,$defaultValue)
    {
       //logger("In getPageParameter");
       //print_array($_GET);
       if (isset($_POST[$name]))
   	   {
         $value = $_POST[$name];
       }
   	   else if (isset($_GET[$name]))
   	   {
      	 $value = $_GET[$name];
       }
       else 
       {
       	//logger("using default value");
       	 $value=$defaultValue;
       }
       return $value;
    }
    
    //**************************************************************************************************************
    //**************************************************************************************************************
    function print_webroot ()
    {
    	 global $webroot;
		 print($webroot);
      
    }
    //**********************************************************************************************************
    function print_login_screen_link()
    {
		print_sitelink("index.php","Click here to return to the login screen");
    }
    
    //**********************************************************************************************************
    function print_sitelink ($site_link, $title)
    {
    	 global $webroot;
		 
    	
    	 print("<A HREF=\"");
         print($webroot);
         print($site_link."\">".$title."</A>");
    }
    //**********************************************************************************************************
    function print_image ($filename, $width, $height)
    {
    
    	print("<a href=\"printpicture.php?file=".$filename."&width=".$width."&height=".$height."\" target=\"_blank\">");
    	
    	
    	//try and scale the image for printing in line
       	if ( $width > $height ) //landscape
    	{
    		if ($width > 750)
    		{
    			$width="750";
    			$height="544";
    		}
    	}
    	else
    	{
    		if ($width > 750)
    		{
    			$width="272";
    			$height="375";
    		}
    	}
    	
    	print("<img width=\"");
    	print($width);
    	print("\"  height=\"");
    	print($height);
    	print("\" src=\"uploads/".$filename."\"> ");
    	print("</a>");
 	   
 	   
    }
    //**********************************************************************************************************
    function print_siteformaction ($site_link)
    {
    	global $siteroot;
    	
    	// example:\"/TournamentRegistrar/useroptions.php\"
         print("\"".$siteroot.$site_link."\"");
    }
    
	//**************************************************************************************************************
    function calculate_age_group ($cut_of_year)
    {
      $date_array = getdate();
      $current_year = $date_array['year']; 
      $age_group = $current_year - $cut_of_year;
      return $age_group; 
    }
    
    //**************************************************************************************************************
    function dbConnect ()
    {
	    $hostname="localhost";
		$mysql_login="dev1";
		$mysql_password="dev1";
		$database="treg_test";

		if (!($dblink = mysql_connect($hostname, $mysql_login , $mysql_password))){
  			die("Can't connect to mysql.");    
		}else{
  			if (!($dblink = mysql_select_db("$database",$dblink)))  {
    			die("Can't connect to db.");
  			}
  		}
  		return $dblink;
		
    }

    //**************************************************************************************************************
    function handleUploadForm ($returnlink)
    {
		    //print_array($_FILES);
			// define the posted file into variables
			$name = $_FILES['picture']['name'];
			$tmp_name = $_FILES['picture']['tmp_name'];
			$type = $_FILES['picture']['type'];
			$size = $_FILES['picture']['size'];
			$associated_table = $_POST['associated_table'];
			$associated_id = $_POST['associated_id'];
			$associated_name = $_POST['associated_name'];
			
			print_array($_FILES);
			
			logger("name=".$name.
			";tmp_name=".$tmp_name.
			";type=".$type.
			";size=".$size.
			";associated_table=".$associated_table.
			";associated_id=".$associated_id.
			";associated_name=".$associated_name
			);
			
			logger("Type:".$type);
			// get the width & height of the file (we don't need the other stuff)
			list($width, $height, $typeb, $attr) = getimagesize($tmp_name);
			    
			// if width is over 600 px or height is over 500 px, kill it    
			if($width>2500 || $height>3500)
			{
				print( $name . "'s dimensions exceed the 2000x3000 pixel limit.");
				print(" ?> <a href=\"$returnlink\">Click here</a> to try again. <?") ;
				die();
			}
				
				// if the mime type is anything other than what we specify below, kill it    
			if(!(
					$type=='image/jpg' ||
					$type=='image/jpeg' ||
					$type=='image/png' ||
					$type=='image/x-png' ||  // deal with IE names
					$type=='image/gif'
				)) {
				print( $type .  " is not an acceptable format.");
				print(" ?> <a href=\"$returnlink\">Click here</a> to try again. <?") ;
				die();
			}
			
			// if the file size is larger than 350 KB, kill it
			if($size>'40000000') {
				print( $name . " is over 350KB. Please make it smaller.");
				print( "?> <a href=\"$returnlink\">Click here</a> to try again. <?") ;
				die();
			}
			// if your server has magic quotes turned off, add slashes manually
			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			// open up the file and extract the data/content from it
			$extract = fopen($tmp_name, 'r');
			$content = fread($extract, $size);
			logger("Lenghth of content".strlen($content));
			//$content = addslashes($content);
			fclose($extract);  
			
			if(!get_magic_quotes_gpc()){
				logger("Adding slashes");
				logger("Lenghth of content".strlen($content));
				$content = addslashes($content);
			}
			
			// connect to the database
			//include "connect.php";
			// let the calling process handle db connections
			logger('associated name='.$associated_name);
			
			// the query that will add this to the database
			$addfile = "INSERT INTO files (name, size, type, height, width, associated_table, associated_id, associated_name, inserted ) ".
           				"VALUES ('$name', '$size', '$type','$height','$width', '$associated_table', '$associated_id', '$associated_name', curdate())";

			//logger($addfile);
			mysql_query($addfile) or die("Failed to upload file:".mysql_error());

			// get the last inserted ID if we're going to display this image next
			$inserted_fid = mysql_insert_id(); 

			$updateFile= $inserted_fid."-".$associated_table."-".$associated_id.".".getFileExtension($name);
			logger("UpdateFile=".$updateFile); 
			
			$uploaddir = "uploads/";
			$path = $uploaddir.$updateFile;
			if(copy($_FILES['picture']['tmp_name'], $path))
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
    function getFileExtension($fileName)
    {
		return end(explode(".", $fileName));
	}
	//**************************************************************************************************************
    function uploadFileToFilesystem()
	{
			//taken from http://php.net/manual/en/features.file-upload.php
			//The files have a link on a page for downloading
			//and filenames are also put in the progress bar so
			//the file can be viewed in the browser (ie. PDF files)
			//so replace a few characters.  Since the file links are
			//loaded onto another page via php and filenames
			//are displayed, I wanted to use this method instead
			//of url_encode() [just looks funny when displayed]
			
			$SafeFile = safeFileName($HTTP_POST_FILES['ufile']['name']);
			
			
			$uploaddir = "uploads/";
			$path = $uploaddir.$SafeFile;
			
			if($ufile != none){ //AS LONG AS A FILE WAS SELECTED...
			
			    if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path)){ //IF IT HAS BEEN COPIED...
			
			        //GET FILE NAME
			        $theFileName = $HTTP_POST_FILES['ufile']['name'];
			
			        //GET FILE SIZE
			        $theFileSize = $HTTP_POST_FILES['ufile']['size'];
			
			        if ($theFileSize>999999){ //IF GREATER THAN 999KB, DISPLAY AS MB
			            $theDiv = $theFileSize / 1000000;
			            $theFileSize = round($theDiv, 1)." MB"; //round($WhatToRound, $DecimalPlaces)
			        } else { //OTHERWISE DISPLAY AS KB
			            $theDiv = $theFileSize / 1000;
			            $theFileSize = round($theDiv, 1)." KB"; //round($WhatToRound, $DecimalPlaces)
			        }
			
			echo <<<UPLS
				<table cellpadding="5" width="300">
				<tr>
				    <td align="Center" colspan="2"><font color="#009900"><b>Upload Successful</b></font></td>
				</tr>
				<tr>
				    <td align="right"><b>File Name: </b></td>
				    <td align="left">$theFileName</td>
				</tr>
				<tr>
				    <td align="right"><b>File Size: </b></td>
				    <td align="left">$theFileSize</td>
				</tr>
				<tr>
				    <td agn="right"><b>Directory: </b></td>
				    <td align="left">$uploaddir</td>
				</tr>
				</table>
			
UPLS;

		    } else {
		
				//PRINT AN ERROR IF THE FILE COULD NOT BE COPIED
				echo <<<UPLF
				<table cellpadding="5" width="80%">
				<tr>
				<td align="Center" colspan="2"><font color=\"#C80000\"><b>File could not be uploaded</b></font></td>
				</tr>
			
				</table>

UPLF;
    		}
		}
	}
	    //**********************************************************************************************************
     function updateDocument()  {
     	
       $fid = getPageParameter('fid', "");
       $associated_name = 	getPageParameter('associated_name', "");
  
       $update1="UPDATE files SET  associated_name = '$associated_name' "
                 . " WHERE fid = '$fid'" ;

       logger("Update SQL : ".update1 );
	   mysql_query($update1) or die("Failed to update with document type:".mysql_error());	
	   $msg = "File has been successfully updated";
	   logger($msg);
       
    }  
     //**********************************************************************************************************
     function deleteDocument($fid)  {
  
       $fid = getPageParameter("fid", "");
       $select1="SELECT filename "
                 . "FROM files "
                 . "WHERE fid = '".$fid."' " ;

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query when deleting document </p>');

       $check = mysql_num_rows($result);
       if (($check != 0))
       {
       	$row = mysql_fetch_array($result);
       
       	$filename=$row['filename'];
       	logger("filename=".$filename);
       
       	if(unlink("uploads/".$filename))
       	{
       	  logger("file deleted from filesystem");
      	}
       
        
	   	logger("delete document=".$fid);
       	$delete1="DELETE FROM files WHERE fid = '$fid'" ;

       	logger("Delete SQL : ".delete1 );
	   	mysql_query($delete1) or die("Failed to update with document type:".mysql_error());	
	   	$msg = "File has been successfully deleted";
	   	logger($msg);
       } 
    }  
     //**********************************************************************************************************
    function safeFileName($filenameIn)
	{
	
				$SafeFile = $filenameIn;
			$SafeFile = str_replace("#", "No.", $SafeFile);
			$SafeFile = str_replace("$", "Dollar", $SafeFile);
			$SafeFile = str_replace("%", "Percent", $SafeFile);
			$SafeFile = str_replace("^", "", $SafeFile);
			$SafeFile = str_replace("&", "and", $SafeFile);
			$SafeFile = str_replace("*", "", $SafeFile);
			$SafeFile = str_replace("?", "", $SafeFile);
			
			// if your server has magic quotes turned off, add slashes manually
			if(!get_magic_quotes_gpc()){
				$SafeFile = addslashes($SafeFile);
			}
			
			return $SafeFile;
	}
    //**************************************************************************************************************
	
    /**
	 * @desc add slashes if use MySQL and check if function addslashes is exits else
	 * return to escape string in MySQL .
	 * same way its return to stripslashes function
	 * @param string $type any string u want to insert in MySQL and display from MySQL
	 * @param string $type must be add to add slashes and strip to strip slashes
	 * @author Yousef Ismaeil - cliprz@gmail.com
	 */
	function PHP_slashes($string,$type='add')
	{
	    if ($type == 'add')
	    {
	        if (get_magic_quotes_gpc())
	        {
	            return $string;
	        }
	        else
	        {
	            if (function_exists('addslashes'))
	            {
	                return addslashes($string);
	            }
	            else
	            {
	                return mysql_real_escape_string($string);
	            }
	        }
	    }
	    else if ($type == 'strip')
	    {
	        return stripslashes($string);
	    }
	    else
	    {
	        die('error in PHP_slashes (mixed,add | strip)');
	    }
	}
	//**********************************************************************************************************
     function checkRole($user_id, $role)  {

     	logger("user_id:".$user_id);

       $select1="SELECT * FROM user_roles "
                 . "WHERE user_id = '".$user_id."' AND role in ('".$role."','SUPERUSER')"
                 . " AND approved = 'YES'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
       if ($check == 0)
       {
       		return "NO";
       }
       return "YES";
     }
	   //**********************************************************************************************************
     function check_if_super_user($user_id)  {
       $insert_required="false";
  
       logger("user_id:".$user_id);

       $select1="SELECT * FROM user_roles "
                 . "WHERE user_id = '".$user_id."' AND role = 'SUPERUSER'  AND approved = 'YES'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die("<p>".$select1. ":Invalid query Click here to return to the user options screen".mysql_error()."</p>");

       if ($result)
       {
       	 $check = mysql_num_rows($result);
       	 if ($check == 0)
       	 {
           return false;
       	 }
       	 else 
       	 {
       	 	return true;
       	 }
           
       }
       else 
       {
       	   return false;
       }
     }	

    //**********************************************************************************************************
     function check_user_is_team_admin($team_id, $user_id)  {
       global $insert_required;
       $insert_required="false";
  
       logger("team_id:".$team_id);
       logger("user_id:".$user_id);
       
       if (check_if_super_user($user_id))
       {
       	  return;
       }

       $select1="SELECT * FROM object_admin "
                 . "WHERE user_id = '".$user_id."' AND object_id = '".$team_id."'  AND object_type = 'TEAM'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
       if ($check == 0)
       {
           print("<P>You are not an admin of this team and do not have access to the requested screen.</P>\n");
           print("<P>Or your session has timed out.");
           print_login_screen_link();
           print("</P>\n");
           print("<P>If you think this is an error contact Tournament Registrar Support</P>\n ");
           print("<P><a href=\"info@tournamentclearinghouse.com\"> Tournament Clearing House Support </a></P>\n");

           exit;
       }
     }
     //**********************************************************************************************************
     function check_user_is_tournament_admin($tournament_id, $user_id)  {
  
       logger("team_id:".$tournament_id);
       logger("user_id:".$user_id);
       
       if (check_if_super_user($user_id))
       {
       	  return;
       }

       $select1="SELECT * FROM object_admin "
                 . "WHERE user_id = '".$user_id."' AND object_id = '".$tournament_id."'  AND object_type = 'TOURNAMENT'";

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1 ) or die('<p>Invalid query Click here to return to the user options screen </p>');

       $check = mysql_num_rows($result);
       if ($check == 0)
       {
           print("<P>You (".$user_id. ") are not an admin of this tournament (".$tournament_id.")");
           print("<P>and do not have access to the requested screen.</P>");
           print("<P>If you think this is an error contact Tournament Registrar Support</P> ");
           print("<P>Or your session has timed out.");
           print_login_screen_link();
           print("</P>\n");
           print("<P><a href=\"info@tournamentclearinghouse.com\"> Tournament Clearing House Support </a></P>");

           exit;
       }
     }
    //**********************************************************************************************************
    function get_document($id, $associated_table,$associated_name)  
    {
    		    $select2="SELECT * "
		                 . "FROM files "
		                 . "WHERE associated_id = '$id' " 
		                 . "AND associated_table = '$associated_table' "
		                 . "AND associated_name = '$associated_name'";
		
		       //logger("Select SQL : ".$select2 );		
		       $result2 = mysql_query($select2 ) or die('<p>Invalid query Click here to return to the user options screen </p>');
		       $check = mysql_num_rows($result2);
		       if ($check == 0)
		       {
		       		print("No Document\n");
		       }
		       else
		       {
		       	    $row = mysql_fetch_array($result2);

		       	    $filename=$row['filename'];
		       	    $width=$row['width'];
		       	    $height=$row['height'];
		       	    

		       	    
		       	    print_image($filename, $width, $height);
		       }		
		       		
		       
    }
     //**********************************************************************************************************
    
    function getImageFromDatabase()
    {
		if(isset($_GET['fid']))
		{
			// connect to the database
			include "connect.php";

			// query the server for the picture
			$fid = $_GET['fid'];
			$query = "SELECT * FROM files WHERE fid = '$fid'";
			$result  = mysql_query($query) or die(mysql_error());

			// define results into variables
			$name=mysql_result($result,0,"name");
			$size=mysql_result($result,0,"size");
			$type=mysql_result($result,0,"type");
			$content=mysql_result($result,0,"content");
			$content=removeslashes($content);

			// give our picture the proper headers...otherwise our page will be confused
			header("Content-Disposition: attachment; filename=$name");
			header("Content-length: $size");
			header("Content-type: $type");
			//echo $content;

			mysql_close();
		}else{
			die("No file ID given...");
		}

    }
     //**********************************************************************************************************
    
    function file_upload_error_message($error_code) {
	    switch ($error_code) {
	        case UPLOAD_ERR_INI_SIZE:
	            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
	        case UPLOAD_ERR_FORM_SIZE:
	            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
	        case UPLOAD_ERR_PARTIAL:
	            return 'The uploaded file was only partially uploaded';
	        case UPLOAD_ERR_NO_FILE:
	            return 'No file was uploaded';
	        case UPLOAD_ERR_NO_TMP_DIR:
	            return 'Missing a temporary folder';
	        case UPLOAD_ERR_CANT_WRITE:
	            return 'Failed to write file to disk';
	        case UPLOAD_ERR_EXTENSION:
	            return 'File upload stopped by extension';
	        default:
	            return 'Unknown upload error';
	    }
	}
  //**********************************************************************************************************
    
    
  	  $data = array();
  
	  function add_person( $first, $middle, $last, $email )
	  {
	  global $data;
	  
	  $data []= array(
	  'first' => $first,
	  'middle' => $middle,
	  'last' => $last,
	  'email' => $email 
	  );
	  }
	 //**********************************************************************************************************
    function import_excel_xml_file()
    {
	  
		  if ( $_FILES['file']['tmp_name'] )
		  {
			  $dom = DOMDocument::load( $_FILES['file']['tmp_name'] );
			  $rows = $dom->getElementsByTagName( 'Row' );
			  $first_row = true;
			  foreach ($rows as $row)
			  {
				  if ( !$first_row )
				  {
					  $first = "";
					  $middle = "";
					  $last = "";
					  $email = "";
					  
					  $index = 1;
					  $cells = $row->getElementsByTagName( 'Cell' );
					  foreach( $cells as $cell )
					  { 
						  $ind = $cell->getAttribute( 'Index' );
						  if ( $ind != null ) $index = $ind;
						  
						  if ( $index == 1 ) $first = $cell->nodeValue;
						  if ( $index == 2 ) $middle = $cell->nodeValue;
						  if ( $index == 3 ) $last = $cell->nodeValue;
						  if ( $index == 4 ) $email = $cell->nodeValue;
						  
						  $index += 1;
					  }
						  	add_person( $first, $middle, $last, $email );
				  }
					  $first_row = false;
			}
		}
	}  
    
       
?>
