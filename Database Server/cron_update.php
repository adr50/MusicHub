<?php

$api = new rabbitMQClient("api.ini", "testServer"); // Might need a separate API receiver to avoid errors.
$database = new mysqli("localhost", "root", "password", "website");
$file = fopen("search_cache.txt", "r");
$queries = array();

while (!feof($file)) { // Iterate through all lines of the file.
	array_push($queries, fgets($file)); // Create a stack.
}

for (i = 0; i <= count($queries); i++) { // Iterate through each element.
	$query = $queries[i];
	$response = $api->send_request($query); // Might need a separate API receiver to avoid errors.

	$assoc = json_decode($response, true);
    	$artist_keys = array('id', 'name');
    	$album_keys = array('id', 'title');
    	$track_keys = array('id', 'title', 'duration');
    	$passing = array();
    	for($i = 0; $i < $assoc['total']; $i++){
        	$artist_id_data = $assoc['data'][$i]['artist'][$artist_keys[0]];
        	$artist_name_data = $assoc['data'][$i]['artist'][$artist_keys[1]];
        	$album_id_data = $assoc['data'][$i]['album'][$album_keys[0]];
        	$album_title_data = $assoc['data'][$i]['album'][$album_keys[1]];
        	$track_id_data = $assoc['data'][$i][$track_keys[0]];
        	$track_title_data = $assoc['data'][$i][$track_keys[1]];
        	$track_duration_data = $assoc['data'][$i][$track_keys[2]];
        	if ($artist_id_data != "" || $artist_name_data != ""){
        	$passing[$i] = array('artist_id'=> $artist_id_data, 'name'=> $artist_name_data, 
        	'album_id' => $album_id_data, 'album_title' => $album_title_data, 'track_id' => $track_id_data, 
      		'track_title' => $track_title_data, 'track_duration' => $track_duration_data);
	}

    	for ($i = 0; $i < count($passing); $i++) {
    
      		$artist_id = $passing[$i]['artist_id'];
      		$name = $passing[$i]['name'];
      		$album_id = $passing[$i]['album_id'];
      		$album_title = $passing[$i]['album_title'];
      		$track_id = $passing[$i]['track_id'];
      		$track_title = $passing[$i]['track_title'];
      		$track_duration = $passing[$i]['track_duration'];
        
      	$result = $database->query("SELECT artist_id FROM music WHERE track_id = '$track_id'");
      
      	if ($result->num_rows >= 1) {
      	} else {
        	$database->query("INSERT INTO music (artist_id, name, album_id, album_title, track_id, track_title,
        	track_duration) VALUES ('$artist_id', '$name', '$album_id', '$album_title',
        	'$track_id', '$track_title', '$track_duration')");
	}
	array_pop($queries);
}
?>


