<?php
function getdb(){
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = 'yashjain2910';
   $dbname = 'rannlab';
   $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Could not connect to the database.");
   return $con;
}
?>
