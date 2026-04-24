<?php
$conn = mysqli_connect("localhost","root","","cyber_crime");

if(isset($_POST['resolve'])){

    $id = intval($_POST['id']);
    $note = trim($_POST['note']);

    // 🔍 Complaint ka crime_type nikaalo
    $get = mysqli_query($conn, "SELECT crime_type FROM complaints WHERE id=$id");
    $row = mysqli_fetch_assoc($get);
    $crime = strtolower($row['crime_type']);

    // 🧠 AUTO SMART NOTE (agar admin ne kuch nahi likha)
    if(empty($note)){

        if($crime == "fake call"){
            $note = "Block the caller number immediately. Never share OTP or bank details with unknown callers.";
        }
        elseif($crime == "upi scam"){
            $note = "Do not approve unknown payment requests. Contact your bank immediately and report fraud.";
        }
        elseif($crime == "online fraud"){
            $note = "Avoid suspicious links and verify websites before making payments. Inform your bank.";
        }
        elseif($crime == "cyber bullying"){
            $note = "Block the user, save screenshots as evidence, and report on the platform.";
        }
        else{
            $note = "Issue has been reviewed and resolved. Stay alert and follow cyber safety practices.";
        }
    }

    // 🔐 Secure save
    $note = mysqli_real_escape_string($conn, $note);

    $sql = "UPDATE complaints 
            SET status='Resolved',
            resolution_note='$note',
            resolved_at=NOW()
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: cases.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>