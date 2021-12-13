<?php

require('../database_handler.php');
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

if (isset($_GET['id'])){
    $id = $_GET['id'];

    //Course info
    $query = "SELECT c.name AS cname, t.name AS tname, c.description, c.duration, c.course_pict FROM course c inner JOIN teacher t on c.instructor_id = t.id WHERE c.course_id = $id";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    mysqli_free_result(mysqli_query($connection, $query));
    $teacher = $row['tname'];
    $course_pict = $row['course_pict'];

    //Course information
    $query = "SELECT sc.student_id, sc.course_id, sc.Enrolldate, sc.grade, sc.certificate_id AS cerid, certificate.url AS cerurl, c.name AS cname, c.duration, t.name AS tname FROM student_course sc INNER JOIN course c ON sc.course_id = c.course_id INNER JOIN teacher t ON c.instructor_id = t.id LEFT JOIN certificate ON sc.certificate_id = certificate.certificate_id WHERE student_id = '$id'";
    $result = mysqli_query($connection,$query);
    
    //Enrolled Courses and grades
    $query = "SELECT c.name AS cname, sc.grade FROM student_course sc INNER JOIN course c ON sc.course_id = c.course_id WHERE student_id = '$id'";
    $resultxxx = mysqli_query($connection,$query);
    
    //select all avaliable certificates
    $query = "SELECT * FROM certificate";
    $certificate1 = mysqli_query($connection,$query);    
    
    
    //Enrolled Courses and grades for certificate
    $query = "SELECT c.name AS cname, sc.student_id, sc.certificate_id FROM student_course sc INNER JOIN course c ON sc.course_id = c.course_id WHERE sc.certificate_id is NULL AND sc.student_id = '$id'";
    $resultxxxx2 = mysqli_query($connection,$query);    

    
    //Student info
    $query = "SELECT id, name,uid, userEmails,avatar,dob FROM student  WHERE id='$id'";
    $sname = mysqli_fetch_array(mysqli_query($connection, $query));
    mysqli_free_result(mysqli_query($connection, $query));
    
} else {
  header("Location: home.php");
}

//Update basic info
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $dob=$_POST['dob'];
    $email=$_POST['email'];

    $query = "UPDATE student SET dob = '$dob', userEmails = '$email' WHERE id = '$id'";
    $result1 = mysqli_query($connection,$query);
    mysqli_free_result($result1);
    header("Location: student_details.php?id=".$id."&success=update");
}

//Update student grade
if(isset($_POST['submit4'])){
    $id = $_POST['id'];
    $gcourse=$_POST['gcourse'];
    $grade=$_POST['grade'];

    $query = "UPDATE student_course SET grade = '$grade' WHERE course_id = (SELECT course_id FROM course WHERE name = '$gcourse') AND student_id = '$id'";
    $result55 = mysqli_query($connection,$query);
    mysqli_free_result($result55);
    header("Location: student_details.php?id=".$id."&success=update");
}

//Update student certificate_id
if(isset($_POST['submit5'])){
    $id = $_POST['id'];
    $cercourse=$_POST['cercourse'];
    $certificate=$_POST['certificate111'];


    // echo $id;
    // echo $cercourse;
    // echo $certificate;    
    $query = "UPDATE student_course SET certificate_id = (SELECT certificate_id FROM certificate WHERE name = '$certificate') WHERE course_id = (SELECT course_id FROM course WHERE name = '$cercourse') AND student_id = '$id'";
    $result55 = mysqli_query($connection,$query);
    mysqli_free_result($result55);
    header("Location: student_details.php?id=".$id."&success=update");
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
    color: white;
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
    <title><?php echo $sname['name']; ?>'s Profile | StudyMonster Admin Dashboard</title>
</head>

<body>
    <!-- Wrapper -->
<div id="db-wrapper">
 <!-- navbar vertical -->
  <!-- Sidebar -->
 <nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="home.php">
            <img src="../assets/image/Logo.png" width="20%" height="20%" alt="" />
            <span class="text-logo">Study</span><span class="text-slogan">M</span>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link  " href="#" data-bs-toggle="collapse" data-bs-target="#navDashboard" aria-expanded="false" aria-controls="navDashboard">
                    <i class="nav-icon fe fe-home me-2"></i> Dashboard
                </a>
                <div id="navDashboard" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item ">
                            <a class="nav-link" href="home.php">
                                    Overview
                                </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link  " href="profile.php">
                                    Profile
                                </a>
                        </li>                        
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navCourses" aria-expanded="false" aria-controls="navCourses">
                    <i class="nav-icon fe fe-book me-2"></i> Courses
                </a>
                <div id="navCourses"  class="collapse "  data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="course.php">
                                    All Courses
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="certificate.php">
                                    Certificate Center
                                </a>
                        </li>                         
                    </ul>
                </div>
            </li>
             <!-- Nav item -->
             <li class="nav-item">
                <a class="nav-link   collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navProfile" aria-expanded="false" aria-controls="navProfile">
                    <i class="nav-icon fe fe-user me-2"></i> User
                </a>
                <div id="navProfile" class="collapse show" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="teachers.php">
                                    Instructor
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="student.php">Students</a
                                >
                            </li>
                        </ul>
                    </div>
                </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <div class="nav-divider"></div>
                        </li>

                        <li class="nav-item">
                            <div class="nav-divider"></div>
                        </li>


                    </ul>

                </div>
</nav>
        <!-- Page Content -->
        <div id="page-content">
            <div class="header">
    <!-- navbar -->
    <nav class="navbar-default navbar navbar-expand-lg">
        <a id="nav-toggle" href="#">
            <i class="fe fe-menu"></i>
        </a>

        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">

            <!-- List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="../../assets/img/avatars/<?php echo $tname['avatar']; ?>" class="rounded-circle" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="dropdown-item">
                        <div class="d-flex">
                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                <img alt="avatar" src="../../assets/img/avatars/<?php echo $tname['avatar']; ?>" class="rounded-circle" />
                            </div>
                            <div class="ms-3 lh-1">
                                <h5 class="mb-1"><?php echo $tname['name']; ?></h5>
                                <p class="mb-0 text-muted"><?php echo $tname['userEmails']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled">

                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fe fe-user me-2"></i> Profile
                            </a>
                        </li>

                    </ul>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled">
                        <li>
                            <a class="dropdown-item" href="../logout.php">
                                <i class="fe fe-power me-2"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>

 <div class="container-fluid p-4">
                   <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-4 mb-4 d-md-flex justify-content-between align-items-center">
                            <div class="mb-3 mb-md-0">
                                <h1 class="mb-0 h2 fw-bold"><?php echo $sname['name']; ?>'s Profile</h1>
                            </div>

                        </div>
                    </div>
                </div>  
                
                
<div class="col-xl-8 col-lg-12 col-md-12 col-12">
                            <!-- Card body -->
                            <div class="card-body">
                                

 	<!-- Content -->
 	<div class="row mt-0 mt-md-4">
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

 						<!-- Card body -->
 						<div class="card-body">
 							<div class="d-lg-flex align-items-center justify-content-between">
 								<div class="d-flex align-items-center mb-4 mb-lg-0">
 									<img src="../assets/img/avatars/<?php echo $sname['avatar'];?>" id="img-uploaded" class="avatar-xl rounded-circle" alt="" />
 									<div class="ms-3">
 										<h4 class="mb-0"><?php echo $sname['name'];?>'s avatar</h4>
 									</div>
 								</div>
 							</div>
 							<hr class="my-5" />
 							<div>
 								<h4 class="mb-0">Personal Details</h4>
 								<p class="mb-4">
 									Edit your personal information.
 								</p>
 								<!-- Form -->
 								<form class="row" role="form" method="post" action="student_details.php">
 								    <input type="hidden" name="id" value="<?php echo $id;?>">
 									<!-- name -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="fname">Full Name</label>
 										<input type="text" class="form-control" value="<?php echo $sname['name'];?>" disabled>
 									</div>
 									<!-- Birthday -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="birth">Birthday</label>
 										<input class="form-control flatpickr" type="text" value="<?php echo $sname['dob'];?>" id="birth" name="dob" />
 									</div>
 									<!-- Address -->
 									<div class="mb-3 col-12 col-md-6">
 										<label class="form-label" for="address">Email</label>
 										<input type="email" class="form-control" name="email" value="<?php echo $sname['userEmails'];?>">
 									</div>
 									<div class="col-12">
 										<!-- Button -->
 										<button class="btn btn-primary" type="submit" name="submit">
 											Update Profile
 										</button>
 									</div>
 								</form>
                <hr/>
                             <div class="panel panel-default plain">
                                 <!-- Start .panel -->
                                 <div class="panel-heading white-bg">
                                     <h4 class="panel-title">This Student has Enrolled in:</h4>
                                 </div>
                                 <div class="panel-body">
                                     <table class="table table-hover">
                                         <thead>
                                             <tr>
                                                 <th class="per15">Course No</th>
                                                 <th class="per20">Course Name</th>
                                                 <th class="per20">Duration</th>
                                                 <th class="per10">Grade</th>                                                
                                                 <th class="per20">Enrollment Time</th>
                                                 <th class="per20">Teacher</th>
                                                 <th class="per20">Certificate?</th>                                                 
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php

                                             while($row=mysqli_fetch_array($result)){
                                                 echo "<tr>
                                                     <td>".$row['course_id']."</td>
                                                     <td>".$row['cname']."</td>
                                                     <td>".$row['duration']."</td>
                                                     <td>".$row['grade']."</td>                                                     
                                                     <td>".$row['Enrolldate']."</td>
                                                     <td>".$row['tname']."</td>";
                                                 if (is_null($row['cerid'])){
                                                     echo "<td><button class='btn btn-xs btn-danger' disabled>No</button></td>";
                                                 } else {
                                                     echo "<td><a href='../assets/upload/certificate/".$row['cerurl'] ."'><button class='btn btn-xs btn-success'>Download</button></a>";
                                                 }
                                                 echo "</tr>";
                                             }
                                             ?>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
 							</div>
 						</div>
 					</div>
 					
 				</div>
 			</div>

                             
                                
                            </div>
                            
                        
                    </div>
<div class="col-xl-6 col-lg-12 col-md-12 col-12">                    
    <div class="card">

 						<!-- Card body -->
 						<div class="card-body">
                             <div class="panel panel-default plain">
                                 
                                 <form class="row" role="form" method="post" action="">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                 <!-- Start .panel -->
                                 <div class="panel-heading white-bg">
                                     <h4 class="panel-title">Grading:</h4>
                                 </div>
                                 <div class="panel-body">
                                    <div class="col-lg-4 col-md-4">
                                                    <select class="form-control select2" name="gcourse">
                                                        <option></option>
                                                        <?php
                                                        while($row2=mysqli_fetch_array($resultxxx)){
                                                            echo "<option value=\"".$row2['cname']."\">".$row2['cname']."</option>";
                                                        }
                                                       mysqli_free_result($resultxxx);
                                                        ?>
                                                    </select>
                                                    <span class="help-block">Please select a course.</span><br/><br/>
                                                </div>
									<div class="col-lg-4 col-md-4">
 										<label class="form-label" for="address">Current Grades</label>
 										<input type="text" class="form-control" name="grade" placeholder="Plaease Enter Grades (0-100)">
 									</div><br/>
                            <button class="btn btn-primary" type="submit" name="submit4">
 							Update Grade
 								</button>            
                                 </div>
                                 </form>
                                 
                                 
                                 
                                 
                             </div>

 						</div><hr/>
 						
  						<div class="card-body">
                             <div class="panel panel-default plain">
                                 
                                 <form class="row" role="form" method="post" action="">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                 <!-- Start .panel -->
                                 <div class="panel-heading white-bg">
                                     <h4 class="panel-title">Send Certificate:</h4>
                                 </div>
                                 <div class="panel-body">
                                    <div class="col-lg-4 col-md-4">
                                                    <select class="form-control select2" name="cercourse">
                                                        <option></option>
                                                        <?php
                                                        while($row2=mysqli_fetch_array($resultxxxx2)){
                                                            echo "<option value=\"".$row2['cname']."\">".$row2['cname']."</option>";
                                                        }
                                                         mysqli_free_result($resultxxx2);   
                                                        ?>
                                                    </select>
                                                    <span class="help-block">Please select a course.</span><br/><br/>
                                                </div>
                                    <div class="col-lg-4 col-md-4">
                                                    <select class="form-control select2" name="certificate111">
                                                        <option></option>
                                                        <?php
                                                        while($row2=mysqli_fetch_array($certificate1)){
                                                            echo "<option value=\"".$row2['name']."\">".$row2['name']."</option>";
                                                        }
                                                       mysqli_free_result($certificate1);
                                                        ?>
                                                    </select>
                                                    <span class="help-block">Please select a certificate.</span><br/><br/>
                                                </div>
                            <button class="btn btn-primary" type="submit" name="submit5">
 							Send Certificate
 								</button>            
                                 </div>
                                 </form>
                                 
                                 
                                 
                                 
                             </div>

 						</div><hr/>						
 						
 						
 						
 						
 					</div> 
 </div>		
 <div class="col-xl-6 col-lg-12 col-md-12 col-12">                    
    <div class="card">


 					</div> 
 </div>			
</div>

    <!-- Script -->
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






<script>
$('#file-upload2').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload2')[0].files[0].name;
  $(this).prev('label').text(file);
});
</script>

<!-- Theme JS -->
<script src="../../assets/js/theme.min.js"></script>
</body>

</html>