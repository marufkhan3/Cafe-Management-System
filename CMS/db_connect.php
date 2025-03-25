
<?php
$connection = mysqli_connect("localhost", "root", "", "cafe_db");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
