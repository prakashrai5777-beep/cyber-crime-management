<?php
session_start();

if(!isset($_SESSION['username'])){
    header("location:login.html");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

// Total Cases
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints"))['total'];

// Pending Complaints
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints WHERE status='pending'"))['total'];

// Resolved Cases
$resolved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints WHERE status='resolved'"))['total'];

// Total Users
$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user"))['total'];

// Recent Complaints (JOIN with user table)
$recent = mysqli_query($conn, "
SELECT c.id, u.name AS user_name, c.crime_type, c.status, c.created_at, c.description
FROM complaints c
JOIN user u ON c.user_id = u.id
ORDER BY c.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Cyber Crime Dashboard</title>

<style>
bbody {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: linear-gradient(135deg, #eef2f7, #e0e7ff);
}

/* Sidebar */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #0f172a;
    color: white;
    position: fixed;
    box-shadow: 5px 0 15px rgba(0,0,0,0.2);
}

.sidebar h2 {
    text-align: center;
    padding: 20px;
    letter-spacing: 1px;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #cbd5f5;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #1e293b;
    padding-left: 30px;
    color: #38bdf8;
}

/* Main */
.main {
    margin-left: 220px;
    padding: 20px;
    animation: fadeIn 1s ease-in-out;
}

h1 {
    animation: bounceIn 1s ease;
}

/* Cards */
.cards {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.card {
    flex: 1;
    padding: 20px;
    background: white;
    border-radius: 15px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: 0.3s;
    animation: popUp 0.6s ease forwards;
}

.card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* Table */
table {
    width: 100%;
    margin-top: 30px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    border-collapse: collapse;
    animation: fadeInUp 1s ease;
}

th {
    background: #0f172a;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f1f5f9;
    transition: 0.3s;
}

/* Buttons */
a {
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    opacity: 0.7;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popUp {
    0% {
        transform: scale(0.5);
        opacity: 0;
    }
    80% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

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

<div class="sidebar">
    <h2><a href="dashboard.php" style="color:white; text-decoration:none;">Cyber Admin</a></h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="cases.php">Cases</a>
    <a href="add_complaint.php">Complaints</a>
    <a href="users.php">users</a>
    <a href="reports.php">Reports</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h1>Dashboard</h1>

    <div class="cards">
        <div class="card">Total: <?php echo $total; ?></div>
        <div class="card">Pending: <?php echo $pending; ?></div>
        <div class="card">Resolved: <?php echo $resolved; ?></div>
        <div class="card">Users: <?php echo $users; ?></div>
    </div>

    <h2>Recent Complaints</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Crime</th>
            <th>Status</th>
            <th>Date</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>

        <?php
        if(mysqli_num_rows($recent) > 0){
            while($row = mysqli_fetch_assoc($recent)){
                echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['user_name']."</td>
                <td>".$row['crime_type']."</td>
                <td>".$row['status']."</td>
                <td>".$row['created_at']."</td>
                <td>".$row['description']."</td>

                <td>
                <a href='update_status.php?id=".$row['id']."' style='color:green;'>Resolve</a> |
                <a href='delete.php?id=".$row['id']."' 
                onclick=\"return confirm('Are you sure delete karna hai?')\"
                style='color:red;'>Delete</a>
                </td>

                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No complaints found</td></tr>";
        }
        ?>

        </tbody>
    </table>

</div>

</body>
</html>