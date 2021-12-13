<?php
require('../database_handler.php');
if(isset($_POST['submit5'])){
    $id = $_POST['id'];
    $cercourse=$_POST['cercourse'];
    $certificate=$_POST['certificate111'];


    echo $id;
    echo $cercourse;
    echo $certificate;    
    $query = "UPDATE student_course SET certificate_id = (SELECT certificate_id FROM certificate WHERE name = '$certificate') WHERE course_id = (SELECT course_id FROM course WHERE name = '$cercourse') AND student_id = '$id'";
    $result55 = mysqli_query($connection,$query);
    mysqli_free_result($result55);
    header("Location: student_details.php?id=".$id."&success=update");
    
    
}
?>