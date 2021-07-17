<!doctype html>
<?php include_once("database/phpmyadmin/connection.php"); ?>
<?php include_once("database/phpmyadmin/header.php"); ?>
<html lang="en">
  <head>
  <?php
  if (isset($_SESSION['email'])) {
} else {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\">";
    exit();
}

?>
<?php
        $query = "SELECT * from users WHERE email = '".$_SESSION['email'] ."'";
        $result = mysqli_query($conn, $query);

        while($rows = mysqli_fetch_assoc($result))
        {
        $id = $rows['id'];;
        $user = $rows['username'];
        }
    ?>
  	<title>IDE - GlowEdu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/css/style.css">
  </head>
  <body style="background-color: #fff;">
  <div id="content" class="p-4 p-md-5">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">

    <button type="button" id="sidebarCollapse" class="btn btn-primary">
      <i class="fa fa-bars"></i>
      <span class="sr-only">Toggle Menu</span>
    </button>
    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="nav navbar-nav ml-auto">
      <li class="nav-item active">
      <img src="images/main.png" width ="40px">
      </li>
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
    $course_int = "Welcome, $user<br> To Python IDE... <br><br><br> All The Best!<br>";
    $id = $_GET['id'];
    $query = "SELECT * from courses Where id = '$id'";
    $result = mysqli_query($conn, $query);
    while ($rows = mysqli_fetch_assoc($result)) {
      $Course_id = $rows['id'];
      $course_topic = $rows['course_topic'];
      $course_category = $rows['course_category'];
      $course_data = $rows['course_data'];
      $youtube_link = $rows['youtube_link'];
      $hints = $rows['hints'];
      $answer = $rows['answer'];
    }
?>
<?php
    $next_id = "";
    $next_sql = "SELECT * FROM courses WHERE id > $Course_id ORDER BY id DESC";
    $next_query = mysqli_query($conn, $next_sql);
    while ($row = mysqli_fetch_assoc($next_query)) {
      $next_id = $row['id'];
    }
    if ($next_id == "") {
      $final_next_id = "python_module.php";
    } else {
      $final_next_id = "python_ide.php?id=" . $next_id;
    }
    ?>
        <?php
    $pre_id = "";
    $next_sql = "SELECT id from courses where id < $Course_id ORDER BY id DESC";
    $next_query = mysqli_query($conn, $next_sql);
    while ($row = mysqli_fetch_assoc($next_query)) {
      $pre_id = $row['id'];
    }
    if ($pre_id == "") {
      $final_pre_id = "python_module.php";
    } else {
      $final_pre_id = "python_ide.php?id=" . $pre_id;
    }
?>
<?php
    $id_check = "SELECT student_id, course_id FROM match_id WHERE course_id='$id' AND student_id='$user_id'";
    $result = mysqli_query($conn, $id_check);
    $result_check = mysqli_num_rows($result);
    if (!$result_check == 0) {
      echo "<p style='font-family: Roboto; font-weight: 600; color: #fff; padding: 10px; text-align: center; background: #67ce8b; border: 1px solid #67ce8b; border-radius: 4px;'><a href='$final_pre_id' style='text-decoration: underline;'> << Go Back </a>  You have already completed the module...  <a href='$final_next_id' style='text-decoration: underline;'>Next >></a></p>";
      $sql2 = "SELECT * FROM courses WHERE id='$id'";
      $query2 = mysqli_query($conn, $sql2);
      while ($row = mysqli_fetch_assoc($query2)) {
        $code = $row['answer'];
      }
    } else {
      $code = "print('Hello, $user')";
    }
    ?>
    <?php
    $check = @$_POST['substance'];
    $code = strip_tags(@$_POST['codearea']);
    if ($check) {
      $answer_check = "SELECT answer from courses WHERE id='$id'";
      $result = mysqli_query($conn, $answer_check);
      while ($rows = mysqli_fetch_assoc($result)) {
        $course_answer = $rows['answer'];
      }
      if ($code == $course_answer) {
        mysqli_query($conn, "INSERT INTO match_id (`id`, `student_id`, `course_id`, `date`) VALUES (NULL, '$user_id', '$id', '')");
        echo "<p style='font-family: Roboto; font-weight: 600; color: #fff; padding: 10px; text-align: center; background: #67ce8b; border: 1px solid #67ce8b; border-radius: 4px;'>Correct Answer <a href='$final_next_id' style='text-decoration: underline;'>Next >></a></p>";
      } else {
        echo '<p style="font-family: Roboto; font-weight: 600; color: #fff; padding: 10px; text-align: center; background: #ff6767; border: 1px solid #ff6767; border-radius: 4px;">The Checked Answer Is Wrong Please Check The Input / Output and Answer First...</p>';
      }
    }
?>
<div class="row mt-12">
    <div class="col-md-4"><a href='<?php echo $final_pre_id?>' style='text-decoration: underline; font-size:large;'> << Back </a></div>
  <h2 class="col-md-4" id="subhead"></h2>
      <div class="col-md-4"><a href='<?php echo $final_next_id?>' style='text-decoration: underline; float: right;  font-size:large;'>Next >></a>
</div><br><br>
<div class="row mt-12">
  <h2 class="col-md-4" id="head"><?php echo $course_topic; ?></h2>
  <h2 class="col-md-4" id="subhead">Code Here!</h2>
      <div class="col-md-4"><a href="report.php" target="_blank"><button type="button" onclick="showAlert()" class="btn btn-outline-danger" style="float:right;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Report</button></a>
</div>
      <script>
        function showAlert() {
          alert("Hello! Please Take a Screen Shot For Our Reference!!..");
        }
      </script>
    </div>
    
      <script>
        function showAlert() {
          alert("Hello! Please Take a Screen Shot For Our Reference!!..");
        }
      </script>
    </div>
    <div class="row mt-3">
      <div class="col-md-4" id="collums" style="border-radius: 10px; color: #000; background: #EDF0F6"><br>
        <div id="course_data"><?php echo $course_data; ?></div><br>
        <center><h5 id="course_topic" style="background: #fff; width: 80%; color: black; border-radius: 4px;">Hint</h5></center>
        <center><div id="hint" style="background: #fff; color: black; width: 80%; border-radius: 4px; height: 70px;"><b><?php echo $hints; ?></b></div></center><br>
        <center><span><z onclick="myFunction()"></span></center><br><br>

<script>
function myFunction() {
  var x = document.getElementById("answer");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
<div id="answer" style="display: none;"><?php echo $answer; ?></div><br>
      </div>
      <div class="col">
      <iframe src="https://jupyterlite.readthedocs.io/en/latest/_static/lab/index.html" width="100%" height="750px"></iframe></div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<style>


/* reveal answer button effects */
span{
  position: relative;
  display: inline-flex;
  width: 180px;
  height: 55px;
  margin: 0 15px;
  perspective: 1000px;
}
span z{
  font-size: 19px;
  letter-spacing: 1px;
  transform-style: preserve-3d;
  transform: translateZ(-25px);
  transition: transform .25s;
  font-family: 'Montserrat', sans-serif;
  
}
span z:before,
span z:after{
  position: absolute;
  content: "Reveal Answer";
  height: 55px;
  width: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
  border-radius: 5px;
}
span z:before{
  color: #fff;
  background: #3FA1E8;
  transform: rotateY(0deg) translateZ(25px);
}
span z:after{
  color: #000;
  border: 3px solid black;
  transform: rotateX(90deg) translateZ(25px);
}
span z:hover{
  transform: translateZ(-25px) rotateX(-90deg);
}
</style>
</body>
</html>