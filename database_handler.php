<?php
  $servername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "studymonster";

  $connection = mysqli_connect($servername, $dbUsername,$dbPassword,$dbName);
  if (!$connection){
    die("Database Connection Failed! The Reason is: ".mysqli_connect_error());
  }
 ?>
