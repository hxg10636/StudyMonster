<?php
require('../database_handler.php');
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT * FROM student WHERE uid='$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

//Available
$query = "SELECT c.course_id, c.name, c.description, c.duration, c.course_pict, t.name AS tname, t.avatar AS tavatar FROM course c INNER JOIN teacher t ON t.id = c.instructor_id WHERE c.status = '1' ORDER BY c.course_id";
$result1 = mysqli_query($connection,$query);

//Chosen
$query = "SELECT sc.course_id, c.name, c.duration, t.name AS tname, t.avatar AS tavatar, c.course_pict, c.description FROM course c INNER JOIN teacher t ON t.id = c.instructor_id INNER JOIN student_course sc ON sc.course_id = c.course_id INNER JOIN student s ON s.id = sc.student_id WHERE s.uid = '$username'";
$result2 = mysqli_query($connection,$query);

//Chose
if (isset($_POST['submit'])){
    $sid = $sname['id'];
    $cid = $_POST['submit'];

    $query = "INSERT INTO student_course (student_id, course_id) VALUES ('$sid','$cid')";
    $result = mysqli_query($connection,$query);
    mysqli_free_result($result);
    header('Location: home.php?success=update');
}

//Cancel
if (isset($_POST['submit1'])){
    $id = $_POST['submit1'];
    $query  = "DELETE FROM student_course WHERE course_id = $id";
    $result = mysqli_query($connection, $query);
    mysqli_free_result($result);
    header('Location: course_selection.php?success=2');
}
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
 	<title>StudyMonster - Student Mainpage</title>
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
<div class="bg-primary">
      <div class="container">
          <!-- Hero Section -->
          <div class="row align-items-center g-0">
              <div class="col-xl-5 col-lg-6 col-md-12">
                  <div class="py-5 py-lg-0">
                      <h1 class="text-white display-4 fw-bold">Enrolled Courses
                      </h1>
                      <p class="text-white-50 mb-4 lead">
                          Hand-picked Instructor and expertly crafted courses, designed for the modern students and entrepreneur.
                      </p>
                      <a href="dashboard.php" class="btn btn-info">Go to Dashboard</a>
                      <a href="home.php" class="btn btn-success">Go back</a>
                  </div>
              </div>
              <div class=" col-xl-7 col-lg-6 col-md-12 text-lg-end text-center">
                  <img  width="350" height="450" src="../assets/images/hero/hero-img.png" alt="" class="img-fluid" />
              </div>
          </div>
      </div>
</div>

<!-- main content -->
<div class="py-6">
  <div class="container">
    <div class="row">
      <!-- Tab content -->
      <div class="col-xl-9 col-lg-9 col-md-8 col-12">
        <div class="tab-content">
          <!-- Tab pane -->
          <div class="container">
            <div class="row">
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
              <div class="col-sm-12 mb-3">
                <input type="text" id="myFilter" class="form-control" onkeyup="myFunction()" placeholder="Seachring Course By Typing Course Name Here:">
              </div>
            </div>
            <form method="post" action="home.php">
              <div class="row" id="myItems">
              <?php
              while($row=mysqli_fetch_array($result2)){
              echo "<div class='col-lg-4 col-md-6 col-12'>
                <!-- Card -->
                <div class='card  mb-4 card-hover popup'>
                  <a href='course_details.php?id=".$row['course_id']."' class='card-img-top'><img src='../assets/img/coursepic/" .$row['course_pict'] ."' alt=''
                      class='card-img-top rounded-top-md'></a>
                  <!-- Card body -->
                  <div class='card-body'>
                    <h4 class='mb-2 text-truncate-line-2 card-title'><a href='course_details.php?id=".$row['course_id']."' class='text-inherit'>" .$row['name'] ."</a>
                    </h4>
                     <!-- List inline -->
                    <ul class='mb-3 list-inline'>
                      <li class='list-inline-item'><i class='far fa-clock me-1'></i>" .$row['duration'] ."
                      </li>";
                      $query = "SELECT COUNT(student_id) AS nums FROM student_course WHERE grade is null AND student_id = ".$sname['id']." AND course_id = ".$row['course_id'];
                       $nums = mysqli_fetch_array(mysqli_query($connection, $query));
                       mysqli_free_result(mysqli_query($connection, $query));
                       if($nums['nums']==0){
                           echo "<td><button class='btn btn-xs btn-primary' type='submit' name='submit' value='".$row['course_id']."'>Enroll</button></td>";
                           }else{
                           echo "<td><button class='btn btn-xs btn-dark' disabled=\"disabled\">CHOSEN</button></td>";
                       }
                    echo "</ul>
                  </div>
                  <!-- Card footer -->
                  <div class='card-footer'>
                     <!-- Row -->
                    <div class='row align-items-center g-0'>
                      <div class='col-auto'>
                        <img src='../assets/img/avatars/" .$row['tavatar'] ."' class='rounded-circle avatar-xs' alt=''>
                      </div>
                      <div class='col ms-2'>
                        <span>" .$row['tname'] ."</span><span>
                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
            }
              ?>
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
<script>
function myFunction() {
    var input, filter, cards, cardContainer, h5, title, i;
    input = document.getElementById("myFilter");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("myItems");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-body h4.card-title");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}
</script>

 <!--Picture pop up section starts-->
 <!-- <div id="outerdiv" style="text-align: center;position: fixed;z-index: 9999;top: 0;left: 0;
     width: 100%;height: 100%;background-color: rgba(28,28,28,0.9);">
     <img id="bigimg" style="max-height: 800px;max-width: 100%;border: 0;
         margin: auto;position: absolute;top: 0;bottom: 0;left: 0;right: 0;" src="" />
 </div> -->



 <!-- <script type="text/javascript">

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
 </script> -->

 <!-- Theme JS -->
 <script src="../assets/js/theme.min.js"></script>
 </body>
 </html>
