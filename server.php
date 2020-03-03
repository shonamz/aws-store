
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');  

// session_start();

// require 'config.php';
$mysqli = new mysqli($host, $user, $pass, $name);
if ( $mysqli->errno ) {
	echo $mysqli->error;
	exit();
}

$mysqli->set_charset('utf8');

 /// check for username that are in Database
$uname = $_POST['uname']; 

$results = mysqli_query($mysqli , "SELECT * FROM db_maria.login_tbl WHERE uname='$uname'");

    // $count  = mysqli_num_rows($results);
 
 
// //Write the SQL statement
$password_string = $_POST['psw'];

$password_hash = password_hash($password_string, PASSWORD_BCRYPT);

$sql = "INSERT INTO db_maria.login_tbl (uname,password)
	VALUES('" . $_POST['uname'] . "', "
	. "'". $password_hash. "'"
	.");";

// Submit the SQL query
  $results = $mysqli->query($sql);
  if ( !$results ) {
  	echo $mysqli->error;
  	exit();
 }

  $mysqli->close();

  $_SESSION['logged_in'] = true;
  $_SESSION['uname'] = $_POST['uname'];

 // redirect them to thes home page :)
	 header('Location: index.php');


   ?>



