<?php


function getRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < 20; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString.".";
}

if (isset($_POST)) {
    include_once("dbconnect.php");
    $email = $_REQUEST['email'];
    $name = $_REQUEST['name'];
    $phone = $_REQUEST['phone'];
    $password = $_REQUEST['password'];
    $address = $_REQUEST['address'];
    $error;

    if(empty($name)||empty($phone)||empty($password)||empty($email)||empty($address)||$_FILES['fileUpload']["name"] == null){
      $error = "Please enter all the field.";

    }else if(strlen($name) < 5){
      $error = "Please enter name with minimum 5 character";
      
    }else if(is_numeric($phone) < 5){
      $error = "Please enter phone number with numbers only!";
      
    }else if(strlen($password) < 8 || !ctype_alnum($password)){
      $error = "Please enter name with minimum 8 character and alphanumeric";
      
    }else{
          $target_dir = "../assets/uploads/";
    $imageFileType = strtolower(pathinfo($_FILES['fileUpload']["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir.getRandomString().$imageFileType;

    $sqlinsert = "INSERT INTO `users`(`email`, `name`, `phone`, `password`, 
    `address`,`image`) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sqlinsert);
    $stmt->bind_param("ssssss",$email,$name,$phone,$password,$address,$target_file);

    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file && $stmt->execute())) {
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('index.php?form=login')</script>";
      } else {
        echo "<script>alert('Failed')</script>";
        $error = "Failed Sign Up";
      }
      // echo "<script>window.location.replace('index.php?form=login')</script>";
    }
    echo "<script>window.location.replace('index.php?msgRegister=$error&form=register')</script>";


}