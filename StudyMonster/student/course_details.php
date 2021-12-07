<?php

require('../database_handler.php');
require('../login_status.php');
mysqli_query($connection,'set names utf8');

$query = "SELECT name, avatar FROM student WHERE uid = '$username'";
$sname = mysqli_fetch_array(mysqli_query($connection, $query));
mysqli_free_result(mysqli_query($connection, $query));


if (isset($_GET['id'])){
    $id = $_GET['id'];

    //Course
    $query = "SELECT course.name AS cname, teacher.userEmails ,teacher.name AS tname, teacher.avatar AS tavatar, course.description, course.duration, course.course_pict, course.status FROM course INNER JOIN teacher ON course.instructor_id = teacher.id WHERE course.course_id=$id";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    mysqli_free_result(mysqli_query($connection, $query));
    $teacher = $row['tname'];
    $course_pict = $row['course_pict'];
    $course_status = $row['status'];
    $cm_name = $row['cmname'];

    // $cm_des = $row['cmdescription'];
    // $cm_type = $row['cmtype'];
    $cm_url = $row['cmurl'];

    //check students if enrolled into this courses
    // $sql = "SELECT s.name AS sname, c.name AS cname, c.course_id, sc.Enrolldate FROM student s INNER JOIN student_course sc ON s.id = sc.student_id INNER JOIN course c ON sc.course_id = c.course_id WHERE uid = '$username' AND sc.course_id = $id";
    //count it
    $sql = "SELECT COUNT(sc.Enrolldate) AS enrollnum FROM student s INNER JOIN student_course sc ON s.id = sc.student_id INNER JOIN course c ON sc.course_id = c.course_id WHERE uid = '$username' AND sc.course_id = $id";
    $result970922 = mysqli_query($connection, $sql);
    $row22 = mysqli_fetch_array($result970922);
    $enrollvalidate = $row22['enrollnum'];

    //course all file
    $sql = "SELECT course.name AS cname, teacher.name AS tname, course.description, course.duration, course.course_pict, course.status, coursematerials.coursematerials_id as cmid, coursematerials.name AS cmname, coursematerials.description AS cmdescription, coursematerials.type AS cmtype, coursematerials.url AS cmurl FROM course INNER JOIN coursematerials ON course.course_id = coursematerials.course_id INNER JOIN teacher ON course.instructor_id = teacher.id WHERE course.course_id=$id";
    $result6 = mysqli_query($connection, $sql);

  //course only video file
    $sql = "SELECT coursematerials.coursematerials_id as cmid, coursematerials.name AS cmname, coursematerials.description AS cmdescription, coursematerials.type AS cmtype, coursematerials.url AS cmurl FROM coursematerials WHERE coursematerials.course_id=$id and coursematerials.type = 'video'";
    $resultxixi = mysqli_query($connection, $sql);
     $rowgaren = mysqli_fetch_array($resultxixi);
    $cmurlhere = $rowgaren['cmurl']; 



    $sql = "select coursematerials.coursematerials_id, coursematerials.name, coursematerials.url, coursematerials.type FROM coursematerials WHERE coursematerials.type='video' AND course_id=$id";
    $result7 = mysqli_query($connection, $sql);
    $row222 = mysqli_fetch_array($result7);
    $cmurl = $row222['url'];

    //Teacher info
    $query = "SELECT name FROM teacher";
    $result = mysqli_query($connection,$query);
} else {
  header("Location: course.php?error=sqlerror");
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

<!-- main content -->
<div class="p-lg-5 py-5">
  <div class="container">
    <div class="row">

          <?php
          if($enrollvalidate>=1){
            echo "<div class='col-lg-12 col-md-12 col-12 mb-5'>";
            echo "<div class='rounded-3 position-relative w-100 d-block overflow-hidden p-0' style='height: 600px;'>";
            echo "<iframe class='position-absolute top-0 end-0 start-0 end-0 bottom-0 h-100 w-100' src='../assets/upload/" .$cmurlhere."'></iframe>";
            echo "</div></div>";
          }
          ?>

    </div>
    <!-- Content -->
    <div class="row">
      <div>
        <!-- Card -->
        <div class="card mb-5">
          <!-- Card body -->
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="fw-semi-bold mb-2">
                <?php echo $row['cname'];?>
              </h1>
            </div>
            <div class="d-flex mb-5">
              <span class="ms-4 d-none d-md-block">
                <i class="mdi mdi-account-multiple-outline"></i>
                <span><?php
                if($enrollvalidate>=1){
                  echo "Enrolled";
                } else {
                  echo "Not yet Enrolled";
                }
                 ?></span>
              </span>
            </div>
            <div class="d-flex justify-content-between">
              <div class="d-flex align-items-center">
                <img src="../assets/img/avatars/<?php echo $row['tavatar'];?>" class="rounded-circle avatar-md" alt="" />
                <div class="ms-2 lh-1">
                  <h4 class="mb-1"><?php echo $row['tname'];?></h4>
                  <p class="fs-6 mb-0"><?php echo $row['userEmails'];?></p>
                </div>
              </div>
            </div>
          </div>
          <!-- Nav tabs -->
          <?php 
          if($enrollvalidate>=1) {
          echo "<ul class='nav nav-lt-tab' id='tab' role='tablist'>
             <!-- Nav item -->
            <li class='nav-item'>
              <a class='nav-link active' id='description-tab' data-bs-toggle='pill' href='#description' role='tab'
                aria-controls='description' aria-selected='false'>Description</a>
            </li>
            <!-- Nav item -->
            <li class='nav-item'>
              <a class='nav-link' id='review-tab' data-bs-toggle='pill' href='#review' role='tab' aria-controls='review'
                aria-selected='false'>Files</a>
            </li>
          </ul>";
          } else {
                     echo "<ul class='nav nav-lt-tab' id='tab' role='tablist'>
             <!-- Nav item -->
            <li class='nav-item'>
              <a class='nav-link active' id='description-tab' data-bs-toggle='pill' href='#description' role='tab'
                aria-controls='description' aria-selected='false'>Description</a>
            </li>
          </ul>" ;
          }
        ?>
        </div>
        <!-- Card -->
        <div class="card rounded-3">
          <!-- Card body -->
          <div class="card-body">
            <div class="tab-content" id="tabContent">
              <!-- Tab pane -->
              <div class="tab-pane fade show active" id="description" role="tabpanel"
                aria-labelledby="description-tab">
                <div class="mb-4">
                  <h3 class="mb-2">Course Descriptions</h3>
                  <p>
                    <?php echo $row['description'];?>
                  </p>
                </div>
                <h4 class="mb-3">What you’ll learn</h4>
                <div class="row mb-3">
                  <div class="col-12 col-md-6">
                    <!-- List group -->
                    <ul class="list-unstyled">
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Recognize the importance of understanding your objectives when addressing an audience.
                        </span>
                      </li>
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Identify the fundaments of composing a successful close.
                        </span>
                      </li>
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Explore how to connect with your audience through crafting compelling stories.
                        </span>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-md-6">
                    <!-- List group -->
                    <ul class="list-unstyled">
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Examine ways to connect with your audience by personalizing your content.
                        </span>
                      </li>
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Break down the best ways to exude executive presence.
                        </span>
                      </li>
                      <li class="d-flex align-item-center mb-2">
                        <i class="far fa-check-circle text-success me-2 lh-lg"></i>
                        <span>
                          Explore how to communicate the unknown in an impromptu communication.
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
                <p>Maecenas viverra condimentum nulla molestie condimentum. Nunc ex libero, feugiat quis lectus vel,
                  ornare euismod ligula. Aenean sit amet arcu nulla.</p>
                <p>
                  Duis facilisis ex a urna blandit ultricies. Nullam sagittis ligula non eros semper, nec mattis odio
                  ullamcorper. Phasellus feugiat sit amet leo eget consectetur.
                </p>
              </div>
              <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="mb-3">
                  <!-- Content -->
                  <h3 class="mb-4">Course Files</h3>
                </div>
                <hr class="my-5" />
                                         <table id="example" class="table table-striped" style="width:100%">
                          
                          <thead>
                              <tr>
                                  <th class="per5">#</th>
                                  <th class="per5">FileID</th>
                                  <th class="per10">Name</th>
                                  <th class="per20">Description</th>
                                  <th class="per10">Type</th>
                                  <th class="per5">Download</th>
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
      <div class="col-xl-4 col-lg-12 col-md-12 col-12">

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
                        zeroRecords: '<b>Sorry, no items for here to display</b>',    
                        lengthMenu: '<b>_MENU_</b>',                                                
                        info: '<b>&raquo; _START_ to _END_ of _TOTAL_</b>',                         
                        search: '',                                                                     
                        searchPlaceholder: 'Enter keyword',
                        infoFiltered: '<b>(filtered from _MAX_ total Items)</b>'
                    },
                    destroy: true,
                });
            } );
  

</script> 
<script src="../assets/js/theme.min.js"></script>
</body>
</html>
