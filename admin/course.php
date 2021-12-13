<?php

// make db conection
require('../database_handler.php');
// Check if person is logged in
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));


$query = "SELECT name FROM teacher";
$result1 = mysqli_query($connection,$query);


$query = "SELECT c.course_id, c.name AS cname, description, course_pict, c.status, c.duration, t.name FROM course c INNER JOIN teacher t ON t.id = c.instructor_id";
$result = mysqli_query($connection,$query);


//Add course
if (isset($_POST['submit'])){
    $cname = $_POST['cname'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $tname = $_POST['name'];

    $query = "INSERT INTO course (name, description, duration, instructor_id) VALUES ('$cname', '$description', '$duration', (SELECT id FROM teacher WHERE name = '$tname'))";
    $result2 = mysqli_query($connection, $query);
    if(!$result){
        header('Location: course.php?success=2');
    }else{
        header('Location: course.php?success=coursecre');
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
                <div id="navCourses"  class="collapse  show"  data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="course.php">
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
                <div id="navProfile" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="teachers.php">
                                    Instructor
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="student.php">Students</a
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
                            <div class="d-flex">
                                <div class="input-group me-3  ">
                                    <input class="form-control flatpickr" type="text" placeholder="Select Date" aria-describedby="basic-addon2">

                                        <span class="input-group-text text-muted" id="basic-addon2"><i class="fe fe-calendar"></i></span>

                                </div>
                                <a href="#" class="btn btn-primary">Setting</a>
                            </div>
                        </div>
                    </div>
                </div>  
                
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                        <!-- Card -->
                        
                            <!-- Card body -->
                            <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                      <!-- col-lg-12 start here -->
                    <?php
if(isset($_GET['success'])){
   if($_GET['success']=="del"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Course Deleted!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="2"){
     echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
       <strong>Error!</strong> Cannot Delete the Course!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } elseif($_GET['success']=="1"){
     echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Done!</strong> Course Created!
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
   } 
}
?>                      

                        <button type="button" id="button3" class="btn btsize btn-default"><a><span><img src="https://icons.iconarchive.com/icons/icons8/ios7/24/Data-Alphabetical-Sorting-Za-icon.png" title="btn3"><br /><b>All</b></span></a></button>
                        <button type="button" id="button1" class="btn btsize btn-default"><a><span><img src="https://icons.iconarchive.com/icons/graphicloads/100-flat-2/24/check-1-icon.png" title="btn1"><br /><b>Passed</b></span></a></button>
                        <button type="button" id="button2" class="btn btsize btn-default"><a><span><img src="https://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/24/Status-dialog-warning-icon.png" title="btn2"><br /><b>Unreviewed</b></span></a></button>
                        <hr/>
                      <table id="example" class="table table-striped" style="width:100%">
                          
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Status</th>
                                  <th>Course ID</th>
                                  <th>Course Picture</th>
                                  <th>Course Name</th>
                                  <th>Description</th>
                                  <th>Duration</th>
                                  <th>Teacher</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php

                              $i=1;
                              while($row=mysqli_fetch_array($result)){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                   if($row['status']==1){
                                    echo "<td><button class='btn btn-xs btn-success' disabled >Passed</button></td>";
                                        }else{
                                        echo "<td><button class='btn btn-xs btn-warning' disabled>Unreviewed</button></td>";
                                            }
                                  echo "<td>".$row['course_id']."</td>";
                                  echo "<td><img class='user-avatar' width='200' height='100' src='../assets/img/coursepic/" .$row['course_pict'] ."'></td>";
                                  echo "<td>".$row['cname']."</td>";
                                  echo "<td>".$row['description']."</td>";
                                  echo "<td>".$row['duration']."</td>";
                                  echo "<td>".$row['name']."</td>";
                                  echo "<td><button class='btn btn-xs btn-primary' onclick=\"window.location.href='course_details.php?id=".$row['course_id']."'\">Edit</button></td>";
                                  echo "<td><button class='btn btn-xs btn-danger' onclick=\"window.location.href='course_deletion.php?id=".$row['course_id']."'\">Delete</button></td>";
                                  echo "</tr>";
                                  $i++;
                              }
                              mysqli_free_result($result);
                              ?>
                          </tbody>
                      </table>
                  </div>
                  <!-- adding course -->
                                  <div class="col-lg-12">
                                    <form class="form-horizontal" role="form" method="post" action="course.php">
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">Course Name</label>
                                        <div class="col-lg-10 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <input type="text" class="form-control" name="cname">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">Description</label>
                                        <div class="col-lg-10 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <input type="text" class="form-control" name="description">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">Duration</label>
                                        <div class="col-lg-10 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <input type="text" class="form-control" name="duration">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">Instructor</label>
                                        <div class="col-lg-10 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <select class="form-control select2" name="name">
                                                        <option></option>
                                                        <?php
                                                        while($row=mysqli_fetch_array($result1)){
                                                            echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
                                                        }
                                                        mysqli_free_result($result1);
                                                        ?>
                                                    </select>
                                                    <span class="help-block">Please select an instructor.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-12 control-label"></label>
                                        <div class="col-lg-10 col-md-10">
                                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                        </div>
                                    </div><br><br>
                                </form>
                                  </div>

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
