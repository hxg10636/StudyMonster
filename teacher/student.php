<?php

// make db conection
require('../database_handler.php');
// Check if person is logged in
require('../login_status.php');
mysqli_query($connection,'set names utf8');

//SELECT c.course_id, c.name AS cname, t.uid FROM course c INNER JOIN teacher t ON c.instructor_id = t.id WHERE t.uid = 'Professor1' GROUP BY c.course_id
$sql10 = "SELECT c.course_id, c.name AS cname, t.uid FROM course c INNER JOIN teacher t ON c.instructor_id = t.id WHERE t.uid = '$username' GROUP BY c.course_id";
$result4 = mysqli_query($connection,$sql10) or die(mysqli_error($connection));

$sql = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $sql));
mysqli_free_result(mysqli_query($connection, $sql));


$sql = "SELECT name FROM teacher";
$result1 = mysqli_query($connection,$sql) or die(mysqli_error($connection));

$sql = "SELECT c.course_id, c.name AS cname, description, course_pict, duration, t.name FROM course c INNER JOIN teacher t ON t.id = c.instructor_id";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));

$sql = "SELECT s.id, s.name AS sname, s.uid, s.userEmails, s.avatar, s.dob FROM student s";
$result3 = mysqli_query($connection,$sql) or die(mysqli_error($connection));

//studets infor group by courses
// $sql = "SELECT s.id, s.name AS sname, s.uid, s.userEmails, s.avatar, s.dob, c.name AS cname, sc.Enrolldate, sc.grade_point FROM student_course sc INNER JOIN student s ON sc.student_id = s.id INNER JOIN course c ON sc.course_id = c.course_id GROUP BY c.name";
// $result5 = mysqli_query($connection,$query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
 <!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">



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
<link rel="stylesheet" href= "https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<style>
.noshow {
  display: none;
}
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
           <div>
           <a href="course_creation.php" class="btn btn-primary btn-sm d-none d-md-block">Create New Course</a>
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
                 <li class="nav-item">
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
               <li class="nav-item active">
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
      <strong>Done!</strong> Course Information Changed!
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
  } elseif($_GET['success']=="coursecreated"){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Done!</strong> Course Created!
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
             <!-- Card -->
             <div class="card mb-4">
               <!-- Card header -->
               <div class="card-header">
                 <h3 class="mb-0">Students</h3>
                 <span>Manage your students here.</span>
               </div>
               <!-- Card body -->
               <!-- Table -->
               <div class="table-responsive border-0 overflow-y-hidden">
                    <div class='alert alert-warning alert-dismissible ' role='alert'>
                   <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                         </button>
                     <h4 class='alert-warning'>Attention!</h4>
                     <p>After creating a course, this page will automatically create a button for this course.</p>
                     <hr>
                     <p class='mb-0'>Click the button below to browse more details.</p>
                   </div>
                     <?php
                     while($row=mysqli_fetch_array($result4)){
                       $query = "SELECT s.avatar, s.name, s.id, s.dob, sc.grade FROM student s INNER JOIN student_course sc ON sc.student_id = s.id WHERE course_id = ".$row['course_id'];
                       $result2 = mysqli_query($connection,$query) or die(mysqli_error($connection));
                         echo "<script>
                                function hideandshowdiv".$row['course_id']."() {
                                  var x = document.getElementById('". $row['cname']."');
                                  if (x.style.display === 'none') {
                                    x.style.display = 'block';
                                  } else {
                                    x.style.display = 'none';
                                  }
                                }
                                </script>";
                         echo "<div>&nbsp;&nbsp;<button class='btn btn-xs btn-info'onclick='hideandshowdiv".$row['course_id']."()'' >".$row['cname']."</button></div>";
                         echo "<hr/>";
                         echo "<div class='noshow' id='".$row['cname']."'>";
                         echo "<table id='". $row['course_id'] ."' class='table table-striped display' style='width:100%'>";
                         echo "<caption>".$row['cname'] ."</caption>";
                         echo "<thead>
                             <tr>
                                 <th>#</th>
                                 <th>Student ID</th>
                                 <th>Avatar</th>
                                 <th>Name</th>
                                 <th>DOB</th>
                                 <th>Grade</th>
                                 <th>Edit</th>
                                 <!--<th>Delete</th>-->
                             </tr>
                         </thead>
                         <tbody>";
                                $i=1;
                               while($row11=mysqli_fetch_array($result2)){
                                   echo "<tr>";
                                   echo "<td>".$i."</td>";
                                   echo "<td>".$row11['id']."</td>";
                                   echo "<td><img class='user-avatar' width='25' height='25' src='../assets/img/avatars/" .$row11['avatar'] ."'></td>";
                                   echo "<td>".$row11['name']."</td>";
                                   echo "<td>".$row11['dob']."</td>";
                                   echo "<td>".$row11['grade']."</td>";
                                   echo "<td><button class='btn btn-xs btn-primary' onclick=\"window.location.href='student_details.php?id=".$row11['id']."'\">Edit Student</button></td>";
                                   echo "</tr>";
                                   $i++;
                               }
                               echo "</tbody>";
                           echo "</table>";
                           echo "</div>";
                               mysqli_free_result($result2);
                           }

                           mysqli_free_result($result4);
                           mysqli_close($connection);
                             ?>
               </div>
             </div>
             </div>

       </div>
     </div>
   </div>
 </div>
 <div id="outerdiv" style="text-align: center;position: fixed;z-index: 9999;top: 0;left: 0;
     width: 100%;height: 100%;background-color: rgba(28,28,28,0.9);">
     <img id="bigimg" style="max-height: 800px;max-width: 100%;border: 0;
         margin: auto;position: absolute;top: 0;bottom: 0;left: 0;right: 0;" src="" />
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script class='init' type='text/javascript'>
$(document).ready(function() {
var table = $('table.display').DataTable( {
responsive: true,
pagingType: 'simple_numbers',
pageLength: 5,
lengthMenu: [
    [5, 20, 50, 100, -1],
    [5, 20, 50, 100, 'All']
],
columnDefs: [
    {
        targets: [ 0 ],
        visible: false,
        searchable: false
    },
],
language: {
    zeroRecords: '<b>Sorry, no students registered for this course yet.</b>',
    lengthMenu: '<b>_MENU_</b>',
    info: '<b>&raquo; _START_ to _END_ of _TOTAL_</b>',
    search: '',
    searchPlaceholder: 'Enter keyword',
    infoFiltered: '<b>(filtered from _MAX_ total Items)</b>'
}
});

$('#button1').on( 'click', 'a', function () {

table
.columns( 1 )
.search( $(this).text() )
.draw();
});

$('#button2').on( 'click', 'a', function () {

table
.columns( 1 )
.search( $(this).text() )
.draw();
});

$('#button3').on('click', 'a', function() {

table
    .search('')
    .columns(1)
    .search('')
    .draw();
});

} );


</script>
<!--Picture pop up section starts-->

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
