<?php

$userProfile =
array(
array("id" => "userId",   "name" => "Username",          "type" =>"text",     "col"=>"user_id",    "length"=>"40", "value"=>""),
array("id" => "firstName","name" => "First Name",        "type"=>"text" ,    "col"=>"first",      "length"=>"40", "value"=>""),
array("id" => "lastName", "name" => "LastName",          "type"=>"text",     "col"=>"last",       "length"=>"50", "value"=>""),
array("id" => "email",    "name" => "Email" ,            "type"=>"text" ,    "col"=>"email",      "length"=>"60", "value"=>""),
array("id" => "email2",   "name" => "Email 2",           "type"=>"text" ,    "col"=>"email2",     "length"=>"60", "value"=>""),
array("id" => "tn",       "name" => "Telephone",         "type"=>"text" ,    "col"=>"alt_email",  "length"=>"60", "value"=>""),
array("id" => "secq",     "name" => "Security Question", "type"=>"text" ,    "col"=>"secq",       "length"=>"60", "value"=>""),
array("id" => "seca",     "name" => "Security Answer",   "type"=>"text" ,    "col"=>"seca",       "length"=>"60", "value"=>"")
);

function printFormHeader($title, $form_action,$border, $colspan)
{
	print("<form action=");
	print($form_action);
	print(" method=\"post\">");
    print("<table border=\"".$border."\">");
    print("<tr><td colspan=".$colspan."><h1>".$title."</h1></td></tr>");
}

function printFormRow($field, $title, $form_action,$border, $colspan)
{
    print("<tr><td>".$field['name']."</td><td>");
    print("<input type=\"".$field['type']."\"" );
    print(" name=\"" .$field['id']."\"");
    print(" maxlength=\"".$field['length']."\"");
    print(" value=".$field['value'].">");
    print(" </td></tr>");
}

function printFormButton($name, $displayname, $value,$colspan)
{   
    print("<tr><td colspan=\"".$colspan."\" align=\"right\">");
    print("<input type=\"".$displayname."\"" );
    print("name=\"".$name."\"");
    print(" value=\"".$value."\">");
    print(" </td></tr>");
 }
function printFormEnd()
{
    print("</table>");
    print("</form>");
}
 
    include("dbconnect.php");

    include("auth.php");

   
       $row = mysql_query("SELECT 
                             first_name,
                             last_name,
                             email,
                             alternative_email,
                             telephone,
                             security_question,
                             security_answer
                             WHERE
                             user_id = '".$_POST['username']."'" ) or die("Unable to extract user profile");



// if they are not logged in

   
       $check = mysql_query("SELECT 
                             first_name,
                             last_name,
                             email,p-p-\
                             alternative_email,
                             telephone,
                             security_question,
                             security_answer
                             WHERE
                             user_id = '".$_POST['username']."'" );
// if they are not logged in
   
       $check = mysql_query("SELECT 
                             first_name,
                             last_name,
                             email,
                             alternative_email,
                             telephone,
                             security_question,
                             security_answer
                             WHERE
                             user_id = '".$_POST['username']."'" )
// if they are not logged in
?>