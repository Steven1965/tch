<?php

 
 

 

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
 
     
 
?> 
