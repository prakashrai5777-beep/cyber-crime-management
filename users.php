<?php
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

$result = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: linear-gradient(135deg, #eef2f7, #e0e7ff);
}

/* Heading */
h2 {
    text-align: center;
    margin-top: 20px;
    animation: bounceIn 1s ease;
}

/* Table */
table {
    width: 80%;
    margin: 30px auto;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    animation: fadeInUp 1s ease;
}

th {
    background: #0f172a;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f1f5f9;
    transition: 0.3s;
}

/* Animations */
@keyframes bounceIn {
    0% {
        transform: translateY(-50px);
        opacity: 0;
    }
    60% {
        transform: translateY(10px);
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        transform: translateY(40px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

</style>

</head>

<body>

<h2>Users</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>