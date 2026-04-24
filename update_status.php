<?php
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "UPDATE complaints SET status='Resolved' WHERE id=$id");

    header("Location: dashboard.php");
}
?>