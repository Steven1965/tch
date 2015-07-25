<?php

	// Login & Session example by sde
	// connect.php
	
	// replace with your db info
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

?> 
