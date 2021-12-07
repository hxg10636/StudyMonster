<?php
require('../database_handler.php');
require('../login_status.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // 2. Prepare query
    $query  = "DELETE FROM course WHERE course_id = $id";
    // Do the query on the database
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: course.php?success=2');
    }else{
        header('Location: course.php?success=del');
    }
} else {
    echo "No ID was given in the URL";
}
mysqli_free_result($result);
// 5. close db connection
mysqli_close($connection);
?>
