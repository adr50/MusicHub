<?php

ini_set("display_errors", 0);
ini_set("log_errors",1);
ini_set("error_log", "/tmp/error.log");
error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT);

require_once 'path.inc';
require_once 'rabbitMQLib.inc';
require_once 'get_host_info.inc';

function requestProcessor($request){
    echo "Received request:" . PHP_EOL;
    var_dump($request);
    $login = doLogin($request['username'], $request['password']);
    if($login == 1){
        return 0;
    }else{
        return 1;
    }
}

function doLogin($username, $password){
    $database = new mysqli("localhost", "root", "password", "website");
    
    if(mysqli_connect_errno()){
        echo("Failed to connect to MySQL database: " . mysqli_connect_error() . "\n");
        exit();
    }
    
    $username = $database->real_escape_string($username);
    $password = $database->real_escape_string($password);

    if(!$login = $database->query("SELECT * FROM users where username = '$username' AND password = '$password'")){
        echo("Error running query: " . mysqli_errno($database) . " " . mysqli_error($database) . "\n");
        die();
    }
    $password_check = $login->num_rows;

    if($password_check == 0){
        echo("FAILURE: Incorrect password, or user does not exist. Please try again." . "\n");
        return 0;
    }
    else{
       echo("SUCCESS: You are now logged in!" . "\n");
        if(!$login = $database->query("SELECT * FROM users where username = '$username' AND password = '$password'")){
            echo("Error running query: " . mysqli_errno($database) . " " . mysqli_error($database) . "\n");
            die();
        }
        while($db_row = $login->fetch_assoc()){
            print_r($db_row);
        }
        return 1;
    }
}
echo "Rabbit MQ Server Start" . PHP_EOL;
$server = new rabbitMQServer("login.ini", "testServer");
$server->process_requests('requestProcessor');
exit();
?>
