<?php
$conn = mysqli_connect("localhost","root","","cyber_crime");

$data = null;
$error = "";

if(isset($_POST['track'])){
    $id = intval($_POST['complaint_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM complaints WHERE id=$id AND email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
    } else {
        $error = "No complaint found with this ID & Email!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Track Complaint</title>

<style>
body{
    font-family: Arial;
    background:#0f2027;
    color:white;
    text-align:center;
    padding-top:50px;
}

input{
    padding:10px;
    margin:10px;
    border-radius:5px;
    border:none;
}

button{
    padding:10px 20px;
    background:#00ffff;
    border:none;
    cursor:pointer;
}

.result{
    margin-top:20px;
    background:#222;
    padding:20px;
    border-radius:10px;
    width:400px;
    margin:auto;
}

.resolved{color:lightgreen;}
.pending{color:orange;}

.note{
    margin-top:10px;
    background:green;
    padding:10px;
    border-radius:5px;
}
</style>

</head>

<body>

<h2>🔍 Track Complaint</h2>

<form method="POST">
    <input type="number" name="complaint_id" placeholder="Enter Complaint ID" required>
    <br>
    <input type="email" name="email" placeholder="Enter your Email" required>
    <br>
    <button type="submit" name="track">Track</button>
</form>

<?php if($error){ ?>
<p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<?php if($data){ ?>
<div class="result">

<p><b>ID:</b> <?= $data['id'] ?></p>
<p><b>Crime:</b> <?= $data['crime_type'] ?></p>
<p><b>Description:</b> <?= $data['description'] ?></p>

<p>
<b>Status:</b> 
<span class="<?= strtolower($data['status']) ?>">
<?= ucfirst($data['status']) ?>
</span>
</p>

<?php if(strtolower($data['status']) == 'resolved'){ ?>
<div class="note">
✅ <?= $data['resolution_note'] ?>
</div>
<?php } ?>

</div>
<?php } ?>

</body>
</html>