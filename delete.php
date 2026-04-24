<?php
$conn = mysqli_connect("localhost","root","","cyber_crime");

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM complaints WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: cases.php");
        exit();
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
}
?>