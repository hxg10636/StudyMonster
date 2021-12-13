<?php
require('../database_handler.php');
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT * FROM student WHERE uid='$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//Available
$query = "SELECT c.course_id, c.name, c.description, c.duration, c.course_pict, t.name AS tname FROM course c INNER JOIN teacher t ON t.id = c.instructor_id WHERE c.status = '1' ORDER BY c.course_id";
$result1 = mysqli_query($connection,$query);

//Chosen
$query = "SELECT sc.course_id, sc.grade, sc.certificate_id AS cerid, certificate.url, c.name, c.duration, t.name AS tname, c.course_pict, c.description FROM course c INNER JOIN teacher t ON t.id = c.instructor_id INNER JOIN student_course sc ON sc.course_id = c.course_id INNER JOIN student s ON s.id = sc.student_id LEFT JOIN certificate ON sc.certificate_id=certificate.certificate_id WHERE s.uid = '$username'";
$result2 = mysqli_query($connection,$query);

//Chose
if (isset($_POST['submit'])){
    $sid = $sname['id'];
    $cid = $_POST['submit'];

    $query = "INSERT INTO student_course (student_id, course_id) VALUES ('$sid','$cid')";
    $result = mysqli_query($connection,$query);
    mysqli_free_result($result);
    header('Location: edit_course.php?success=1');
}

//Cancel
if (isset($_POST['submit1'])){
    $id = $_POST['submit1'];
    $query  = "DELETE FROM student_course WHERE course_id = $id";
    $result = mysqli_query($connection, $query);
    mysqli_free_result($result);
    header('Location: edit_course.php?success=update');
}
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
								<h5 class="mb-1"><?php echo $sname['name'];?></h5>
								<p class="mb-0 text-muted"><?php echo $sname['userEmails'];?></p>
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
								src="../assets/img/avatars/<?php echo $sname['avatar'];?>"
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
										src="../assets/img/avatars/<?php echo $sname['avatar'];?>"
										class="rounded-circle"
									/>
								</div>
								<div class="ms-3 lh-1">
									<h5 class="mb-1"><?php echo $sname['name'];?></h5>
									<p class="mb-0 text-muted"><?php echo $sname['userEmails'];?></p>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li>
								<a
									class="dropdown-item"
									href="dashboard.php"
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
 								<img src="../assets/img/avatars/<?php echo $sname['avatar'];?>" class="avatar-xl rounded-circle border border-4 border-white"
 									alt="" />
 							</div>
 							<div class="lh-1">
 								<h2 class="mb-0">
 									<?php echo $sname['name'];?>
 								</h2>
                <p class="mb-0 d-block">Student</p>
 							</div>
 						</div>
            <div>
            <a href="home.php" class="btn btn-primary btn-sm d-none d-md-block">Back to Homepage</a>
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
 									<li class="nav-item ">
 										<a class="nav-link" href="dashboard.php"><i class="fe fe-settings nav-icon"></i>Edit Profile</a>
 									</li>
 									<!-- Nav item -->
 									<li class="nav-item">
 										<a class="nav-link" href="../logout.php"><i class="fe fe-power nav-icon"></i>Sign Out</a>
 									</li>
 								</ul>
                <span class="navbar-header">Course Settings</span>
                <!-- Nav item -->
                <li class="nav-item active">
                  <ul class="list-unstyled ms-n2 mb-0">
                  <a class="nav-link" href="edit_course.php"><i class="fe fe-credit-card nav-icon"></i>Edit Course</a>
                </li>
                </ul>
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
    <!-- Card -->
    <div class="card mb-4">
      <!-- Card header -->
      <div class="card-header">
        <h3 class="mb-0">Courses</h3>
        <span>Manage your courses and its update like live, draft and
          insight.</span>
      </div>
      <!-- Card body -->
      <!-- Table -->
      <div class="table-responsive border-0 overflow-y-hidden">
        <form method="post" action="">
      <table id="example" class="table mb-0 text-nowrap" style="width:100%">
        <thead>
            <tr>
                <th class="per5">#</th>
                <th class="per5">Course Name</th>
                <th class="per5">Duration</th>
                <th class="per5">Grade</th>
                <th class="per5">Teacher</th>
                <th class="per5">Certificate?</th>                
                <th class="per5">Action</th>
            </tr>
        </thead>
          <tbody>
            <?php
            $i=1;
            while($row=mysqli_fetch_array($result2)){
                echo "<tr>";
                echo "<td class='center'>".$i."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['duration']."</td>";
                echo "<td>".$row['grade']."</td>";                
                echo "<td>".$row['tname']."</td>";
                if (is_null($row['cerid'])){
                    echo "<td><button class='btn btn-xs btn-warning' disabled>No Certificate</button></td>";   
                } else {
                   echo "<td><a href='../assets/upload/certificate/".$row['url'] ."' class='btn btn-xs btn-success'>Download</a>";
                }
                echo "<td><button class='btn btn-xs btn-danger' type='submit' name='submit1' value='".$row['course_id']."'>Withdraw</button></td>";
                echo "</tr>";
                $i++;
            }
            mysqli_free_result($result2);
            mysqli_close($connection);
            ?>
          </tbody>
      </table>
      </form>
      </div>
    </div>
    </div>

 				</div>
 			</div>
 		</div>
 	</div>

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
 </body>
 </html>
