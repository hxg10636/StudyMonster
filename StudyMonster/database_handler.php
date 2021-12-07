<?php
  $servername = "localhost";
  $dbUsername = "root";
  $dbPassword = "fb3a17d69a452b08";
  $dbName = "studymonster";

  $connection = mysqli_connect($servername, $dbUsername,$dbPassword,$dbName);
  if (!$connection){
    die("Database Connection Failed! The Reason is: ".mysqli_connect_error());
  }
 ?>
