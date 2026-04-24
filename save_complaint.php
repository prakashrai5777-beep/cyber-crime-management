<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// DB Connection
$conn = mysqli_connect("localhost","root","","cyber_crime");

// Check login
if(!isset($_SESSION['email'])){
    die("Please login first");
}

$email = $_SESSION['email'];

// USER ID nikaal lo email se
$user = mysqli_query($conn, "SELECT id FROM user WHERE email='$email'");
$userData = mysqli_fetch_assoc($user);

if(!$userData){
    die("User not found");
}

$user_id = $userData['id'];

// Crime type check
if($_POST['crime_type'] == "Others"){
    $crime = $_POST['other_crime'];
} else {
    $crime = $_POST['crime_type'];
}

$desc = $_POST['description'];

// INSERT complaint (🔥 email added)
$sql = "INSERT INTO complaints (user_id, crime_type, description, status, email) 
VALUES ('$user_id','$crime','$desc','Pending','$email')";

if(mysqli_query($conn, $sql)){

    $last_id = mysqli_insert_id($conn);

    // ================= EMAIL SEND =================
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'prakashrai5777@gmail.com'; // apni gmail
        $mail->Password = 'molo gtjo zxag ldqz'; // app password (no space/new line)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('prakashrai5777@gmail.com', 'Cyber Crime Portal');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Complaint Submitted';

        $mail->Body = "
        <h3>Complaint Submitted Successfully ✅</h3>
        <p>Your Complaint ID: <b>$last_id</b></p>
        <p>Status: Pending</p>

        <p>
        <a href='http://localhost/CYBER_PROJECT/track.php?id=$last_id'>
        Click here to Track Your Complaint
        </a>
        </p>

        <hr>
        <p style='font-size:12px;'>Cyber Crime Portal</p>
        ";

        $mail->send();

    } catch (Exception $e) {
        echo "Mail not sent ❌: {$mail->ErrorInfo}<br><br>";
    }
    // =============================================

    // Success UI
    echo "
    <h2>Complaint Submitted Successfully ✅</h2>
    <p>Your Complaint ID: <b>$last_id</b></p>
    <p>Status: Pending</p>
    <br>
    <a href='track.php?id=$last_id'>Track Your Complaint</a>
    ";

} else {
    echo "Error: " . mysqli_error($conn);
}
?>