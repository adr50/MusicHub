<?php

require_once("'Database Server'/dbconfig.php");
require_once("'Database Server'/login_receiver.php");

$username = ""; //declare username as empty string to begin with
$isFollowing = False;

if (isset($_GET['username']))
{
	if (DB::query("select username from users where username=:username", array(':username'=>$_GET['username']))) //query that selects username from the users table 

	$username = DB::query("select username from users where username=:username", array(':username'=>$_GET['username']))[0]['username'] //variable if user is found 
	$OtherUserID = DB::query("select id from users where username=:username", array(':username'=>$_GET['username']))[0]['id']; //selecting the id of user depending on the username on the profile page 
	$LoggedInUserID = login_receiver::isLoggedIn(); //id of the user that is already logged in
	
	if (isset($_POST['follow'])) //check if the form is being submitted
	{
		if ($OtherUserID != $LoggedInUserID) //users cannot follow themselves 
		{
			if (!DB::query("select followerid from follow where userid=:OtherUserID", array(':OtherUserID'=>$OtherUserID))) //checks if the user is already following other user
			{
				DB::query("insert into follow values (:OtherUserID, :LoggedInUserID)", array(':OtherUserID'=>$OtherUserID, 'LoggedInUserID'=>$LoggedInUserID)); //inserts new row of follower into the follow table
			}
			else
			{
				echo 'You are already following this user!'
			}
			$isFollowing = True;
		}
	}
		
	if (isset($_POST['unfollow']))
	{
		if ($OtherUserID != $LoggedInUserID)
		{
			if (DB::query("select followerid from follow where userid=:OtherUserID", array(':OtherUserID'=>$OtherUserID)))
			{
				DB::query("delete from follow where userid=:OtherUserID and followerid=:LoggedInUserID)", array(':OtherUserID'=>$OtherUserID, 'LoggedInUserID'=>$LoggedInUserID)); //removes row of follower from the follow table
			}
				$isFollowing = False;
		}
	}

	
}

?>

<form action="user_profile.php?username=<?php echo $username; ?> "method="post">
	<?php
	
		if ($OtherUserID != $LoggedInUserID) //follow button won't show if logged in user is trying to follow themselves 
		{
			if ($isFollowing == True)
			{
				echo '<input type="submit" name="unfollow" value="Unfollow">';
			}
		
			else
			{
				echo '<input type="submit" name="follow" value="Follow">';
			}
		}
		
	?>
</form>