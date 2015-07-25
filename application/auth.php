<?php
// Login & Session example by sde
// auth.php


print("_SESSION".$_SESSION."\n");
print("_POST".$_POST."\n");
// start session
session_start(); 

// convert username and password from _POST or _SESSION
if($_POST){
  $_SESSION['username']=$_POST["username"];
  $_SESSION['password']=$_POST["password"];  
}

// query for a user/pass match

// makes sure they filled it in
if(!$_SESSION['username'] | !$_SESSION['password']) {
     die('You did not fill in a required field.');
}
   
// here we encrypt the password and add slashes if needed
$auth_username = md5($_POST['password']);
$auth_password = md5($_POST['password']);
if (!get_magic_quotes_gpc()) {
   $auth_username = addslashes($auth_username);
   $auth_password = addslashes($auth_password);
}
echo $auth_username;
echo $auth_password;


$checkusersql="SELECT * from user_login
               WHERE user_id='" . $auth_username . "' AND password='" . $auth_password . "'";


echo $checkusersql;
$result=mysql_query($checkusersql);

// retrieve number of rows resulted
$num=mysql_num_rows($result); 

// print login form and exit if failed.
if($num < 1){
  echo "You are not authenticated.  Please login.<br><br>";
  include("loginform.php");
  
  exit;
}
?> 
