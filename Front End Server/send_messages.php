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

if (isset($_POST['send']))
{
	if (DB::query('select id from users where id=:receiver', array(':receiver'=>$_GET['receiver']))) //check if receiver id is legitimate
	{
		DB::query("insert into messages values ('', :text, :sender, :receiver)", array(':text'=>$_POST['text'], ':sender'=>$LoggedInUserID, ':receiver'=>$_GET['receiver']));
		echo 'Your message was sent!';
	}
	else 
	{
		die('User does not exist!');
	}
}

?>

<form action="send_messages.php?receiver=<?php echo $_GET['receiver']; ?>" method="post">
	<textarea name="text" placeholder="Type your message here."></textarea>
	<input type="submit" name="send" value="Send">
</form>