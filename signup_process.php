<?php
    $usertype = $_POST["usertype"];

    if (isset($_POST["signup-submit"])) {

        require "database_handler.php";
        $uname = $_POST["uname"];
        $username = $_POST["uid"];
        $email = $_POST["mail"];
        $password = $_POST["password"];
        $password_repeat = $_POST["password-repeat"];
        $DOB = $_POST['dob'];

        if (empty($username) || empty($email) || empty($password) || empty($password_repeat) || empty($uname) || empty($DOB)) {

            header("Location: signup.php?error=emptyfields&uid=".$username."&mail=".$email);
            exit();

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            header("Location: signup.php?error=invalidmail&uid=".$username);
            exit();

        } elseif ($password !== $password_repeat) {

            header("Location: signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
            exit();

        } elseif( $usertype == "Student") {

            $sql = "SELECT uid FROM student WHERE uid=?";
            $statement = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($statement, $sql)) {

              header("Location: signup.php?error=sqlerror");
              exit();

            } else {

              mysqli_stmt_bind_param($statement, "s", $username);
              mysqli_stmt_execute($statement);
              mysqli_stmt_store_result($statement);
              $resultCheck = mysqli_stmt_num_rows($statement);
              if ($resultCheck > 0) {

                header("Location: signup.php?error=usertaken&mail=".$email);
                exit();

              } else {

                $sql = "INSERT INTO student (name, uid, userEmails, dob, pwd) VALUES (?, ?, ?, ?, ?)";
                $statement = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($statement, $sql)) {

                    header("Location: signup.php?error=sqlerror");
                    exit();

                } else {

                    // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($statement, "sssss", $uname, $username, $email, $DOB, $password);
                    mysqli_stmt_execute($statement);
                    mysqli_stmt_store_result($statement);

                    header("Location: signup.php?signup=success");
                    exit();

                }

              }

            }
        } elseif( $usertype == "Professor") {

            $sql = "SELECT uid FROM teacher WHERE uid=?";
            $statement = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($statement, $sql)) {

              header("Location: signup.php?error=sqlerror");
              exit();

            } else {

              mysqli_stmt_bind_param($statement, "s", $username);
              mysqli_stmt_execute($statement);
              mysqli_stmt_store_result($statement);
              $resultCheck = mysqli_stmt_num_rows($statement);
              if ($resultCheck > 0) {

                header("Location: signup.php?error=usertaken&mail=".$email);
                exit();

              } else {

                $sql = "INSERT INTO teacher (name, uid, userEmails, dob, pwd) VALUES (?, ?, ?, ?, ?)";
                $statement = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($statement, $sql)) {

                    header("Location: signup.php?error=sqlerror");
                    exit();

                } else {

                    // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($statement, "sssss", $uname, $username, $email, $DOB, $password);
                    mysqli_stmt_execute($statement);
                    mysqli_stmt_store_result($statement);

                    header("Location: signup.php?signup=success");
                    exit();

                }

              }

            }
        }

        mysqli_stmt_close($statement);
        mysqli_close($connection);

    } else {

        header("Location: signup.php");
        exit();

    }

?>
