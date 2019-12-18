<?php
session_start();
if(!isset($_GET['token']) || $_GET['token'] != $_SESSION['random']){
  header('Location: login.html');
}
$username = $_SESSION['username'];
$random   = $_SESSION['random'];

?>


/*
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
*/

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon goes here. -->
    <link rel="icon" href="css/images/logo.png">
    <!-- Bootstrap CSS link statements. -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Bootstrap JavaScript script statements.-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <!-- Fonts go here -->
    <link href="https://fonts.googleapis.com/css?family=Rancho|Roboto|Pacifico|Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- Specific page title. -->
    <title>Profile - MusicHub</title>
  </head>
  <body>
  <!-- Navigation bar.-->
  <header class="header">
    <nav class="navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="index.html">
        <img src="css/images/logo.png" width="45" alt="" class="d-inline-block align-middle mr-2">
        <span class="" style="font-family:'Pacifico', cursive;">MusicHub</span></a>
            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
            <!-- Navigation bar content -->
            <div id="navbarSupportedContent" class="collapse navbar-collapse" style="font-family:'Lato'">
                <ul class="navbar-nav ml-auto">
                    <!-- <li class="nav-item"><a href="password_reset.html" class="nav-link text-uppercase font-weight-bold">Reset Password</a></li> -->
                    <li class="nav-item"><a href="logout.php" class="nav-link text-uppercase font-weight-bold">Sign Out</a></li>
                </ul>
            </div>
        </div>
    </nav>
<!--Profile picture form -->
  <p> Upload a profile picture: </p>
  <form action="/profile_sender.php">
  <input type="file" name="image"
accept="image/">
  <input type="submit" class="btn btn-primary"
name="submit_picture" value="Submit">
  </form>

<!--Background picture form -->
  <p> Upload a background picture: </p>
  <form action="/profile_sender.php">
  <input type="file" name="background_image"
accept="image/">
  <input type="submit" class="btn btn-primary"
name="submit_background" value="Submit">
 </form>
    
 <!--View another user's profile -->
 <?php
 $user_id = $_GET['user_id'];
 $user_id = mysqli_real_escape_string($user_id);
 $result = mysqli_query("SELECT * FROM users WHERE id='$user_id'");

 $number = mysqli_num_rows($result);
 if ($number < 1)
 {
   echo "No user found";
 }
 else
 {
   echo "<a href=user_profile.php?userid='.$user_id.'>Link</a>"; 
 }

 ?>
 
  

</header>
    <section class="hero">
        <div class="hero-inner">
        <h1 style="font-family:'Pacifico', cursive;">MusicHub</h1>
        <p>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>, welcome back!</p>
        <div class="container">
      <div class="">
        <div class="searchbar">
          <input class="search_input" type="text" name="" placeholder="Search artists, albums, songs, etc.">
          <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
        </div>
      </div>
    </div>
</div>
    </section>
    <!-- Footer goes here. -->
    </div>
  </body>
</html>

