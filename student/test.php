<?php 

require('../database_handler.php');

if(isset($_POST['submitexam'])){
  $id = $_POST['id'];
  $filename = $_POST['tfilename'];
  $fildes = $_POST['tfiledes'];
  $filetype = $_POST['tfiletype'];
  $tfile = $_FILES['tfile']['name'];
  $destination = "../assets/upload/";
  $file = $_FILES['tfile']['tmp_name'];

    //Course
    $query = "SELECT course.name AS cname, teacher.userEmails, teacher.id AS tid ,teacher.name AS tname, teacher.avatar AS tavatar, course.description, course.duration, course.course_pict, course.status FROM course INNER JOIN teacher ON course.instructor_id = teacher.id WHERE course.course_id=$id";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    $teacherid = $row['tid'];
    mysqli_free_result(mysqli_query($connection, $query));
    
    //studentid
    $query = "SELECT id, name, avatar FROM student WHERE uid = '$username'";
    $sname = mysqli_fetch_array(mysqli_query($connection, $query));
    $studentid = $sname['id'];
    mysqli_free_result(mysqli_query($connection, $query));
  
  
    echo "teacherid: ".$teacherid ."<br/>";
    echo "studentid: ".$studentid."<br/>";
    echo "file name: ".$filename."<br/>";
    echo "filename: ".$tfile;}
?>