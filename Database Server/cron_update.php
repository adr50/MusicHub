<?php

$api = new rabbitMQClient("api.ini", "testServer"); // Might need a separate API receiver to avoid errors.
$database = new mysqli("localhost", "root", "password", "website");

   
$file_ptr = "search_cache.txt";  

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
    	for($a = 0; $a < $assoc['total']; $a++){
        	$artist_id_data = $assoc['data'][$a]['artist'][$artist_keys[0]];
        	$artist_name_data = $assoc['data'][$a]['artist'][$artist_keys[1]];
        	$album_id_data = $assoc['data'][$a]['album'][$album_keys[0]];
        	$album_title_data = $assoc['data'][$a]['album'][$album_keys[1]];
        	$track_id_data = $assoc['data'][$a][$track_keys[0]];
        	$track_title_data = $assoc['data'][$a][$track_keys[1]];
        	$track_duration_data = $assoc['data'][$a][$track_keys[2]];
        	if ($artist_id_data != "" || $artist_name_data != ""){
        	$passing[$a] = array('artist_id'=> $artist_id_data, 'name'=> $artist_name_data, 
        	'album_id' => $album_id_data, 'album_title' => $album_title_data, 'track_id' => $track_id_data, 
      		'track_title' => $track_title_data, 'track_duration' => $track_duration_data);
	}

    	for ($b = 0; $b < count($passing); $b++) {
    
      		$artist_id = $passing[$b]['artist_id'];
      		$name = $passing[$b]['name'];
      		$album_id = $passing[$b]['album_id'];
      		$album_title = $passing[$b]['album_title'];
      		$track_id = $passing[$b]['track_id'];
      		$track_title = $passing[$b]['track_title'];
      		$track_duration = $passing[$b]['track_duration'];
        
      	$result = $database->query("SELECT artist_id FROM music WHERE track_id = '$track_id'");
      
      	if ($result->num_rows >= 1) {
      	} else {
        	$database->query("INSERT INTO music (artist_id, name, album_id, album_title, track_id, track_title,
        	track_duration) VALUES ('$artist_id', '$name', '$album_id', '$album_title',
        	'$track_id', '$track_title', '$track_duration')");
	}
}
		
if (!unlink($file_pointer)) {  // After all queries are iterated over and updated, delete the file.
    echo ("Error: File cannot be deleted.");  
}  
else {  
    echo ("Success: File has been deleted.");  
}  
?>
