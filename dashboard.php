<?php
session_start();

// Secure session check
if (!isset($_SESSION['username'])) {
    header("location:login.html");
    exit();
}

// DB connection
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Total Cases
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints"))['total'];

// Pending Complaints
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints WHERE status='pending'"))['total'];

// Resolved Cases
$resolved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints WHERE status='resolved'"))['total'];

// Total Users
$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user"))['total'];

// Recent Complaints (LIMIT added)
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
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #000;
    color: #fff;
    position: fixed;
}

.sidebar h2 {
    text-align: center;
    padding: 20px;
    letter-spacing: 2px;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #bbb;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #111;
    padding-left: 28px;
    color: #fff;
}

/* Main */
.main {
    margin-left: 220px;
    padding: 20px;
}

/* Heading */
.main h1 {
    text-align: center;
    color: #111;
}

/* Cards */
.cards {
    display: flex;
    gap: 20px;
    margin-top: 30px;
}

/* Card Design */
.card {
    flex: 1;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    
    /* Animation */
    animation: bounceFade 0.6s ease;
    transition: 0.3s;
}

/* Hover Lift */
.card:hover {
    transform: translateY(-10px);
}

/* Bounce Animation */
@keyframes bounceFade {
    0% {
        transform: translateY(40px);
        opacity: 0;
    }
    60% {
        transform: translateY(-8px);
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }

/* Table */
table {
    width: 100%;
    margin-top: 30px;
    background: #fff;
    border-radius: 10px;
    border-collapse: collapse;
    overflow: hidden;
}

th {
    background: #000;
    color: #fff;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f9fafb;
}

/* Status */
.pending {
    color: #555;
    font-weight: bold;
}

.resolved {
    color: green;
    font-weight: bold;
}
</style>

</head>

<body>

<div class="sidebar">
    <h2>Cyber Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="cases.php">Cases</a>
    <a href="add_complaint.php">Complaints</a>
    <a href="users.php">Users</a>
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
        if (mysqli_num_rows($recent) > 0) {
            while ($row = mysqli_fetch_assoc($recent)) {

                $statusClass = ($row['status'] == 'resolved') ? 'resolved' : 'pending';

                echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['user_name']) . "</td>
                <td>" . htmlspecialchars($row['crime_type']) . "</td>
                <td class='$statusClass'>" . htmlspecialchars($row['status']) . "</td>
                <td>" . date("d M Y", strtotime($row['created_at'])) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>

                <td>
                <a href='update_status.php?id=" . $row['id'] . "' style='color:green;'>Resolve</a> |
                <a href='delete.php?id=" . $row['id'] . "' 
                onclick=\"return confirm('Are you sure you want to delete?')\" 
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
