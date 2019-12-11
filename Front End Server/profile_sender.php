<?php
require_once 'path.inc';
require_once 'rabbitMQLib.inc';
require_once 'get_host_info.inc';
require_once 'user_profile.php';


$client = new rabbitMQClient("profile.ini","testServer");
$request = array();
$request['username'] = $_POST['username'];
$request['password'] = $_POST['password']; 
$username = $request['username'];

$response = $client->send_request($request);

if($response == 0){
   session_start();
   $_SESSION['username'] = $username;
   $random = bin2hex(random_bytes(32));
   $_SESSION['random'] = $random;
   header ("Location: user_profile.php?token=" . $random);
}
?>
