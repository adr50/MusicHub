<?php
ini_set("display_errors", 0);
ini_set("log_errors",1);
ini_set("error_log", "/tmp/error.log");
error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT);

require_once 'dbconfig.php';
require_once 'path.inc';
require_once 'rabbitMQLib.inc';
require_once 'get_host_info.inc';

function requestProcessor($db_request){
    echo "Received request:" . PHP_EOL;
    
    echo var_dump($db_request['search'] . "\n");
    echo var_dump($db_request['action'] . "\n");
    
    if ($db_request['action'] == "SELECT"){
        $the_data = doCheck($db_request['search']);
        return $the_data;
    }
}

function doCheck($db_request){ //Return all rows of the table that match the search query, empty array = no results.
    $database = new mysqli("localhost", "root", "password", "website");
    $pass = array();
    
    $result = $database->query("SELECT * FROM music WHERE artist_id LIKE '%$db_request%' OR name LIKE '%$db_request%' OR album_id LIKE '%$db_request%'
    OR album_title LIKE '%$db_request%' OR track_id LIKE '%$db_request%' OR
    track_title LIKE '%$db_request%' OR track_duration LIKE '%$db_request%'");
    
    while ($db_row = $result->fetch_assoc()){
        array_push($pass, $db_row);
    }
    return $pass;
}

echo "Rabbit MQ Server Start: ..." . PHP_EOL;
$server = new rabbitMQServer("api_select.ini", "testServer");
$server->process_requests('requestProcessor');
exit();
?>
