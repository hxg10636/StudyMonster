<?php
if(isset($_POST['submit2'])){
  $id = $_POST['id'];
  $filename = $_POST['filename'];
  $fildes = $_POST['filedes'];  
  $filetype = $_POST['filetype'];
  $cfile = $_FILES['cfile1']['name'];
  
  echo $cfile;
  echo $filename;   
  echo $filetype;   
}
?>