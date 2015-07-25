<?php
     //**********************************************************************************************************
     function get_user_by_team($team_id)  {
        $select1="SELECT email,first_name, last_name " 
                 ." FROM object_admin as oa "
                 ." left join user_profile  as profile "
                 ." on oa.user_id = profile.user_id "
                 ." where object_type = 'team'"
                 ."and object_id = '".$team_id."'";
        logger("<P>SQL:". $select1 ."\n");
        return execute_sql($select1);
     } 

     //**********************************************************************************************************
     function get_team_info($team_id)  {
        $select1="SELECT team_name, gender, cut_off_year  FROM team WHERE id = '".$team_id."'";
        logger("<P>SQL:". $select1 ."\n");
        return execute_sql($select1);
     } 
     //**********************************************************************************************************
     function get_user_profile($user_id)  {
        $select1="SELECT email,first_name,last_name FROM user_profile WHERE user_id = '".$user_id."'";
        logger("<P>SQL:". $select1 ."\n");
        return execute_sql($select1);
     }     
     //**********************************************************************************************************
     function get_tournament_info($tournament_id)  {
        $select1="SELECT *  FROM tournament WHERE id = '".$tournament_id."'";                         
        logger("<P>SQL:". $select1 ."\n");
        return execute_sql($select1);
     }     
     //**********************************************************************************************************
     function execute_sql($select1)  {
     
       
        $result = mysql_query($select1) or die("Unable to get requested data".mysql_error());
		if ($result)
		{
        
	        $check = mysql_num_rows($result);
	        if ($check != 0)
	        {
	         	$row = mysql_fetch_array($result);
	         	return $row;
	        }
		}
        
		return ;
      
     }
     //**********************************************************************************************************
     function send_registration_confirmation_email($user_id)  {
     	
    	$user_profile = get_user_profile($user_id);
     	
		
		$to=$user_profile['email'];
		$cc="info@tournamentclearinghouse.com";
		
		$subject = "Registration confirmation for TournamentClearingHouse.com";
			
		
		$body = "Welcome.\n"
		        ."This email has been sent by the Tournament Clearing House to notify you that you have successfully registered.\n"
		        ."You will be able to use the Tournament Clearing House as soon as your registration has been confirmed by our staff.\n"
		        ."You will receive another email when your registration and role has been approved.\n"
		        ."If you do not receive an email you can check back to see if you have access:\n"
		        ." http://www.tournamentclearinghouse.com/index.php\n"
		        ."If your registration is not confirmed within 48 hours please send an email to : admin@tournamentclearinghouse.com\n"
		        ."\n"
		        ."Thank you for registering with the Tournament Clearing House.\n";
		        
		
    	send_email($to, $subject, $body, $cc);
 
      
     }   
 
     
     //**********************************************************************************************************
     function send_approved_email($tournament_id, $team_id, $user_id)  {
     	
     	$user_profile = get_user_by_team($team_id);
     	$team_info = get_team_info($team_id);
     	$tournament_info = get_tournament_info($tournament_id);
     		
		$to=$user_profile['email'];
     	$cc=$tournament_info['email'];
		
		$subject = $team_info['team_name']." check-in has been aprproved for ".$tournament_info['title'];
			
		
		$body = "This email has been sent by the Tournament Clearing House to notify you that ".$team_info['team_name']. "\n"
		        ." check-in has been approved by the tournament ".$tournament_info['title']. "\n"
		        ." To view the check-in documentation.\n"
		        ." http://www.tournamentclearinghouse.com/tourn_roster.php?role=team&"
		        ."action=display&tournament_id=".$tournament_id."&team_id=".$team_id."\n\n"
				."Thank you for using the Tournament Clearing House -  enjoy your tournament.\n";
		        
		
		send_email($to, $subject, $body, $cc);
       
     }
     //**********************************************************************************************************
     function send_submit_email($tournament_id, $team_id, $user_id)  {
     	
     	$user_profile = get_user_profile($user_id);
     	$team_info = get_team_info($team_id);
     	$tournament_info = get_tournament_info($tournament_id);
     			
		$to=$tournament_info['email'];
		$cc=$user_profile['email'];
		
		$subject = $team_info['team_name']." has submitted check-in for ".$tournament_info['title'];
		
		$body = "This email has been sent by the Tournament Clearing House to notify you that ".$team_info['team_name']. "\n"
		        ." has submitted tournament check-in documentation for the tournament ".$tournament_info['title']. "\n"
		        ." ready for review and acceptance.\n"
		        ." Please login into the Tournament Clearing House and review the Check-In documentation.\n"
		        ." http://www.tournamentclearinghouse.com/tourn_roster.php?role=tournament&"
		        ."action=display&tournament_id=".$tournament_id."&team_id=".$team_id."\n";
		        
		        
		
		send_email($to, $subject, $body, $cc);
      
     }
     //**********************************************************************************************************
     function send_reminder_email($tournament_id, $teamname, $registered_email, $team_id)  {
     	
     	$user_profile = get_user_profile($user_id);
     	$tournament_info = get_tournament_info($tournament_id);
     			
		$to=$registered_email;
		//$cc=$user_profile['email'];
		
		
		$subject = "Reminder:".$teamname." please complete submit team check-in for ".$tournament_info['title'];
		
		$body = "This email has been sent by the Tournament Clearing House to notify you that registered ".$teamname. "\n"
		        ." needs to complete Check-In for the tournament you are registered for ( ".$tournament_info['title']. ")\n"
		        ." The Tournament On Line Documentation deadline ( ".$tournament_info['checkindeadline']. ")\n"		        
		        ." Please login into the Tournament Clearing House and review and complete the Check-In documentation.\n"
		        ." http://www.tournamentclearinghouse.com/tourn_roster.php?role=tournament&"
		        ."action=display&tournament_id=".$tournament_id."&team_id=".$team_id."\n"
		        ." If you have not registered for Tournament Clearing House use the following link .\n"
		        ."http://www.tournamentclearinghouse.com/register";
		        
		        
		
		send_email($to, $subject, $body, "");
      
     }
     
     
     //**********************************************************************************************************
     function send_restarted_email($tournament_id, $team_id, $user_id)  {
     	
     	$user_profile = get_user_by_team($team_id);
     	$team_info = get_team_info($team_id);
     	$tournament_info = get_tournament_info($tournament_id);
     	
		
		$to=$tournament_info['email'];
		$cc=$user_profile['email'];
		
		$subject = $team_info['team_name']." has been restarted check-in for ".$tournament_info['title'];
		
		$body = "This email has been sent by the Tournament Clearing House to notify you that ".$team_info['team_name']. "\n"
		        ." has restarted tournament check-in documentation for the tournament ".$tournament_info['title']. "\n"
		        ." When the user submits check-in you will be notified.\n"
		        ." You willl need to re-approve the tournament check-in.\n"
		        ." Please login into the Tournament Clearing House and review the Check-In documentation.\n"
		        ." http://www.tournamentclearinghouse.com/tourn_roster.php?role=tournament&";

		send_email($to, $subject, $body, $cc);        
     
     }
     //**********************************************************************************************************
     function send_rejected_email($tournament_id, $team_id, $user_id,$reasons)  {
     	
    	$user_profile = get_user_by_team($team_id);
     	$team_info = get_team_info($team_id);
     	$tournament_info = get_tournament_info($tournament_id);
     	
		
		$to=$user_profile['email'];
		$cc=$tournament_info['email'];
		
		$subject = $team_info['team_name']." check-in has been rejected for ".$tournament_info['title'];
			
		
		$body = "This email has been sent by the Tournament Clearing House to notify you that ".$team_info['team_name']. "\n"
		        ." check-in has been rejected by the tournament director for ".$tournament_info['title']. "\n"
		        ." To view and correct the check-in documentation.\n"
		        ." http://www.tournamentclearinghouse.com/tourn_roster.php?role=team&"
		        ."action=display&tournament_id=".$tournament_id."&team_id=".$team_id."\n\n"
		        ."The reasons for rejection are:\n"
		        .$reasons
				."\nThank you for using the Tournament Clearing House -  enjoy your tournament.\n";
		        
		
		send_email($to, $subject, $body, $cc);
       
     }
    //**********************************************************************************************************
    function send_email($to, $subject, $body, $cc) {
		    
		$headers = "From: admin@tournamentclearinghouse.com" . "\r\n" ;
		
		if (isset($cc) && $cc != "" )
		{
    		$headers .= "Cc: ".$cc . "\r\n";
		}
    	$headers .= "X-Mailer: PHP/" . phpversion() ;
    	
		//$body = wordwrap($body, 70);   
    	
    	//print("<P>To=".$to."</P>");        
		//print("<P>Subject=".$subject."</P>");        
		//print("<P>Body=".$body."</P>");    
    	//print("<P>Headers=".$headers."</P>");
		
		
		
		 if (mail($to, $subject, $body, $headers)) {
         	echo("<p>Notification message successfully sent to:".$to."</p>");
         } else {
          	echo("<p>Notification message delivery to: ".$to."failed...</p>");
  		}
    }
    //**********************************************************************************************************
    function send_test_email($email)  {
     	
    	$user_profile = get_user_profile($user_id);
     	$team_info = get_team_info($team_id);
     	$tournament_info = get_tournament_info($tournament_id);
     	
		//$headers = 'From: admin@tournamentclearinghouse.com'; 
		//. "\r\n" .
    	//'X-Mailer: PHP/' . phpversion();
		
		$to=$email;
		
		$subject ="This is a test";
			
		
		$body = "This email has been sent by the Tournament Clearing House to test\n"
		        ." email functionality\n"
		        ."\nThank you for using the Tournament Clearing House\n";
		        
		
		send_email($to, $subject, $body, "webmaster@tournamentclearinghouse.com");
       
     }
	
?>