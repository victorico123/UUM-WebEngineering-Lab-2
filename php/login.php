<?php

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    include_once("dbconnect.php");
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error;
    if (empty($password) || empty($email)) {
        $error = "Please enter all the field.";
        echo "<script>window.location.replace('index.php?success=2&msgLogin=$error&form=login')</script>";
    } else {
        $sqlLogin = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sqlLogin);
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $value = false;
            $user_name = "";
            while ($row = $result->fetch_assoc()) {
                $user_name = $row['name'];
                $value = true;
            }
            if ($value) {
                if (isset($_POST['rem'])) {
                    $remembering_timespan = time() + 7 * 24 * 60 * 60;
                    setcookie('email', $email, $remembering_timespan);
                    setcookie('password', $password, $remembering_timespan);
                    setcookie('remember_me', "checked", $remembering_timespan);
                    echo "remember me";
                } else {
                    setcookie("email", "", time() - 3600);
                    setcookie("password", "", time() - 3600);
                    setcookie("remember_me", "", time() - 3600);
                    echo "remember me not";
                }
                session_start();
                $_SESSION["user_name"] = $user_name;

?>

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLongTitle">Login</h5>
                                <button type="button" class="close" data-dismiss="modal" id="proceed1" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center">Successfully Logged in</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="proceed2">Proceed</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $("#myModal").modal('show');
                    $("#myModal").on("hidden.bs.modal", function() {
                        // window.location.replace('course.php');
                    })
                    document.getElementById("proceed1").addEventListener("click", proceedFunction);
                    document.getElementById("proceed2").addEventListener("click", proceedFunction);

                    function proceedFunction() {
                        window.location.replace('course.php');
                    }
                </script>
<?php
            } else {
                $error = "failed to login, Wrong Credentials";
                echo "<script>window.location.replace('index.php?success=2&msgLogin=$error&form=login')</script>";
            }
        } else {
            $error = "failed to execute query";
            echo "<script>window.location.replace('index.php?success=2&msgLogin=$error&form=login')</script>";
        }
    }
}else{
    echo "<script>window.location.replace('index.php')</script>";

}
?>