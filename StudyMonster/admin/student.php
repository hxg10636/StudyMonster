<?php

// make db conection
require('../database_handler.php');
// Check if person is logged in
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//Teacher info
$query = "SELECT name FROM teacher";
$result1 = mysqli_query($connection,$query);

//Course info
$query = "SELECT c.course_id, c.name AS cname, description, course_pict, duration, t.name FROM course c INNER JOIN teacher t ON t.id = c.instructor_id";
$result = mysqli_query($connection,$query);

//Student info
$query = "SELECT s.id, s.name AS sname, s.uid, s.userEmails, s.avatar, s.dob FROM student s";
$result3 = mysqli_query($connection,$query);
mysqli_close($connection);
?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Geeks is a fully responsive and yet modern premium bootstrap template. Geek is feature-rich components and beautifully designed pages that help you create the best possible website and web application projects." />
<meta name="keywords" content="Geeks UI, bootstrap, bootstrap 5, Course, Sass, landing, Marketing, admin themes, bootstrap admin, bootstrap dashboard, ui kit, web app, multipurpose" />




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
    <link rel="stylesheet" href= "https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
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
    <title>Courses | StudyMonster Admin Dashboard</title>
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
                <div id="navDashboard" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item ">
                            <a class="nav-link" href="home.php">
                                    Overview
                                </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="profile.php">
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
                <div id="navCourses"  class="collapse"  data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="course.php">
                                    All Courses
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
                                <h1 class="mb-0 h2 fw-bold">Dashboard</h1>
                            </div>

                        </div>
                    </div>
                </div>  
                
            <div class="row">
                <!-- Start .row -->
                <!-- Start .page-header -->
                <div class="col-lg-12 heading">
                    <h1 class="page-header"><i class="im-accessibility"></i>Student Management</h1>
                    <?php
if(isset($_GET['success'])){
   if($_GET['success']=="del"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Student Deleted!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="2"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Student Information Changed!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } 
}
?>
                </div>
                <!-- End .page-header -->
                <div class="row">
                  <div class="col-lg-12">
                      <!-- col-lg-12 start here -->
                      <div class="page-header">
                          <h5>All Course</h5>
                      </div>
                      <table id="example" class="table table-striped" style="width:100%">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Avatar</th>
                                  <th>Name</th>
                                  <th>Student ID</th>
                                  <th>DOB</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php

                              $i=1;
                              while($row=mysqli_fetch_array($result3)){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                  echo "<td><img class='user-avatar' width='35' height='35' src='../assets/img/avatars/" .$row['avatar'] ."'></td>";
                                  echo "<td>".$row['sname']."</td>";
                                  echo "<td>".$row['id']."</td>";
                                  echo "<td>".$row['dob']."</td>";
                                  echo "<td><button class='btn btn-xs btn-primary' onclick=\"window.location.href='student_details.php?id=".$row['id']."'\">Edit Student</button></td>";
                                  echo "<td><button class='btn btn-xs btn-danger' onclick=\"window.location.href='student_deletion.php?id=".$row['id']."'\">Delete Student</button></td>";
                                  echo "</tr>";
                                  $i++;
                              }
                              mysqli_free_result($result3);
                              ?>
                          </tbody>
                      </table>
                  </div>


                </div>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

<script class='init' type='text/javascript'>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true,
        pagingType: 'numbers',
        pageLength: 10,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],
        columnDefs: [
            {
                targets: [ 0 ],
                visible: false,
                searchable: false
            },
        ],
        language: {
            zeroRecords: '<b>Sorry, not yet this Item for this Category to display</b>',    
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







<!-- Theme JS -->
<script src="../../assets/js/theme.min.js"></script>
</body>

</html>
