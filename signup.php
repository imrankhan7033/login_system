<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$showAlert = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partial/_dbconnect.php';
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    
    if ($password === $cpassword) {
        $sql = "SELECT * FROM `user` WHERE `username` = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO `user` (`username`, `password`, `dt`) VALUES (?, ?, current_timestamp())";
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $username, $hashedPassword);
            
            if ($stmt->execute()) {
                $showAlert = true;
            } else {
                echo "Execute failed: " . $stmt->error;
            }
        } else {
            echo "User already exists.";
        }
        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Check form data
    echo "</pre>";
}



?>





























<!-- 


<php
$showAlert = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partial/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $exists=false;
    if(($password == $cpassword) && $exists==false){


        $sql = "INSERT INTO `user` (`$username`, `$password`, `dt`) VALUES ('imran', '123', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $showAlert = true;
        }
    }
}

?>
 -->




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <?php require 'partial/_nav.php' ?>
    <?php

    if ($showAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Your account is now created and you can login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> ';
    }
    ?>

    
<div class="container">
        <h3 class="text-center">User Information:</h3>
        <form>

    <div class="mb-3">
    <label for="User name" class="form-label">User name</label>
    <input type="name" class="form-control" id="User name" name="User name" aria-describedby="name">
    </div>



  <div class="mb-3">
    <label for="Password" class="form-label">Password</label>
    <input type="password" class="form-control" id="Password" name="Password">
  </div>

  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword">
    <div id="emailHelp" class="form-text">Make sure to type the same password.</div>
  </div>



  <div class="mb-3">
    <label for="mobile_number" class="form-label">Mobile number</label>
    <input type="text" class="form-control" id="mobile_number" name="mobile_number">
    <div id="emailHelp" class="form-text">Never share your OTP with anyone else.</div>
  </div>

  
  <button type="submit" class="btn btn-primary">SignUp</button>
</form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>


</body>
</html>