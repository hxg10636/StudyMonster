<?php
// make db conection
require('../database_handler.php');
// Check if person is logged in
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, uid, userEmails,avatar,dob FROM teacher WHERE uid='$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//Update basic info
if(isset($_POST['submit'])){
    $dob=$_POST['dob'];
    $email=$_POST['email'];

    $query = "UPDATE teacher SET dob = '$dob', userEmails = '$email' WHERE uid = '$username'";
    $result1 = mysqli_query($connection,$query);
    mysqli_free_result($result1);
    header('Location: home.php?success=update');
}

// //Course information
$query = "SELECT c.course_id, c.name, duration FROM course c INNER JOIN teacher t ON t.id = c.instructor_id WHERE uid = '$username'";
$result = mysqli_query($connection,$query);

//Upload avatar
if(isset($_POST['submit1'])){
    if ($_FILES['file']['error']){
    switch ($_FILES['file']['error']){
        case 1:
            $str="More than the values set in php.ini";
            break;
        case 2:
            $str="More than the values set in the form";
            break;
        case 3:
            $str="Only part of the file is uploaded";
            break;
        case 4:
            $str="No files are uploaded";
            break;
        case 5:
            $str="Unable to find a temporary folder";
            break;
        case 6:
            $str="File write failure";
            break;
    }
    die($str);
    }
    //Determine the permitted size of the file
    if ($_FILES['file']['size'] > (pow(1024,2)*2)){ //(pow(1024,2)*2) == 2M
        header('Location: home.php?success=1');
    }
    //Determine the permitted MIME type, file extension
    $allowMime = ['image/png','image/jpeg','image/gif','image/jpg'];
    $allowFix = ['png','jpeg','gif','jpg'];

    $info = pathinfo($_FILES['file']['name']);
    $subFix = $info['extension'];
    if(!in_array($subFix,$allowFix)){
        header('Location: home.php?success=1');
    }
    if(!in_array($_FILES['file']['type'],$allowMime)){
        header('Location: home.php?success=1');
    }

    //Stitching the path to upload
    $path = "../assets/img/avatars/";
    if (!file_exists($path)){
        mkdir($path);
    }
    //File name random
    $name = uniqid().'.'.$subFix;
    //Determine if the file is uploaded
    if (is_uploaded_file($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'] , $path.$name)){
            $query = "UPDATE teacher SET avatar = '$name' WHERE uid = '$username'";
            $result2 = mysqli_query($connection,$query);
            mysqli_free_result($result2);
            header('Location: home.php?success=avatar');
        }else{
            header('Location: home.php?success=1');
        }
    }else{
        header('Location: home.php?success=1');
    }
}

//Change password
if(isset($_POST['submit2'])){
        $old_pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $query = "SELECT pwd FROM teacher WHERE uid = '$username'";
        $pass = mysqli_fetch_array(mysqli_query($connection, $query));
        mysqli_free_result(mysqli_query($connection, $query));
        if($pass['pwd']==$old_pass && $pass1==$pass2){
            $query = "UPDATE teacher SET pwd = '$pass1' WHERE uid = '$username'";
            $result3 = mysqli_query($connection, $query);
            mysqli_free_result($result3);
            header('Location: home.php?success=password');
        } else {
            header('Location: home.php?success=1');
        }
    }
mysqli_close($connection);

 ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
 	<!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon icon-->
 <link rel="shortcut icon" type="image/x-icon" href="../assets/image/Logo.png">


 <!-- Libs CSS -->

 <link href="../assets/fonts/feather/feather.css" rel="stylesheet">
 <link href="../assets/libs/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
 <link href="../assets/libs/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
 <link href="../assets/libs/dragula/dist/dragula.min.css" rel="stylesheet" />
 <link href="../assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
 <link href="../assets/libs/dropzone/dist/dropzone.css" rel="stylesheet" />
 <link href="../assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet" />
 <link href="../assets/libs/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
 <link href="../assets/libs/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
 <link href="../assets/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet">
 <link href="../assets/libs/tippy.js/dist/tippy.css" rel="stylesheet">
 <link href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
 <link href="../assets/libs/prismjs/themes/prism-okaidia.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 <link href="../assets/css/plugins.css" rel="stylesheet" />
 <link href="../assets/css/main.css" rel="stylesheet" />
<link href="../assets/css/icons.css" rel="stylesheet" />
<style>
  /* ------------------ Alerts --------------------*/
  .alert .close {
    opacity: 1;
  }
  .alert.alert-warning .close {
    color: #ef8d1b;
  }
  .alert.alert-warning .close:hover,
  .alert.alert-warning .close:focus {
    color: #e08110;
  }
  .alert.alert-success .close {
    color: #4ac77c;
  }
  .alert.alert-success .close:hover,
  .alert.alert-success .close:focus {
    color: #3bbd6e;
  }
  .alert.alert-danger .close {
    color: #f35454;
  }
  .alert.alert-danger .close:hover,
  .alert.alert-danger .close:focus {
    color: #f13d3d;
  }
  .alert.alert-info .close {
    color: #3498da;
  }
  .alert.alert-info .close:hover,
  .alert.alert-info .close:focus {
    color: #268ccf;
  }
  .close {
    float: right;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    color: #000000;
    text-shadow: 0 1px 0 #ffffff;
    opacity: 0.2;
    filter: alpha(opacity=20);
  }
  .close:hover,
  .close:focus {
    color: #000000;
    text-decoration: none;
    cursor: pointer;
    opacity: 0.5;
    filter: alpha(opacity=50);
  }
  button.close {
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
    -webkit-appearance: none;
  }
  .alert-dismissable .close {
    position: relative;
    top: -2px;
    right: -21px;
    color: inherit;
  }
  .text-logo, .text-slogan {
    font-weight: bold;
    font-family: 'Droid Sans';
    font-size: 24px;
    text-transform: uppercase;
    display: inline-block;
  }
  .text-logo {
    color: #124363;
  }
  input[type="file"] {
      display: none;
  }
  .custom-file-upload {
      border: 1px solid #ccc;
      display: inline-block;
      padding: 6px 12px;
      cursor: pointer;
  }
 </style>
 <!-- Theme CSS -->
 <link rel="stylesheet" href="../assets/css/theme.min.css">
 	<title>StudyMonster - Instructor Dashboard</title>
 </head>

 <body>
 	<!-- Page Content -->
<nav class="navbar navbar-expand-lg navbar-default">
	<div class="container-fluid px-0">
        <a class="navbar-brand" href="home.php">
            <img src="/assets/image/Logo.png" width="50" height="50"><span class="text-logo">Study</span><span class="text-slogan">M</span>
        </a>
		<!-- Mobile view nav wrap -->
		<ul
			class="navbar-nav navbar-right-wrap ms-auto d-lg-none d-flex nav-top-wrap"
		>
			<li class="dropdown ms-2">
				<div class="dropdown-menu dropdown-menu-end shadow">
					<div class="dropdown-item">
						<div class="d-flex">
							<div class="ms-3 lh-1">
								<h5 class="mb-1"><?php echo $tname['name'];?></h5>
								<p class="mb-0 text-muted"><?php echo $tname['userEmails'];?></p>
							</div>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled">
						<li>
							<a class="dropdown-item" href="../index.html">
								<i class="fe fe-power me-2"></i>Sign Out
							</a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<!-- Button -->
		<button
			class="navbar-toggler collapsed"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbar-default"
			aria-controls="navbar-default"
			aria-expanded="false"
			aria-label="Toggle navigation"
		>
			<span class="icon-bar top-bar mt-0"></span>
			<span class="icon-bar middle-bar"></span>
			<span class="icon-bar bottom-bar"></span>
		</button>
		<!-- Collapse -->
				</li>

				<li class="dropdown ms-2 d-inline-block">
					<a
						class="rounded-circle"
						href="#"
						data-bs-toggle="dropdown"
						data-bs-display="static"
						aria-expanded="false"
					>
						<div class="avatar avatar-md avatar-indicators avatar-online">
							<img
								alt="avatar"
								src="../assets/img/avatars/<?php echo $tname['avatar'];?>"
								class="rounded-circle"
							/>
						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<div class="dropdown-item">
							<div class="d-flex">
								<div class="avatar avatar-md avatar-indicators avatar-online">
									<img
										alt="avatar"
										src="../assets/img/avatars/<?php echo $tname['avatar'];?>"
										class="rounded-circle"
									/>
								</div>
								<div class="ms-3 lh-1">
									<h5 class="mb-1"><?php echo $tname['name'];?></h5>
									<p class="mb-0 text-muted"><?php echo $tname['userEmails'];?></p>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li>
								<a
									class="dropdown-item"
									href="home.php"
								>
									<i class="fe fe-user me-2"></i>Profile
								</a>
							</li>
						</ul>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li>
								<a class="dropdown-item" href="../logout.php">
									<i class="fe fe-power me-2"></i>Sign Out
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>

 	<div class="pt-5 pb-5">
 		<div class="container">
 				<!-- User info -->
 			<div class="row align-items-center">
 				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
 					<!-- Bg -->
 					<div class="pt-16 rounded-top-md" style="
 								background: url(../assets/images/background/profile-bg.jpg) no-repeat;
 								background-size: cover;
 							"></div>
 					<div
 						class="d-flex align-items-end justify-content-between bg-white px-4 pt-2 pb-4 rounded-none rounded-bottom-md shadow-sm">
 						<div class="d-flex align-items-center">
 							<div class="me-2 position-relative d-flex justify-content-end align-items-end mt-n5">
 								<img src="../assets/img/avatars/<?php echo $tname['avatar'];?>" class="avatar-xl rounded-circle border border-4 border-white"
 									alt="" />
 							</div>
 							<div class="lh-1">
 								<h2 class="mb-0">
 									<?php echo $tname['name'];?>
 								</h2>
                <p class="mb-0 d-block">Teacher</p>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 	<!-- Content -->
 	<div class="row mt-0 mt-md-4">
 				<div class="col-lg-3 col-md-4 col-12">
 					<!-- Side navbar -->
 					<nav class="navbar navbar-expand-md navbar-light shadow-sm mb-4 mb-lg-0 sidenav">
 						<!-- Menu -->

 						<!-- Button -->
 						<button class="navbar-toggler d-md-none icon-shape icon-sm rounded bg-primary text-light" type="button"
 							data-bs-toggle="collapse" data-bs-target="#sidenav" aria-controls="sidenav" aria-expanded="false"
 							aria-label="Toggle navigation">
 							<span class="fe fe-menu"></span>
 						</button>
 						<!-- Collapse navbar -->
 						<div class="collapse navbar-collapse" id="sidenav">
 							<div class="navbar-nav flex-column">
 								<span class="navbar-header">Account Settings</span>
                 <!-- List -->
 								<ul class="list-unstyled ms-n2 mb-0">
 									<!-- Nav item -->
 									<li class="nav-item active">
 										<a class="nav-link" href="home.php"><i class="fe fe-settings nav-icon"></i>Edit Profile</a>
 									</li>
 									<!-- Nav item -->
 									<li class="nav-item">
 										<a class="nav-link" href="../logout.php"><i class="fe fe-power nav-icon"></i>Sign Out</a>
 									</li>
 								</ul>
                <span class="navbar-header">Course Settings</span>
                <!-- Nav item -->
                <li class="nav-item">
                  <ul class="list-unstyled ms-n2 mb-0">
                  <a class="nav-link" href="course.php"><i class="fe fe-credit-card nav-icon"></i>Edit Course</a>
                </li>
                </ul>
                <span class="navbar-header">Student Settings</span>
                <li class="nav-item">
                  <ul class="list-unstyled ms-n2 mb-0">
                  <a class="nav-link" href="student.php"><i class="fe fe-user nav-icon"></i>Edit Student</a>
                </li>
                </ul>
 							</div>
 						</div>
 					</nav>
 				</div>
 				<div class="col-lg-9 col-md-8 col-12">
 					<!-- Card -->
<?php
if(isset($_GET['success'])){
   if($_GET['success']=="update"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Something Changed!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="avatar"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Your Avatar Changed!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="coursefile"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Course File Uploaded!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="password"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Password Updated!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="1"){
     echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
       <strong>Error!</strong> Nothing Changed!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   }
}
?>

 					<div class="card">
 						<!-- Card header -->
 						<div class="card-header">
 							<h3 class="mb-0">Profile Details</h3>
 							<p class="mb-0">
 								You have full control to manage your own account setting.
 							</p>
 						</div>
 						<!-- Card body -->
 						<div class="card-body">
 							<div class="d-lg-flex align-items-center justify-content-between">
 								<div class="d-flex align-items-center mb-4 mb-lg-0">
 									<img src="../assets/img/avatars/<?php echo $tname['avatar'];?>" id="img-uploaded" class="avatar-xl rounded-circle" alt="" />
 									<div class="ms-3">
 										<h4 class="mb-0">Your avatar</h4>
 										<p class="mb-0">
 											PNG or JPG no bigger than 800px wide and tall.
 										</p>
 									</div>
 								</div>
 								<div>
                  <form action="home.php" method="post" enctype="multipart/form-data" role="form" id="validate">
 									<input id="file-upload" type="file" name="file" class="btn btn-outline-white btn-sm"><label for="file-upload" class="custom-file-upload"><i >👈</i> Upload Your Profile Picture Here</label>
 									<button type="submit" name="submit1" class="btn btn-outline-danger btn-sm">Update</button></form>
 								</div>
 							</div>
 							<hr class="my-5" />
 							<div>
 								<h4 class="mb-0">Personal Details</h4>
 								<p class="mb-4">
 									Edit your personal information.
 								</p>
 								<!-- Form -->
 								<form class="row" role="form" method="post" action="home.php">
 									<!-- name -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="fname">Full Name</label>
 										<input type="text" class="form-control" value="<?php echo $tname['name'];?>" disabled>
 									</div>
 									<!-- Birthday -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="birth">Birthday</label>
 										<input class="form-control flatpickr" type="text" value="<?php echo $tname['dob'];?>" id="birth" name="dob" />
 									</div>
 									<!-- Address -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="address">Email</label>
 										<input type="email" class="form-control" name="email" value="<?php echo $tname['userEmails'];?>">
 									</div>
 									<div class="col-12">
 										<!-- Button -->
 										<button class="btn btn-primary" type="submit" name="submit">
 											Update Profile
 										</button>
 									</div>
 								</form>
                <hr/>
                <h4 class="mb-0">Password Change</h4>
                <p class="mb-4">
                  Edit your password.
                </p>
                <form class="row" role="form" method="post" action="home.php">
                  <!-- np -->
                  <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="fname">New Password</label>
                    <input type="password" class="form-control" name="pass1" required/>
                  </div>
                  <!-- rnp -->
                  <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="birth">Repeat New Password</label>
                    <input type="password" class="form-control" name="pass2" required/>
                  </div>
                  <!-- op -->
                  <div class="mb-3 col-12 col-md-6">
                    <label class="form-label" for="address">Original Password</label>
                    <input type="password" class="form-control" name="pass" required/>
                  </div>
                  <div class="col-12">
                    <!-- Button -->
                    <button class="btn btn-primary" type="submit" name="submit2">
                      Update Password
                    </button>
                  </div>
                </form>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>

 	<!-- Scripts -->
 	<!-- Libs JS -->
 <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
 <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <script src="../assets/libs/odometer/odometer.min.js"></script>
 <script src="../assets/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
 <script src="../assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
 <script src="../assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
 <script src="../assets/libs/flatpickr/dist/flatpickr.min.js"></script>
 <script src="../assets/libs/inputmask/dist/jquery.inputmask.min.js"></script>
 <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
 <script src="../assets/libs/quill/dist/quill.min.js"></script>
 <script src="../assets/libs/file-upload-with-preview/dist/file-upload-with-preview.min.js"></script>
 <script src="../assets/libs/dragula/dist/dragula.min.js"></script>
 <script src="../assets/libs/bs-stepper/dist/js/bs-stepper.min.js"></script>
 <script src="../assets/libs/dropzone/dist/min/dropzone.min.js"></script>
 <script src="../assets/libs/jQuery.print/jQuery.print.js"></script>
 <script src="../assets/libs/prismjs/prism.js"></script>
 <script src="../assets/libs/prismjs/components/prism-scss.min.js"></script>
 <script src="../assets/libs/@yaireo/tagify/dist/tagify.min.js"></script>
 <script src="../assets/libs/tiny-slider/dist/min/tiny-slider.js"></script>
 <script src="../assets/libs/@popperjs/core/dist/umd/popper.min.js"></script>
 <script src="../assets/libs/tippy.js/dist/tippy-bundle.umd.min.js"></script>
 <script src="../assets/libs/typed.js/lib/typed.min.js"></script>
 <script src="../assets/libs/jsvectormap/dist/js/jsvectormap.min.js"></script>
 <script src="../assets/libs/jsvectormap/dist/maps/world.js"></script>
 <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="../assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
 <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="../assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
 <script src="../assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
 <script src="../assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

 <!--Picture pop up section starts-->
 <div id="outerdiv" style="text-align: center;position: fixed;z-index: 9999;top: 0;left: 0;
     width: 100%;height: 100%;background-color: rgba(28,28,28,0.9);">
     <img id="bigimg" style="max-height: 800px;max-width: 100%;border: 0;
         margin: auto;position: absolute;top: 0;bottom: 0;left: 0;right: 0;" src="" />
 </div>



 <script type="text/javascript">

     $("#outerdiv").hide();
     $(function(){
     $("img").mouseover(function(){
       $(this).css("cursor","pointer");
     });

     $("img").click(function(){
       var _this = $(this);
       imgShow("#outerdiv", "#bigimg", _this);
     });
     });

     function imgShow(outerdiv, bigimg, _this){
         var src = _this.attr("src");
         $('#outerdiv').attr('display','block');
         $(bigimg).attr("src", src);
          $(outerdiv).fadeIn("fast");
     }
     $(outerdiv).click(function(){
         $(this).fadeOut("fast");
     });
 </script>

 <!-- Theme JS -->
 <script src="../assets/js/theme.min.js"></script>
 </body>
 </html>
