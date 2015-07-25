<?php

    function displayUploadForm($associated_table, $associated_id, $associated_name)
    {
    	print("<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"uploadform\">");
        print("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"350000\">") ;
        print("<input type=\"hidden\" name=\"associated_table\" value=\"".$associated_table."\">") ;
        print("<input type=\"hidden\" name=\"associated_id\" value=\"".$associated_id."\">") ;
        print("<input type=\"hidden\" name=\"associated_name\" value=\"".$associated_name."\">") ;
        print("<input name=\"picture\" type=\"file\" id=\"picture\" size=\"50\">") ;
		print("<input name=\"upload\" type=\"submit\" id=\"upload\" value=\"Upload Picture!\">") ;
		print("</form>") ;
    }

    function uploadFile()
    {
		 // if something was posted, start the process...
		
		// define the posted file into variables
		$name = $_FILES['picture']['name'];
		$tmp_name = $_FILES['picture']['tmp_name'];
		$type = $_FILES['picture']['type'];
		$size = $_FILES['picture']['size'];
		
		// get the width & height of the file (we don't need the other stuff)
		list($width, $height, $typeb, $attr) = getimagesize($tmp_name);
		    
		// if width is over 600 px or height is over 500 px, kill it    
		if($width>600 || $height>500)
		{
			print( $name . "'s dimensions exceed the 600x500 pixel limit.");
			print( "<a href=\"form.html\">Click here</a> to try again.  ");
			die();
		}
		
		// if the mime type is anything other than what we specify below, kill it    
		if(!(
			$type=='image/jpeg' ||
			$type=='image/png' ||
			$type=='image/gif'
		)) {
			print( $type .  " is not an acceptable format.");
			print( "<a href=\"form.html\">Click here</a> to try again.  ");
			die();
		}
		
		// if the file size is larger than 350 KB, kill it
		if($size>'350000') {
			print( $name . " is over 350KB. Please make it smaller.");
			print( "<a href=\"form.html\">Click here</a> to try again. "); ;
			die();
		} 
		//$associated_table, $associated_id, $associated_name
		// if your server has magic quotes turned off, add slashes manually
		if(!get_magic_quotes_gpc()){
		$name = addslashes($name);
		}
		
		// open up the file and extract the data/content from it
		$extract = fopen($tmp_name, 'r');
		$content = fread($extract, $size);
		$content = addslashes($content);
		fclose($extract);  
		
		// connect to the database
		include "connect.php";
		
		// the query that will add this to the database
		$addfile = "INSERT INTO files (name, size, type, content ) ".
		           "VALUES ('$name', '$size', '$type', '$content')";
		
		mysql_query($addfile) or die(mysql_error());
		
		// get the last inserted ID if we're going to display this image next
		$inserted_fid = mysql_insert_id();
		
		mysql_close();  
    }


     //**********************************************************************************************************
     //**********************************************************************************************************
     // Main
     //**********************************************************************************************************

	include ("global.php");
    include ("common_functions.php");
    
    if(isset($_POST['upload']))
	{
		uploadFile();
	}
	else {
    	include("header.php");
		displayUploadForm($associated_table, $associated_id, $associated_name);
    	include("trailer.php");
    }
?>
