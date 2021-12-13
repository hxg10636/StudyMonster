<?php
if(isset($_POST['submit3'])){
  $id = $_POST['id'];
  $filename = $_POST['tfilename'];
  $fildes = $_POST['tfiledes'];
  $filetype = $_POST['tfiletype'];
  $tfile = $_FILES['tfile']['name'];
  $destination = "../assets/upload/";
  $file = $_FILES['tfile']['tmp_name'];
  $testurl = $_SERVER["DOCUMENT_ROOT"] . "/assets/upload/";
  echo $testurl ;

}
 ?>
