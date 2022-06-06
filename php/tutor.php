<?php
include("dbconnect.php");
session_start();
if (!isset($_SESSION['user_name'])) {
  echo "<script>window.location.replace('index.php')</script>";
}
$limit = 10;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;
$sqlTutor = "SELECT * FROM tbl_tutors LIMIT $paginationStart, $limit";
$stmt = $conn->prepare($sqlTutor);
$stmt->execute();
$result = $stmt->get_result();

// Get total records
$sql = $conn->query("SELECT count(tutor_id) AS id FROM tbl_tutors")->fetch_assoc();
$allRecrods = $sql['id'];

// Calculate total pages
$totoalPages = ceil($allRecrods / $limit);
// Prev + Next
$prev = $page - 1;
$next = $page + 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>My Tutor</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/home.css">
</head>

<body>
  <!--Main Navigation-->
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <br>
          <a href="course.php" class="list-group-item list-group-item-action py-2" aria-current="true">
            <span>Courses</span>
          </a>
          <a href="tutor.php" class="list-group-item list-group-item-action py-2 active"><span>Tutor</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action py-2"><span>Subscription</span></a>
          <a href="#" class="list-group-item list-group-item-action py-2"><span>Profile</span></a>

          </div>
        <br>
        <div >
          <div class="list-group mx-3 mt-4 align-bottom">
            <a href="#" class="list-group-item list-group-item-action py-2 text-white text-center" style="background-color:red"><span>Logout</span></a>
  
          </div>
        </div>

      </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top card">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler btn-primary" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <!-- Brand -->
        <a class="navbar-brand" style="height: 58px" href="#">
          <div style="margin-top: -10px"> <b style="color:blue">My</b><span class="tutor-text">Tutor</span></div>
        </a>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main style="margin-top: 75px">
    <div class="container pt-4">
      <h2>Tutors</h2>
      <?php 
      while ($row = $result->fetch_assoc()) {
      ?>
      
        <div class="card mb-3">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="../assets/tutors/<?php echo $row['tutor_id']; ?>.jpg" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['tutor_name']; ?></h5>
                <p class="card-text"><?php echo $row['tutor_description']; ?></p>
                <p class="card-text text-muted">Email : <?php echo $row['tutor_email']; ?></p>
                <p class="card-text text-muted">Phone : <?php echo $row['tutor_phone']; ?></p>
                <br>
                
                <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                <p class="card-text"><small class="text">Last updated 3 mins ago</small></p> -->
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
      <!-- Pagination -->
      <nav aria-label="Page navigation example mt-5">
        <ul class="pagination justify-content-center">
          <li class="page-item <?php if ($page <= 1) {
                                  echo 'disabled';
                                } ?>">
            <a class="page-link" href="<?php if ($page <= 1) {
                                          echo '#';
                                        } else {
                                          echo "?page=" . $prev;
                                        } ?>">Previous</a>
          </li>
          <?php for ($i = 1; $i <= $totoalPages; $i++) : ?>
            <li class="page-item <?php if ($page == $i) {
                                    echo 'active';
                                  } ?>">
              <a class="page-link" href="tutor.php?page=<?= $i; ?>"> <?= $i; ?> </a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?php if ($page >= $totoalPages) {
                                  echo 'disabled';
                                } ?>">
            <a class="page-link" href="<?php if ($page >= $totoalPages) {
                                          echo '#';
                                        } else {
                                          echo "?page=" . $next;
                                        } ?>">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </main>
  <!--Main layout-->
  <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Free_4.1.0/js/mdb.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#records-limit').change(function() {
        $('form').submit();
      })
    });
  </script>
</body>

</html>