<?php
// Login & Session example by sde
// logout.php

// you must start session before destroying it
  include("global.php");
  include("common_functions.php");

 
	@session_start();		
	@session_destroy();
	
	echo "You have been successfully logged out.
	
	<br><br>
	You will now be returned to the login page.
	
	<META HTTP-EQUIV=\"refresh\" content=\"2; URL=";
	print_siteformaction("index.php");
	echo "> ";



?> 
