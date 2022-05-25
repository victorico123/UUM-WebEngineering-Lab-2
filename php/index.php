<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Tutor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/landing.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<script>
    function openForm(evt, form) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        document.getElementById(form).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<body>
    <header>
        <div class='hero-header align-items-center align-content-center justify-content-center p-'>
            <?php
            if (isset($_GET['success'])) {
                if ($_GET['success'] == 1) {
            ?>
                    <div class="alert alert-success" style="position:absolute; width:100%; z-index: 100;">
                        <strong>Account successfully registered!</strong>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-danger" style="position:absolute; width:100%; z-index: 100;">
                        <strong>Failed to register account!</strong>
                    </div>
            <?php
                }
            }
            ?>
            <div class="parent-landing-card " style="height: 100vh;">
                <div class="card landing-card tabcontent">
                    <div>
                        <object id="svg-teaching" data="../assets/application/svg/teaching.svg" type="image/svg+xml"></object>
                    </div>
                    <div class="card-body text-dark">
                        <h3 class="card-title"><span style="color:blue">My</span><span class="tutor-text">Tutor</span>
                        </h3>
                        <p class="card-text">"Application for a tutor booking and payment."</p>
                        <hr style="height: 1vh;">
                        <button class="btn btn-primary tablinks" onclick="openForm(event, 'login_card')">Sign
                            In</button>
                        <button class="btn btn-primary tablinks" onclick="openForm(event, 'register_card')">Sign
                            Up</button>
                    </div>
                </div>
                <div id="login_card" class="card landing-card login-card tabcontent" style="display: none">
                    <div class="text-dark">
                        <h3 class="card-title"><span style="color:blue">My</span><span class="tutor-text">Tutor</span>
                        </h3>
                        <h5 style="color:blue">SIGN IN</h5>
                        <p class="left">
                        <form>
                            <div class="form-group">
                                <label for="EmailInput" class="text-left">Email address</label>
                                <input type="email" class="form-control" id="EmailInput" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="PasswordInput">Password</label>
                                <input type="password" class="form-control" id="PasswordInput" placeholder="Password">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberInput">
                                <label class="form-check-label" for="rememberInput">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>


                        </p>
                        <hr>
                        <button class="btn btn-secondary tablinks">Sign In</button>
                        <button class="btn btn-primary tablinks" onclick="openForm(event, 'register_card')">Sign
                            Up</button>
                    </div>
                </div>

                <div id="register_card" class="card register-card tabcontent" style="display: none">
                    <div class="text-dark">
                        <h3 class="card-title"><span style="color:blue">My</span><span class="tutor-text">Tutor</span>
                        </h3>
                        <h5 style="color:blue">SIGN UP</h5>
                        <p class="left">
                        <form method="POST" action="register.php" enctype="multipart/form-data" id="register">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="nameInput" class="text-left">Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="nameInput" name="name" aria-describedby="nameHelp" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailInput" class="text-left">Email address <span style="color: red;">*</span></label>
                                        <input type="email" class="form-control" id="emailInput" name="email" aria-describedby="emailHelp" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="passwordInput">Password <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="phoneInput">Phone Number <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="phoneInput" name="phone" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="adressInput">Home Address <span style="color: red;">*</span></label>
                                        <textarea class="form-control" name="address" id="adressInput" cols="30" rows="3" placeholder="Home Adress"></textarea>
                                    </div>

                                </div>
                                <div class="col-12 col-sm-6">
                                    <div style="max-height: 100%;">
                                        <div class="form-group">
                                            <label class="form-label" for="uploadBtn">Input Profile Picture <span style="color: red;">*</span></label>
                                            <input id="uploadBtn" type="file" class="upload form-control" multiple="multiple" accept="image/*" name="fileUpload" />
                                            <br>
                                            <div id="upload_prev">
                                                <img id="photoShowId" src="../assets/application/default-user.png" width="auto" height="200px" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-danger">* <span class="text-dark">Required</span></p>
                                        <?php
                                        if (isset($_GET['msgRegister'])) {
                                            $message = $_GET['msgRegister'];
                                            echo "<p class=\"text-danger\">$message</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>


                        </p>
                        <hr>
                        <button class="btn btn-primary tablinks" onclick="openForm(event, 'login_card')">Sign
                            In</button>
                        <button class="btn btn-secondary tablinks">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
<script src="../js/landing.js"></script>
<script>
    let urlParams = new URLSearchParams(location.search)
    if (urlParams.get("form") == "register") {
        openForm(event, 'register_card');
    } else if (urlParams.get("form") == "login") {
        openForm(event, 'login_card');
    }
</script>

</html>