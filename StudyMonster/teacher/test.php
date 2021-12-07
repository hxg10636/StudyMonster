<?php
if(isset($_POST['submit'])){
  $id = $_POST['id'];
  $cname = $_POST['cname'];
  $description = $_POST['description'];
  $duration = $_POST['duration'];
  $cfile = $_FILES['cfile']['name'];
  echo $id ;
  echo $cname;
  echo $description;
  echo $duration ;
  echo $cfile;
}
 ?>
