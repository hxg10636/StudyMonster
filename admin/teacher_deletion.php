<?php
require('../database_handler.php');
require('../login_status.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // 2. Prepare query
    $query  = "DELETE FROM teacher WHERE id = $id";
    // Do the query on the database
    $result = mysqli_query($connection, $query);
    if (!$result) {
        header('Location: teachers.php?success=2');
    }else{
        header('Location: teachers.php?success=del');
    }
} else {
    header("Location: home.php");
}
mysqli_free_result($result);
// 5. close db connection
mysqli_close($connection);
?>
