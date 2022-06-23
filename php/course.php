<?php
include("dbconnect.php");
session_start();
if (!isset($_SESSION['user_name'])) {
  echo "<script>window.location.replace('index.php')</script>";
}
// if (isset($_GET['search_query'])) {
//   $search_query = $_GET['search_query'];
//   if ($search_query == '') {
//     echo "<script>console.log($search_query);</script>";
//     $sqlSubject = "SELECT * FROM tbl_subjects LIMIT $paginationStart, $limit";
//     $sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects")->fetch_assoc();
//   } else {
//     $sqlSubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search_query%' LIMIT $paginationStart, $limit";
//     $sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects WHERE subject_name LIKE '%$search_query%'")->fetch_assoc();
//   }
// }


// if (!isset($_GET['search_query']) || ($_GET['search_query'] == '')){

//   $sqlSubject = "SELECT * FROM tbl_subjects $fromQuery LIMIT $paginationStart, $limit";
//   $sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects")->fetch_assoc();
// }else if ($_GET['search_query'] != ''){
//     $search_query = $_GET['search_query'];
//   $sqlSubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search_query%' LIMIT $paginationStart, $limit";
//   $sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects WHERE subject_name LIKE '%$search_query%'")->fetch_assoc();
// }
$limit = 10;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;

$searchQuery = "";
$fromQuery = "";
$orderQuery = "";


if (isset($_GET['order'])) {
  if ($_GET['order'] != '') {
    $orderGet = $_GET['order'];
    $orderQuery = "ORDER BY $orderGet";
    if (isset($_GET['from'])) {
      if ($_GET['from'] != '') {
        $fromQuery = $_GET['from'];
      }
    }
  }
}

if (isset($_GET['search_query'])) {
  if ($_GET['search_query'] != '') {
    $searchGet = $_GET['search_query'];
    $searchQuery = "WHERE subject_name LIKE '%$searchGet%'";
  }
}

$sqlSubject = "SELECT * FROM tbl_subjects $searchQuery $orderQuery $fromQuery LIMIT $paginationStart, $limit";
$stmt = $conn->prepare($sqlSubject);
$stmt->execute();
$result = $stmt->get_result();

$sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects $searchQuery")->fetch_assoc();
$allRecrods = $sql['id'];
$totalrows = $result->num_rows;
$totalPage = ceil($allRecrods / $limit);

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
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/home.css">
  <style>
    .embed-responsive .card-img-top {
      object-fit: cover;
    }
  </style>
</head>

<body>
  <div class="modal fade" id="modalCenter" tabindex="-10" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLongTitle">Logout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">Are You sure you want to log out?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-primary" data-dismiss="modal" aria-label="Close">Stay</button>
          <a href="logout.php"><button type="button" class=" btn-danger">Logout</button></a>
        </div>
      </div>
    </div>
  </div>
  <!--Main Navigation-->
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky" style="height:100%">
        <div class="list-group list-group-flush mx-3 mt-4">
          <br>
          <a href="course.php" class="list-group-item list-group-item-action py-2 active" aria-current="true">
            <span>Courses</span>
          </a>
          <a href="tutor.php" class="list-group-item list-group-item-action py-2"><span>Tutor</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action py-2"><span>Subscription</span></a>
          <a href="#" class="list-group-item list-group-item-action py-2"><span>Profile</span></a>

          <!-- <a href="#" class="list-group-item list-group-item-action py-2 align-bottom"><button class=" button-danger">Profile</button></a> -->

        </div>
        <br>
        <div>
          <div class="list-group mx-3 mt-4 align-bottom">
            <button class="list-group-item list-group-item-action py-2 text-white text-center" data-toggle="modal" data-target="#modalCenter" style="background-color:red">Logout</button>

          </div>

        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top card">
      <div class="container-fluid">
        <button class="navbar-toggler btn-primary" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" style="height: 58px" href="#">
          <div style="margin-top: -10px"> <b style="color:blue">My</b><span class="tutor-text">Tutor</span></div>
        </a>
      </div>
    </nav>
  </header>

  <!--Main layout-->
  <main style="margin-top: 75px">

    <div class="container pt-4">
      <div style="display:flex; flex-wrap:wrap;">
        <h1>Courses</h1>
        <button class="btn btn-primary" style="height: 38px; width:50px; align-self:center; margin-left:20px;" type="button" data-bs-toggle="collapse" data-bs-target="#searchDiv" aria-expanded="false" aria-controls="collapseExample">
          <i class="fa fa-search" style="color: white;" aria-hidden="true"></i>
        </button>
      </div>

      <div class="mx-4 collapse" style="max-width: 500px;" id="searchDiv">
        <form class="form w-auto my-auto" action="course.php" Method="GET">
          <input class="form-control mr-sm-2" type="search" placeholder="Search by Course Name" name="search_query">

          <div class=" d-md-flex w-auto my-2">
            <select class="form-select" name="order">
              <option selected value="">Order by</option>
              <option value="subject_name">Name</option>
              <option value="subject_rating">Rating</option>
              <option value="subject_price">Price</option>
              <option value="subject_sessions">Session</option>
            </select>

            <input type="radio" class="btn-check" name="from" id="option1" autocomplete="off" value="asc" checked>
            <label class="form-control btn-outline-primary btn" style="height: 38px; margin:2px; max-width:110px;" for="option1">Ascending</label>

            <input type="radio" class="btn-check" name="from" id="option2" autocomplete="off" value="desc">
            <label class="form-control btn-outline-primary btn" style="height: 38px; margin:2px; max-width:110px;" for="option2">Descending</label>
          </div>

          <button class="btn form-control btn-primary my-sm-0 my-2" style="height: 38px; " type="submit">Search</button>
        </form>
        <br>
      </div>

      <?php
      $orderMessage = "";
      if ($orderQuery != "") {
        $split = explode("_", $orderQuery);
        $orderMessage = " Ordered from '" . $split[count($split) - 1] . "' in " . $fromQuery . "ending manner. ";
      }
      if (isset($_GET['search_query'])) {
        $search_query = $_GET['search_query'];
        if ($search_query == '') {
          echo "<b>Showing all courses, " . $allRecrods . " Records Found.$orderMessage</b>";
        } else {
          echo "<b>Showing all result for '" . $search_query . "' in courses, " . $allRecrods . " Records Found.$orderMessage</b>";
        }
      } else {
        echo "<b>Showing all courses, " . $allRecrods . " Records Found.$orderMessage</b>";
      }
      ?>
      <br>
      <br>
      <div class="container">
        <div class="row gy-2">
          <?php
          while ($row = $result->fetch_assoc()) {
            $currCourseId = $row['subject_id'];
            $sqlTutorCourses = "SELECT * FROM tbl_tutors AS tt , tbl_subjects AS ts WHERE tt.tutor_id = ts.tutor_id AND ts.subject_id = $currCourseId";
            $stmt2 = $conn->prepare($sqlTutorCourses);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $tutorName = "";
          ?>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card h-100">
                <div class="align-self-center justify-content-center embed-responsive embed-responsive-4by3">
                  <img class="card-img-top embed-responsive-item" src="../assets/courses/<?php echo $row['subject_id']; ?>.png" class="card-img" alt="...">
                </div>
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo $row['subject_name']; ?>
                  </h5>
                  <p class="card-text">
                    <?php
                    $out = strlen($row['subject_description']) > 50 ? substr($row['subject_description'], 0, 50) . "..." : $row['subject_description'];
                    echo $out;
                    ?>
                  </p>
                  <div style="display:flex; width:100%;  flex-wrap: wrap;">
                    <?php
                    if ($result2->num_rows > 0) {
                      while ($row2 = $result2->fetch_assoc()) {

                    ?>
                        <div class="text-muted" style="margin-right:30px;"><b>Tutor :</b>
                          <?php $tutorName = $row2['tutor_name'];
                          echo $row2['tutor_name']; ?>
                        </div>

                    <?php
                      }
                    } else {
                      echo "<b>NO TUTOR AVAILABILE</b>";
                    }
                    ?>
                    <p class="text-muted"><b>Subject Sessions :</b>
                      <?php echo $row['subject_sessions']; ?>
                    </p>
                  </div>
                  <div style="display:flex; width:100%; flex-wrap: wrap;">

                    <b class="card-text text-warning" style="font-size: 20px;margin-right:30px;"><span class="fa fa-star checked"></span>
                      <?php echo $row['subject_rating']; ?>
                    </b>
                    <br>
                    <p class="card-text text-success" style="font-size: 20px;">RM
                      <?php echo $row['subject_price']; ?>
                    </p>
                  </div>
                  <a href="" class="stretched-link" data-bs-toggle="modal" data-bs-target="#DetailModal<?= $row['subject_id']; ?>"></a>
                </div>
              </div>
            </div>
            <div class="modal fade" id="DetailModal<?= $row['subject_id']; ?>" tabindex="-10" aria-labelledby="DetailCourseLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="DetailCourseLabel">Course Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h3><?php echo $row['subject_name']; ?></h3>
                    <p><?php echo $row['subject_description']; ?></p>


                    <div class="my-1" style="display:flex; width:100%; flex-wrap: wrap;">
                      <div style="font-size: 20px;margin-right:30px;">
                        <b>Tutor : </b>
                        <span><?php echo $tutorName ?></span>
                      </div>
                      <br>
                      <div style="font-size: 20px;">
                        <b>Session : </b>
                        <span><?php echo $row['subject_sessions']; ?></span>
                      </div>
                    </div>

                    <div class="my-1" style="display:flex; width:100%; flex-wrap: wrap;">
                      <div style="font-size: 20px; margin-right:30px;">
                        <b>Rating : </b>
                        <span class="text-warning"> <span class="fa fa-star checked"></span>
                          <?php echo $row['subject_rating']; ?>
                        </span>
                      </div>
                      <br>
                      <div style="font-size: 20px;">
                        <b>Price : </b>
                        <span class="text-success"> RM
                          <?php echo $row['subject_price']; ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" style="height: 38px; width: 100px;" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>
        </div>
      </div>
      <!-- Pagination -->
      <?php
      if ($totalrows > 0) {
      ?>
        <nav aria-label="Page navigation mt-5">
          <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page <= 1) {
                                    echo 'disabled';
                                  } ?>">
              <a class="page-link" href="<?php if ($page <= 1) {
                                            echo '#';
                                          } else {
                                            echo " ?page=" . $prev;
                                          } ?>
                                        <?php if (isset($_GET['search_query'])) {
                                          echo '&search_query=' . $_GET['search_query'];
                                        } ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item <?php if ($page == $i) {
                                      echo 'active';
                                    } ?>
                                  ">
                <a class="page-link" href="course.php?page=<?= $i; ?><?php if (isset($_GET['search_query'])) {
                                                                        echo '&search_query=' . $_GET['search_query'];
                                                                      } ?>">
                  <?= $i; ?>
                </a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page >= $totalPage) {
                                    echo 'disabled';
                                  } ?>">
              <a class="page-link" href="<?php if ($page >= $totalPage) {
                                            echo '#';
                                          } else {
                                            echo " ?page=" . $next;
                                          } ?>
                                        <?php if (isset($_GET['search_query'])) {
                                          echo '&search_query=' . $_GET['search_query'];
                                        } ?>">Next</a>
            </li>
          </ul>
        </nav>
      <?php
      }
      ?>

      <?php
      //  if(isset($_GET['search_query'])){echo "&search_query="+$_GET['search_query'];}
      ?>

    </div>
  </main>
  <!--Main layout-->

  <br><br><br>
  <footer class="bg-dark fixed-bottom text-center text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      <p class="text-light" style="display: inline-block;">&copy; 2022 Copyright:</p>
      <a class="text-light" href="#contact">Juanrico Alvaro</a>
    </div>
  </footer>
  <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB5-Free_4.1.0/js/mdb.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



</body>

</html>