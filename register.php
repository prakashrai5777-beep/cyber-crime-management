<?php
include("db.php");

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (name,email,username,password)
            VALUES ('$name','$email','$username','$password')";

    if(mysqli_query($conn,$sql)){
        echo "<script>
                alert('Registration Successful!');
                window.location.href='login.html';
              </script>";
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>