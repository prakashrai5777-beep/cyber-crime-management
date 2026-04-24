<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include("db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email'] = $row['email'];

        header("location:dashboard.php");
        exit();

    } else {
        echo "<script>
                alert('Invalid Username or Password!');
                window.location.href='login.html';
              </script>";
    }

} else {
    echo "Please login through form!";
}
?>