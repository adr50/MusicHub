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
    $register = doRegister($request['username'], $request['password']);
    if($register == 1){
        return 0;
    }else{
        return 1;
    }
}

function doRegister($username, $password){
    $database = new mysqli("localhost", "root", "password", "website");
    
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL database: " . mysqli_connect_error();
        exit();
    }
   
    $username = $database->real_escape_string($username);
    $password = $database->real_escape_string($password);

    if(!$register = $database->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'")){
        echo ("Error running query: " . mysqli_errno($database) . " " . mysqli_error($database) . "\n");
        die();
    }
    $exists = $register->num_rows;

    if($exists == 1){
        echo ("FAILURE: User has already registered! (Record already exists in the database.)" . "\n");
            while ($db_row = $register->fetch_assoc()){
                print_r($db_row);
            }
        return 0;
    }
    else{
        if($register = $database->query("INSERT INTO users (username, password) VALUES ('$username', '$password')")){
            echo("SUCCESS: User registered! (Record has been added to the database.)" . "\n");
        }
        else{
            echo("Error running query: " . mysqli_errno($database) . " " . mysqli_error($database) . "\n");
            die();
        }
        if(!$register = $database->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'")){
            echo("Error running query: " . mysqli_errno($database) . " " . mysqli_error($database) . "\n");
            die();
        }
        while($db_row = $register->fetch_assoc()){
            print_r($db_row);
        }
    }
    return 1;
}
echo "Rabbit MQ Server Start" . PHP_EOL;
$server = new rabbitMQServer("registration.ini", "testServer");
$server->process_requests('requestProcessor');
exit();
?>
