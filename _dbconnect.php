<?php
$servername = "localhost";
$username = "root"; // or your database username
$password = ""; // or your database password
$database = "your_database_name";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
















<?php
// $server = "localhost";
// $username = "root";
// $password = "";
// $database = "user7033";

// $conn = mysqli_connect($server, $username, $password, $database);
// if (!$conn){
// //     echo "success";
// // }
// // else{
//     die("Error". mysqli_connect_error());
// }

?>
