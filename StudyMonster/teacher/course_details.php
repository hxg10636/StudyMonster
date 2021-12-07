<?php

require('../database_handler.php');
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM teacher WHERE uid = '$username'";
$tname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));

if (isset($_GET['id'])){
    $id = $_GET['id'];

    //Course
    $query = "SELECT course.name AS cname, teacher.name AS tname, course.description, course.duration, course.course_pict, course.status FROM course INNER JOIN teacher ON course.instructor_id = teacher.id WHERE course.course_id=$id";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    mysqli_free_result(mysqli_query($connection, $query));
    $teacher = $row['tname'];
    $course_pict = $row['course_pict'];
    $course_status = $row['status'];
    $cm_name = $row['cmname'];
    // $cm_des = $row['cmdescription'];
    // $cm_type = $row['cmtype'];
    // $cm_url = $row['cmurl'];


    //course file
    $sql = "SELECT course.name AS cname, teacher.name AS tname, course.description, course.duration, course.course_pict, course.status, coursematerials.coursematerials_id as cmid, coursematerials.name AS cmname, coursematerials.description AS cmdescription, coursematerials.type AS cmtype, coursematerials.url AS cmurl FROM course INNER JOIN coursematerials ON course.course_id = coursematerials.course_id INNER JOIN teacher ON course.instructor_id = teacher.id WHERE course.course_id=$id";
    $result6 = mysqli_query($connection, $sql);

    //count numbers of video files in the db"
    $sql = "select COUNT(coursematerials.coursematerials_id) AS num FROM coursematerials WHERE coursematerials.type='video' AND course_id=$id";
    $result7 = mysqli_query($connection, $sql);

    //Teacher info
    $query = "SELECT name FROM teacher";
    $result = mysqli_query($connection,$query);
} else {
  header("Location: course.php?error=sqlerror");
}

//course file Delete
if (isset($_POST['submit10086'])) {
    $id = $_POST['id'];
    $fid = $_POST['cmid'];
    // delete the file in the system first
    $sql2 = "SELECT coursematerials.coursematerials_id as cmid, coursematerials.name AS cmname, coursematerials.description AS cmdescription, coursematerials.type AS cmtype, coursematerials.url AS cmurl FROM coursematerials WHERE coursematerials.coursematerials_id=$fid";
    $result200 = mysqli_query($connection, $sql2);
    $row=mysqli_fetch_array($result200);
    $deletefile = "../assets/upload/" .$row['cmurl']."";
    unlink($deletefile);
    // Prepare query
    $query  = "DELETE FROM coursematerials WHERE coursematerials_id = $fid";
    // Do the query on the database
    $result100 = mysqli_query($connection, $query);
    if (!$result100) {
        header("Location: course_details.php?id=". $id ."&success=1");
    }else{
        header("Location: course_details.php?id=". $id ."&success=update");
    }
    mysqli_free_result($result100);
    mysqli_free_result($result200);
}

//Update course
// if (isset($_POST['submit'])){
//     $id = $_POST['id'];
//     $cname = $_POST['cname'];
//     $description = $_POST['description'];
//     $duration = $_POST['duration'];
//     // $status = $_POST['status'];
//     $sql = "UPDATE course SET name = '$cname', description = '$description', duration = '$duration' WHERE course_id = $id";
//     $result1 = mysqli_query($connection, $sql);
//     header('Location: course_details.php?id='.$id.'&success=update');
//     mysqli_free_result($result1);
// }

//upload course picture
if(isset($_POST['submit'])){
  $id = $_POST['id'];
  $cname = $_POST['cname'];
  $description = $_POST['description'];
  $duration = $_POST['duration'];
  $cfile = $_FILES['cfile']['name'];
  $query = "UPDATE course SET name = '$cname', description = '$description', duration = '$duration' WHERE course_id = '$id'";
  $result2 = mysqli_query($connection,$query);
  mysqli_free_result($result2);
  header('Location: course_details.php?id='.$id.'&success=update');
    if ($_FILES['cfile']['error']){
    switch ($_FILES['cfile']['error']){
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
    if ($_FILES['cfile']['size'] > (pow(1024,2)*2)){ //(pow(1024,2)*2) == 2M
        die('The size of the file exceeds the permitted size');
    }
    //Determine the permitted MIME type, file extension
    $allowMime = ['image/png','image/jpeg','image/gif','image/jpg'];
    $allowFix = ['png','jpeg','gif','jpg'];

    $info = pathinfo($_FILES['cfile']['name']);
    $subFix = $info['extension'];
    if(!in_array($subFix,$allowFix)){
        header('Location: course_details.php?id='.$id.'&unsuccess=errorfilexten');
    }
    if(!in_array($_FILES['cfile']['type'],$allowMime)){
        header('Location: course_details.php?id='.$id.'&unsuccess=errorfiletype');
    }

    //Stitching the path to upload
    $path = "../assets/img/coursepic/";
    if (!file_exists($path)){
        mkdir($path);
    }
    //File name random
    $name = uniqid().'.'.$subFix;
    //Determine if the file is uploaded
    if (is_uploaded_file($_FILES['cfile']['tmp_name'])){
        if(move_uploaded_file($_FILES['cfile']['tmp_name'] , $path.$name)){
            $query = "UPDATE course SET course_pict = '$name', name = '$cname', description = '$description', duration = '$duration' WHERE course_id = '$id'";
            $result666 = mysqli_query($connection,$query);
            mysqli_free_result($result666);
            header('Location: course_details.php?id='.$id.'&success=update');
        }else{
          header('Location: course_details.php?id='.$id.'&success=1');
        }
    }else{
        header('Location: course_details.php?id='.$id.'&success=1');
    }
}

//upload course files
if(isset($_POST['submit2'])){
  $id = $_POST['id'];
  $filename = $_POST['filename'];
  $fildes = $_POST['filedes'];
  $filetype = $_POST['filetype'];
  $cfile = $_FILES['cfile1']['name'];

  $destination = "../assets/upload/";
  $extension = pathinfo($cfile, PATHINFO_EXTENSION);
  $getfileinfo2 = pathinfo($cfile);
  $file_extension = $getfileinfo2['extension'];
  $uploadedfilename = uniqid().'.'. $file_extension;
  $file = $_FILES['cfile1']['tmp_name'];
  $size = $_FILES['cfile1']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx','mp4','wav','jpg','png','txt'])) {
        header('Location: course_details.php?id='.$id.'&success=1');
    } elseif ($_FILES['myfile']['size'] > 100000000) { // file shouldn't be larger than 100Megabyte
        header('Location: course_details.php?id='.$id.'&success=1');
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination.$uploadedfilename)) {
            $row = mysqli_fetch_array($result7);
            // only allow one video file exists in the db
            if($row['num']==0 && $filetype=='video'){
            $sql = "INSERT INTO coursematerials (course_id, name, description,type,url) VALUES ('$id','$filename','$fildes','$filetype','$uploadedfilename')";
            mysqli_query($connection, $sql);
            header('Location: course_details.php?id='.$id.'&success=coursefile');
        } elseif ($row['num']==0 && $filetype=='resource') {
            $sql = "INSERT INTO coursematerials (course_id, name, description,type,url) VALUES ('$id','$filename','$fildes','$filetype','$uploadedfilename')";
            mysqli_query($connection, $sql);
            header('Location: course_details.php?id='.$id.'&success=coursefile');
        }elseif ($row['num']==1 && $filetype=='resource') {
            $sql = "INSERT INTO coursematerials (course_id, name, description,type,url) VALUES ('$id','$filename','$fildes','$filetype','$uploadedfilename')";
            mysqli_query($connection, $sql);
            header('Location: course_details.php?id='.$id.'&success=coursefile');
        }elseif ($row['num']==1 && $filetype=='video') {
            header('Location: course_details.php?id='.$id.'&success=1');
        }
    } else {
        header('Location: course_details.php?id='.$id.'&success=1');
    }
}
mysqli_free_result($result7);
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
.custom-file-upload {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
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
<!-- Page header-->
<div class="py-4 py-lg-6 bg-primary">
  <div class="container">
    <div class="row">
      <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
        <div class="d-lg-flex align-items-center justify-content-between">
          <!-- Content -->
          <div class="mb-4 mb-lg-0">

            <h1 class="text-white mb-1">Edit Course: <strong><?php echo $row['cname'];?></strong>
                        <?php
                               if($course_status==1){
                                echo "<td><button class='btn btn-xs btn-success' disabled>Passed</button></td>";
                                    }else{
                                    echo "<td><button class='btn btn-xs btn-warning' disabled>Unreviewed</button></td>";
                                  }
                          ?>
                    </h1>
            <p class="mb-0 text-white lead">
              You are able to edit the course information.
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
<div class="pb-12">
  <div class="container">
    <div id="courseForm" class="bs-stepper">
      <div class="row">
        <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
          <!-- Stepper Button -->
          <div class="bs-stepper-header shadow-sm" role="tablist">
            <div class="step" data-target="#test-l-1">
              <button type="button" class="step-trigger" role="tab" id="courseFormtrigger1" aria-controls="test-l-1">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Basic Information</span>
              </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-l-4">
              <button type="button" class="step-trigger" role="tab" id="courseFormtrigger4" aria-controls="test-l-4">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Course Media</span>
              </button>
            </div>
          </div>
          <!-- Stepper content -->
          <div class="bs-stepper-content mt-5">
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
              <!-- Content one -->
              <div id="test-l-1" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="courseFormtrigger1">
                <!-- Card -->
                <div class="card mb-3 ">
                  <div class="card-header border-bottom px-4 py-3">
                    <h4 class="mb-0">Basic Information</h4>
                  </div>
                  <!-- Card body -->
                  <form action="course_details.php" method="post" enctype="multipart/form-data" role="form" id="validate">
                  <input type="hidden" name="id" value="<?php echo $id;?>">
                  <div class="card-body">
                    <div class="mb-3">
                      <div class="custom-file-container" data-upload-id="courseCoverImg" id="courseCoverImg">
                        <label class="form-label">Course cover image
                          <a href="javascript:void(0)" class="custom-file-container__image-clear"
                            title="Clear Image"></a></label>
                      <label class="custom-file-container__custom-file">
                      <input type="file" class="custom-file-container__custom-file__custom-file-input"
                        accept="image/*" name="cfile"/>
                      <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                      <small class="mt-3 d-block">Upload your course image here. It must meet
                        our
                        course image quality standards to be accepted.
                        Important guidelines: 750x440 pixels; .jpg, .jpeg,.
                        gif, or .png. no text on the image.</small>
                    <div class='custom-file-container__image-preview'></div></div>
                    </div>
                    <div class="mb-3">
                      <label for="courseTitle" class="form-label">Course Title</label>
                      <input id="courseTitle" class="form-control" type="text" value="<?php echo $row['cname'];?>" name="cname" required/>
                      <small>Write a 60 character course title.</small>
                    </div>
                    <div class="mb-3">
                      <label for="courseDur" class="form-label">Courses Duration</label>
                      <input id="courseDur" class="form-control" type="text" value="<?php echo $row['duration'];?>" name="duration" required />
                    </div>
                    <div class="mb-3">
                      <label for="courseIns" class="form-label">Courses Instructor</label>
                      <input type="text" class="form-control" value="<?php echo $row['tname'];?>" disabled>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Course Description</label>
                      <input id="editor" class="form-control" type="text" value="<?php echo $row['description'];?>" name="description" required/>
                      <small>A brief summary of your courses.</small>
                    </div>
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success mt-5">
                  Update
                </button>
              </form>
              </div>
              <!-- Content two -->
              <div id="test-l-4" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="courseFormtrigger4">
                <!-- Card -->
                <!-- file upload area -->
                <div class="card mb-3  border-0">
                  <div class="card-header border-bottom px-4 py-3">
                    <h4 class="mb-0">Course Media</h4>
                  </div>
                  <!-- Card body -->
                  <div class="card-body">
                        <!-- Start .panel -->
                        <div class="panel-heading white-bg">
                            <h4 class="panel-title">Upload Course Files</h4>
                        </div>
                        <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" >
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <div class="form-group">
                                <label for="file-upload" class="custom-file-upload">
                                  <i class="fa fa-cloud-upload"></i> Upload File
                                </label>
                                <input id="file-upload" name='cfile1' type="file" style="display:none;">
                              </div><hr/>
                                <div class="form-group">
                                         <label class="control-label">File Name</label>
                                         <input type="text" class="form-control" name="filename" required/>
                                     </div>
                                     <div class="form-group">
                                       <label class="control-label">File Description</label>
                                       <input type="text" class="form-control" name="filedes" required/>
                                          </div>
                                 <div class="mb-3">
                                   <label class="form-label">Files level</label>
                                   <select class="selectpicker" name="filetype" data-width="100%">
                                     <option value="resource" selected>Resource</option>
                                     <option value="video">Video</option>
                                   </select>
                                 </div>
                                  <button class="custom-file-upload" type="submit" name="submit2">Upload</button>
                        </form>
                        </div>
                  </div>
                </div>
                <!-- file management area -->
                <div class="card mb-3  border-0">
                  <div class="card-header border-bottom px-4 py-3">
                    <h4 class="mb-0">Course Files</h4>
                  </div>
                  <!-- Card body -->
                  <div class="card-body">
                    <div class="panel panel-default plain toggle panelClose">
                       <!-- Start .panel -->
                       <div class="panel-body">
                <table id="example" class="table table-striped" style="width:100%">

                 <thead>
                     <tr>
                         <th class="per5">#</th>
                         <th class="per5">FileID</th>
                         <th class="per10">Name</th>
                         <th class="per20">Description</th>
                         <th class="per10">Type</th>
                         <th class="per5">Download</th>
                         <th class="per5">Delete</th>
                     </tr>
                 </thead>
                 <tbody>

                   <?php
                     $i=1;
                     while ($row=mysqli_fetch_array($result6)){
                         echo "<tr>";
                         echo "<td>".$i."</td>";
                         echo "<td>".$row['cmid']."</td>";
                         echo "<td>".$row['cmname']."</td>";
                         echo "<td>".$row['cmdescription']."</td>";
                         echo "<td>".$row['cmtype']."</td>";
                         if($row['cmtype'] =='resource'){
                         echo "<td><a download href='../assets/upload/".$row['cmurl'] ."'><button class='btn btn-xs btn-success'>Download</button></a>";
                         } else{
                         echo "<td><a href='../assets/upload/".$row['cmurl'] ."'><button class='btn btn-xs btn-success'>Play</button></a>";
                         }
                         echo "<td>";
                         echo "<form action='' method='post'>";
                         echo "<input type='hidden' name='cmid' value='" .$row['cmid']."'>";
                         echo "<input type='hidden' name='id' value='" .$id."'>";
                         echo "<button class='btn btn-xs btn-danger' type='submit' name='submit10086'>Delete</button></form></td>";
                         echo "</tr>";
                         $i++;
                     }
                     mysqli_free_result($result6);
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
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog"
  aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="taskModalLabel">Create New Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close">

              </button>
          </div>
          <div class="modal-body">
              <form class="row">
                  <div class="mb-2 col-12">
                      <label for="taskTitle" class="form-label">Title</label>
                      <input type="text" class="form-control" id="taskTitle"
                          placeholder="Title" required>
                  </div>
                  <div class="col-6">
                      <label for="priority" class="form-label">Priority</label>
                      <select class="selectpicker" data-width="100%" id="priority">
                          <option selected>Low</option>
                          <option value="Medium">Medium</option>
                          <option value="High">High</option>

                      </select>
                  </div>
                  <div class="mb-2 col-6">
                      <label for="date" class="form-label">Due Date</label>
                      <input class="form-control flatpickr" type="text"
                          placeholder="Select Date" id="date" required>
                  </div>
                  <div class="mb-2 col-12">
                      <label for="descriptions" class="form-label">Descriptions</label>
                      <textarea class="form-control" id="descriptions"
                          rows="3" required></textarea>
                  </div>
                  <div class="col-12 mb-3">
                      <label for="assignTo" class="form-label">Assign To</label>
                      <select class="selectpicker" id="assignTo" data-width="100%">
                          <option selected>Codescandy</option>
                          <option value="John Deo">John Deo</option>
                          <option value="Misty">Misty</option>
                          <option value="Simon Ray">Simon Ray</option>

                      </select>
                  </div>



                  <div class="col-12 d-flex justify-content-end">
                      <button type="button" class="btn btn-outline-secondary
                          me-2" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Create
                          Task</button>
                  </div>
              </form>
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
<script>
$('#file-upload').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload')[0].files[0].name;
  $(this).prev('label').text(file);
});

</script>
 <!-- Theme JS -->
 <script src="../assets/js/theme.min.js"></script>
 </body>
 </html>
