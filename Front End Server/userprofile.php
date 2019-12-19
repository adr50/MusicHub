<?php

session_start():

require_once('dbconfig.php');

$username = $_SESSION['username'];

echo "Welcome to your profile <b>".$_SESSION['username']."</b>!";

?>

<html>
<head>
	<title><?php print $_SESSION['username']; ?>'s Profile</title>
</head>
<body>
</body>
</html>