<?php
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

$showAlert = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partial/_dbconnect.php';

    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if passwords match
    if ($password == $cpassword) {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM `user` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Username already exists
            $showAlert = "Username already exists.";
        } else {
            // Hash the password before storing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the INSERT statement
            $stmt = $conn->prepare("INSERT INTO `user` (`username`, `password`, `dt`) VALUES (?, ?, current_timestamp())");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $showAlert = "Registration successful!";
            } else {
                $showAlert = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        $showAlert = "Passwords do not match.";
    }
    $conn->close();
}
?>





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
    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
    </div>
<!-- 
  <div class="mb-3">
    <label for="Last name" class="form-label">Last name</label>
    <input type="name" class="form-control" id="Last name" name="Last name" aria-describedby="name">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div> -->


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

  <!-- <div class="mb-3 form-check"> -->
    <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
    <!-- <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
  <!-- </div> -->
  <button type="submit" class="btn btn-primary">SignUp</button>
</form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>


</body>
</html>