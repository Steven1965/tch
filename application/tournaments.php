<?php

     function display_tournament_selection_form()  {
  
     print("<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >\n");
      print("<table width=\"100%\" border=\"1\">");
	      print("<tr><th bgcolor=\"#418246\" colspan=2>Search For Tournament</th></tr>");
	      print("<tr>\n");
	 
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
	       print("</tr>\n");
	       print("<tr>\n");
	       
	       print("<td><input type=\"submit\" name=\"querytournament\" value=\"Search\"></td>\n");
	       print("<td><input type=\"reset\" value=\"Reset\"></td>\n");
	       print("</tr>\n");
	       
       print("</table>\n");
       print("</form>\n\n");

    } 
    
     //**********************************************************************************************************
     function display_tournament_row ($rowresult) {

         // this displays the result row from the team slection query

         print("<tr>");
         //print("<td><a href=\"roster.php?id=".$rowresult['id']."\"&action=delete>Delete</a></td>\n");
         print("<td>".$rowresult['id']."</td>\n");
         print("<td>".$rowresult['title']."</td>\n");
         print("<td>".$rowresult['start_date']."</td>\n");
         print("<td><a href=\"tournaments.php?id=".$rowresult['id']."\"&action=showdetails>Show Details</a></td>\n");
         print("</tr>");

     }
     //**********************************************************************************************************
     //**********************************************************************************************************
     function display_tournaments($age, $gender)  {
  
       logger("display_tournaments age=".$age.":gender=".$gender."\n");
       /*
     	$hostname="localhost";
		$mysql_login="dev1";
		$mysql_password="dev1";
		$database="treg_test";
	  
		
		$dblink = mysql_connect($hostname, $mysql_login , $mysql_password);
  			
  		if (!($dblink = mysql_select_db("$database",$dblink)))  {
    			die("Can't connect to db.");
  			}
  		*/
       
       //$dblink = dbConnect();
       //global $dblink;

       $select1 = "SELECT DISTINCT t.* FROM tournament t "
					."LEFT JOIN tournament_age_groups a "
					."ON t.id = a.tournament_id "
					."WHERE t.start_date > curdate() ";

       if ($age != 'all')
       {
          $select1=$select1." AND age = '".$age."'";
       }
       
       if ($gender != 'all' )
       {
          $select1=$select1." AND gender = '".$gender."'";
       }
       
      

       logger("Select SQL : ".$select1 );

       $result = mysql_query($select1);// or die('<p>Invalid query Click here to return to the user options screen </p> ');
       $errorMsg = "MYSQL Error: ". mysql_errno() . ": " . mysql_error();
       
       if ($result)
       {
	       $check = mysql_num_rows($result);
	       print("<table>");;
	       
	       if ($check == 0)
	       {
	           print("<tr>");
	           print("<td colspan=4>");
	           print("Currently There are no tournaments with the given search");
	           print("</td></tr>");
	           
	          
	       }
	       else
	       {
	            while ($row = mysql_fetch_array($result)) {
	              display_tournament_row($row);
	            }
	       }
	       print("</table>");;
	       
       }
       else 
       {
       		logger("Mysql Error message:".mysql_error($dblink));
       		logger($errorMsg);
       }
       mysql_close();
    } // end function display_profile 
     //**********************************************************************************************************
     //**********************************************************************************************************
     // Main
     //**********************************************************************************************************

	include ("global.php");
    include ("common_functions.php");
    include("header.php");
    include("dbconnect.php");
    


    //print_session_details();    
    //include("login.php");

?>
	<TABLE BORDERCOLOR = "#000000" CELLPADDING=2 CELLSPACING=0 BGCOLOR="#ffffff">
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=500>
		<COL WIDTH=0>
		<COL WIDTH=0>
		<COL WIDTH=300>
		<COL WIDTH=0>
                <TBODY>
		<TR>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
			<TD COLSPAN=2 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
			<TD ROWSPAN=3 BGCOLOR="#418246"> </TD>
		</TR>
		<TR>
<?php
   display_tournament_selection_form();
   
   $gender = getPageParameter("gender", "all");
   $age = getPageParameter("age", "all");
   
   display_tournaments($age,$gender); 
?>
		</TR>
		<TR>
			<TD COLSPAN=5 HEIGHT=30 VALIGN=TOP BGCOLOR="#418246"> </TD>
		</TR>
        </TABLE>

<?php
    include("trailer.php");
?>
