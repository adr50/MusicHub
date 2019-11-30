<?php
require_once('dbconfig.php');
require_once('login_receiver.php');

if (isset($_POST['search']))
{
	$searchuser = explode(" ", $_POST['search']); //explodes on spaces
	if (count($searchuser) == 1) //one word (username)
	{
		$searchuser = str_split($searchuser[0], 2); //split on every 2 characters of username when searching 
	}
	
	$whereclause = "";
	$paramsarray = array(':username'=>'%'.$_POST['search'].'%'); //give it a value of username, equal to the value out of the search 
	
	for ($i = 0; $i < count($searchuser); $i++) 
	{
		$whereclause .= " or username like :u$i "; //taking everything inside the 'searchuser' array and comparing it using the 'like' operator 
		$paramsarray[":u$i"] = $searchuser[$i]; 
	}
	
	$users = DB::query('select username from users where username like :username '.$whereclause.'', $paramsarray);
	print_r($users);
}
	
<form action="*filename*.php" method="post">
	<input type="text" name="search" placeholder="Username">
	<input type="submit" name="search" value= "Search User">
</form>
