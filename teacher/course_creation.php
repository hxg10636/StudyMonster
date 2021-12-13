<?php

// make db conection
require('../database_handler.php');
// Check if person is logged in
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
$tname1 = $tname['name'];
mysqli_free_result(mysqli_query($connection, $query));

//Teacher info
$query = "SELECT name FROM teacher";
$result1 = mysqli_query($connection,$query);

//Course info
$query = "SELECT c.course_id, c.name AS cname, description, course_pict, duration, t.name, t.uid, c.status FROM course c INNER JOIN teacher t ON t.id = c.instructor_id WHERE t.uid='$username'";
$result = mysqli_query($connection,$query);


//Add course
if (isset($_POST['submit'])){
    $cname = $_POST['cname'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $query = "INSERT INTO course (name, description, duration, instructor_id) VALUES ('$cname', '$description', '$duration', (SELECT id FROM teacher WHERE name = '$tname1'))";
    $result2 = mysqli_query($connection, $query);
    if(!$result2){
        header('Location: course.php?success=1');
    }else{
        header('Location: course.php?success=coursecreated');
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
<!-- Page header-->
<div class="py-4 py-lg-6 bg-primary">
  <div class="container">
    <div class="row">
      <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
        <div class="d-lg-flex align-items-center justify-content-between">
          <!-- Content -->
          <div class="mb-4 mb-lg-0">
            <h1 class="text-white mb-1">Add New Course</h1>
            <p class="mb-0 text-white lead">
              Just fill the form and create your courses.
            </p>
          </div>
          <div>
            <a href="course.php" class="btn btn-white ">Back to Course</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
<!-- Page Content -->
<div class="pb-12">
  <div class="container">
    <div id="courseForm" class="bs-stepper">
      <div class="row">
        <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
          <hr/>
          <div class="card">
              <!-- Card -->
              <form class="form-horizontal" role="form" method="post" action="course_creation.php">
              <div class="card mb-3 ">
                <div class="card-header border-bottom px-4 py-3">
                  <h4 class="mb-0">Basic Information</h4>
                </div>
                <!-- Card body -->
                <div class="card-body">
                  <div class="mb-3">
                    <label for="courseTitle" class="form-label">Course Title</label>
                    <input id="courseTitle" class="form-control" type="text" placeholder="Course Title" name="cname" required/>
                    <small>Write a 60 character course title.</small>
                  </div>
                  <div class="mb-3">
                    <label for="courseDur" class="form-label">Courses Duration</label>
                    <input id="courseDur" class="form-control" type="text" placeholder="Course Duration" name="duration" required />
                  </div>
                  <div class="mb-3">
                    <label for="courseIns" class="form-label">Courses Instructor</label>
                    <input type="text" class="form-control" value="<?php echo $tname['name'];?>" disabled>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Course Description</label>
                    <input id="editor" class="form-control" type="text" placeholder="Course Description" name="description" required/>
                    <small>A brief summary of your courses.</small>
                  </div>
                </div>
              </div>
          </div>
          <button type="submit" class="btn btn-danger mt-5" name="submit">
            Submit For Review
          </button>
          </form>
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
