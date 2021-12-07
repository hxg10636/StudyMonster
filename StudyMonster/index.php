<?php
// make db conection
require('database_handler.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['username']) || isset($_POST['password'])) {
        // Save username & password in a variable
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        // $hashedPwd1 = password_hash($password, PASSWORD_DEFAULT);
        // Prepare query
        $query  = "SELECT uid, userEmails, pwd FROM $role WHERE uid = '$username'  AND pwd = '$password'";
        // Execute query
        $result = mysqli_query($connection, $query);

        // Check how many rows are selected
        $numrows=mysqli_num_rows($result);
        // ECHO $numrows;
        if ($numrows == 1) {
            if($role=="student"){
                session_start();
                $_SESSION['login_user'] = $username;
                header('Location: student/home.php');
            }else{
                $query  = "SELECT role FROM teacher WHERE uid = '$username' ";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);
                $level = $row["role"];
                // Start to use sessions
                session_start();
                // Create session variable
                $_SESSION['login_user'] = $username;
                if ($level == 1) {
                    header('Location: teacher/home.php');
                } else {
                    header('Location: admin/home.php');
                }
            }
        } else {
            $error="Login Failed.";
        }

        // 4. free results
        mysqli_free_result($result);
    }
}

// 5. close db connection
mysqli_close($connection);

?>


<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>StudyMonster - The GWSB Capstone Project </title>

<link rel="stylesheet" href="assets/dist/css/tailwind.min.css" />
<link rel="stylesheet" href="assets/dist/css/style.css" />

</head>
<body>
        <div class="relative min-h-screen flex">
            <div
                class="
                    flex flex-col
                    sm:flex-row
                    items-center
                    md:items-start
                    sm:justify-center
                    md:justify-start
                    flex-auto
                    min-w-0
                    bg-white
                "
            >
                <div
                    class="
                        sm:w-1/2
                        xl:w-3/5
                        h-full
                        hidden
                        md:flex
                        flex-auto
                        items-center
                        justify-center
                        p-10
                        overflow-hidden
                        bg-purple-900
                        text-white
                        bg-no-repeat bg-cover
                        relative
                    "
                    style="background-image: url(assets/image/dog.jpg)"
                >
                    <div
                        class="
                            absolute
                            bg-gradient-to-b
                            from-indigo-600
                            to-blue-500
                            opacity-75
                            inset-0
                            z-0
                        "
                    ></div>
                    <div class="w-full max-w-md z-10">
                        <div class="sm:text-4xl xl:text-5xl font-bold leading-tight mb-6"
                            >StudyMonster</div
                        >
                        <div class="sm:text-sm xl:text-md text-gray-200 font-normal"
                            >Skills for your present (and your future). Get started with us.</div
                        >
                    </div>
                    <ul class="circles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <div
                    class="
                        md:flex md:items-center md:justify-center
                        w-full
                        sm:w-auto
                        md:h-full
                        w-2/5
                        xl:w-2/5
                        p-8
                        md:p-10
                        lg:p-14
                        sm:rounded-lg
                        md:rounded-none
                        bg-white
                    "
                >
                    <div class="max-w-md w-full mx-auto space-y-8">
                      <div class="text-center">
                          <h2 class="mt-6 text-3xl font-bold text-gray-900" style="color: red;"><?php if(isset($error)){echo $error;}?></h2>
                      </div>
                        <div class="text-center">
                            <h2 class="mt-6 text-3xl font-bold text-gray-900">Welcome!</h2>
                            <p class="mt-2 text-sm text-gray-500">Please login!</p>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <span class="h-px w-16 bg-gray-200"></span>
                            <span class="text-gray-300 font-normal">Please Enter Your Information Below</span>
                            <span class="h-px w-16 bg-gray-200"></span>
                        </div>
                        <form class="mt-8 space-y-6" action="index.php" method="POST">
                            <input type="hidden" name="remember" value="true" />
                            <div class="relative">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Username</label
                                >
                                <input
                                    name="username"
                                    class="
                                        w-full
                                        text-base
                                        px-4
                                        py-2
                                        border-b border-gray-300
                                        focus:outline-none
                                        rounded-2xl
                                        focus:border-indigo-500
                                    "
                                    type="text"
                                    placeholder="Enter your Username"
                                />
                            </div>
                            <div class="mt-8 content-center">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Password</label
                                >
                                <input
                                    name="password"
                                    class="
                                        w-full
                                        content-center
                                        text-base
                                        px-4
                                        py-2
                                        border-b
                                        rounded-2xl
                                        border-gray-300
                                        focus:outline-none focus:border-indigo-500
                                    "
                                    type="password"
                                    placeholder="Enter your password"
                                />
                            </div>
                            <div class="mt-8 content-center">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Login as a/an:</label
                                >
                                <select class="
                                    w-full
                                    content-center
                                    text-base
                                    px-4
                                    py-2
                                    border-b
                                    rounded-2xl
                                    border-gray-300
                                    focus:outline-none focus:border-indigo-500"
                                    name=role>
                                  <option value="student">Student</option>
                                  <option value="teacher">Professor</option>
                                  <option value="teacher">Admin</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input
                                        id="remember_me"
                                        name="remember_me"
                                        type="checkbox"
                                        class="
                                            h-4
                                            w-4
                                            bg-blue-500
                                            focus:ring-blue-400
                                            border-gray-300
                                            rounded
                                        "
                                    />
                                    <label
                                        for="remember_me"
                                        class="ml-2 block text-sm text-gray-900"
                                        >Remember me</label
                                    >
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="text-indigo-400 hover:text-blue-500"
                                        >Forgot your password?</a
                                    >
                                </div>
                            </div>
                            <div>
                                <button
                                    name="submit"
                                    type="submit"
                                    class="
                                        w-full
                                        flex
                                        justify-center
                                        bg-gradient-to-r
                                        from-indigo-500
                                        to-blue-600
                                        hover:bg-gradient-to-l
                                        hover:from-blue-500
                                        hover:to-indigo-600
                                        text-gray-100
                                        p-4
                                        rounded-full
                                        tracking-wide
                                        font-semibold
                                        shadow-lg
                                        cursor-pointer
                                        transition
                                        ease-in
                                        duration-500
                                    "
                                    >Log in</button
                                >
                            </div>
                            <p
                                class="
                                    items-center
                                    justify-center
                                    mt-10
                                    text-center text-md text-gray-500
                                "
                            >
                                <span>Don't have account yet? Register!</span>
                                <a
                                    href="signup.php"
                                    class="
                                        text-indigo-400
                                        hover:text-blue-500
                                        no-underline
                                        hover:underline
                                        cursor-pointer
                                        transition
                                        ease-in
                                        duration-300
                                    "
                                    >Register</a
                                >
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div></body
    >
</html>
