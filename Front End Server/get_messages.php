<?php

require_once('dbconfig.php');
require_once('login_receiver.php');

if(login_receiver::isLoggedIn())
{
	$LoggedInUserID = login_receiver::isLoggedIn(); //check if user is logged in
}
else
{
	die('You are not logged in!');
}

$messages = DB::query('select messages.*, users.username from messages, users where receiver=:receiver or sender=:sender and users.id = messages.sender', array(':receiver'=>$LoggedInUserID, ':sender'=>$LoggedInUserID));
foreach ($messages as $message) //refer to every message as $message 
{
	echo $message['text']." from ".$message['username'].'<hr />';
}

?>