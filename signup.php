<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Signup Page</title>

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
                        <div><?php 
                                if (isset($_GET["error"])) {
            
                                if ($_GET["error"] == "emptyfields") {
                                    
                                    echo "<h3 style='color: red;'>Please Enter Your Information!</h3>";
                                    
                                } elseif ($_GET["error"] == "invalidmail") {
                                    
                                    echo "<h3 style='color: red;'>Please Enter Correct Email Address!</h3>";
                                    
                                } elseif ($_GET["error"] == "passwordcheck") {
                                    
                                    echo "<h3 style='color: red;'>Please Enter Same Password!</h3>";
                                    
                                } elseif ($_GET["error"] == "sqlerror") {
                                    
                                    echo "<h3 style='color: red;'>Database Connection Failed!</h3>";
                                    
                                } elseif ($_GET["error"] == "usertaken") {
                                    
                                    echo "<h3 style='color: red;'>The Username/Email Address has already taken!</h3>";
                                    
                                } elseif ($_GET["signup"] == "success") {
                                    
                                    echo "<h3 style='color: red;'>Register Success!</h3>";
                                    
                                }
                            }
                            ?>
                        </div>
                        <div class="text-center">
                            <h2 class="mt-6 text-3xl font-bold text-gray-900">Register</h2>
                            <p class="mt-2 text-sm text-gray-500">Enter your information.</p>
                        </div>

<!-- required filed starts here. -->
                        <form class="mt-8 space-y-6" action="signup_process.php" method="POST">
                            <div class="relative">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Your Name</label
                                >
                                <input
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
                                    name="uname"
                                    placeholder="Enter your name"
                                />
                            </div>
                            <div class="relative">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Your Username</label
                                >
                                <input
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
                                    name="uid"
                                    placeholder="Enter your username"
                                />
                            </div>
                            <div class="relative">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Email Address</label
                                >
                                <input
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
                                    name="mail"
                                    placeholder="Enter your Email address"
                                />
                            </div>
                            <div class="relative">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Date of Birth</label
                                >
                                <input
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
                                    type="date"
                                    name="dob"
                                    placeholder="Enter your date of birth"
                                />
                            </div>
                            <div class="mt-8 content-center">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Password</label
                                >
                                <input
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
                                    name="password"
                                    placeholder="Enter your password"
                                />
                            </div>
                            <div class="mt-8 content-center">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Repeat Password</label
                                >
                                <input
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
                                    name="password-repeat"
                                    placeholder="Enter your password again"
                                />
                            </div>
                            <div class="mt-8 content-center">
                                <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide"
                                    >Do you want to register as a/an:</label
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
                                    name=usertype>
                                  <option value="Student">Student</option>
                                  <option value="Professor">Professor</option>
                                </select>
                            </div>
                            <div>
                                <button
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
                                    name="signup-submit"
                                    >Sign up</button
                                >
                            </div>
                            <div><a href="index.php" style="color:blue;">👈Go back</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div></body
    >
</html>
