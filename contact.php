<?php
include("db.php");

if(isset($_POST['send'])){

    // Secure input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact (name, email, message)
            VALUES ('$name','$email','$message')";

    if(mysqli_query($conn,$sql)){
        echo "<script>
                alert('Message Sent Successfully!');
                window.location.href='contact.php';
              </script>";
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body{
            font-family: Arial;
            background:#111;
            color:white;
            text-align:center;
        }
        form{
            margin-top:50px;
        }
        input, textarea{
            width:300px;
            padding:10px;
            margin:10px;
            border:none;
            border-radius:5px;
        }
        button{
            padding:10px 20px;
            background:green;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }
        button:hover{
            background:darkgreen;
        }
    </style>
</head>
<body>

<h2>Contact Us</h2>

<form method="POST" action="">

    <input type="text" name="name" placeholder="Your Name" required><br>

    <input type="email" name="email" placeholder="Your Email" required><br>

    <textarea name="message" placeholder="Enter your message" required></textarea><br>

    <!-- IMPORTANT -->
    <button type="submit" name="send">Send Message</button>

</form>

</body>
</html>