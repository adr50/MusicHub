<?php
require_once 'path.inc';
require_once 'rabbitMQLib.inc';
require_once 'get_host_info.inc';

$api = new rabbitMQClient("api.ini","testServer");
$select = new rabbitMQClient("api_db_select.ini", "testServer");
$insert = new rabbitMQClient("api_db_insert.ini", "testServer");

$request = array();
$request['search'] = $_GET['search'];
$request['action'] = "SELECT";
$search = $request['search'];
	
$database_response = $select->send_request($request); //Check whether the database contains the search query using SELECT.

if ($database_response) { //If contents of the returned array from the database is not empty, display them.
	echo "Results for: " . "'" . $search . "'" . PHP_EOL;
	echo '<pre>'; print_r($database_response); echo '</pre>'
}
else { //If contents of the returned array from the database is empty, call API and INSERT into table.
	$assoc = json_decode($response, true);

	$artist_keys = array('id', 'name');
	$album_keys = array('id', 'title');
	$track_keys = array('id', 'title', 'duration');

	$pass = array(); //Get key/value pairs and pass them to database for insertion.

	for($i = 0; $i < $assoc['total']; $i++){

    	$artist_id_data = $assoc['data'][$i]['artist'][$artist_keys[0]];
    	$artist_name_data = $assoc['data'][$i]['artist'][$artist_keys[1]];

    	$album_id_data = $assoc['data'][$i]['album'][$album_keys[0]];
    	$album_title_data = $assoc['data'][$i]['album'][$album_keys[1]];

    	$track_id_data = $assoc['data'][$i][$track_keys[0]];
    	$track_title_data = $assoc['data'][$i][$track_keys[1]];
    	$track_duration_data = $assoc['data'][$i][$track_keys[2]];

    	if ($artist_id_data != "" || $artist_name_data != ""){
      		$pass[$i] = array('artist_id'=> $artist_id_data, 'name'=> $artist_name_data, 
      		'album_id' => $album_id_data, 'album_title' => $album_title_data, 'track_id' => $track_id_data, 
      		'track_title' => $track_title_data, 'track_duration' => $track_duration_data);
    	}
}
echo "Found new results for: " . "'" . $request['search'] . "'" . PHP_EOL;
echo '<pre>'; print_r($pass); echo '</pre>';
$insert->send_request($pass); //Insertion queue passes the music data to the database.
}
?>
