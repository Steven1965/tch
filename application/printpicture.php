<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tournament Clearing House - Tabbed Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
</head>
<body id="articles">

<div id="content">

<a href="#" onclick="window.print();return false;">print</a> 


<?php

    $width=$_GET['width'];
    $height=$_GET['height'];
    $filename=$_GET['file'];
    
        //try and scale the image for printing in line
       	if ( $width > $height ) //landscape
    	{
    		if ($width > 900)
    		{
    			$width="900";
    			$height="653";
    		}
    	}
    	else
    	{
    		if ($width > 900)
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
    
?>

</div>

</body>
</html>