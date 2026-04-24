<?php
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$where = "";

if($from && $to){
    $from = mysqli_real_escape_string($conn, $from);
    $to = mysqli_real_escape_string($conn, $to);
    $where = "WHERE DATE(complaints.created_at) BETWEEN '$from' AND '$to'";
}

// COUNTS
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM complaints $where"))['t'];

$pending = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as t FROM complaints 
WHERE status='Pending' " . ($where ? "AND DATE(created_at) BETWEEN '$from' AND '$to'" : "")
))['t'];

$resolved = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as t FROM complaints 
WHERE status='Resolved' " . ($where ? "AND DATE(created_at) BETWEEN '$from' AND '$to'" : "")
))['t'];

// DATA
$result = mysqli_query($conn, "
SELECT complaints.*, user.name 
FROM complaints 
JOIN user ON complaints.user_id = user.id
$where 
ORDER BY complaints.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: linear-gradient(135deg, #eef2f7, #e0e7ff);
    text-align: center;
}

/* Heading */
h1 {
    margin-top: 20px;
    animation: bounceIn 1s ease;
}

/* Filter */
form {
    margin-top: 20px;
    animation: fadeIn 1s ease;
}

input, button {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin: 5px;
}

button {
    background: #6366f1;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #4f46e5;
    transform: scale(1.05);
}

/* Cards */
.cards {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.box {
    width: 200px;
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    animation: popUp 0.6s ease;
    font-size: 18px;
    font-weight: bold;
}

.box:hover {
    transform: translateY(-10px) scale(1.05);
}

/* Download Button */
.download {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 20px;
    background: #0f172a;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s;
}

.download:hover {
    background: #1e293b;
    transform: scale(1.05);
}

/* Table */
table {
    width: 90%;
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
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f1f5f9;
}

/* Status */
.pending {
    color: #f59e0b;
    font-weight: bold;
}

.resolved {
    color: #22c55e;
    font-weight: bold;
}

/* Animations */
@keyframes bounceIn {
    0% { transform: translateY(-40px); opacity: 0; }
    60% { transform: translateY(10px); }
    100% { transform: translateY(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popUp {
    0% { transform: scale(0.5); opacity: 0; }
    80% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes fadeInUp {
    from { transform: translateY(40px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

</style>

</head>

<body>

<h1>Reports</h1>

<form method="GET">
    From: <input type="date" name="from" value="<?php echo $from; ?>">
    To: <input type="date" name="to" value="<?php echo $to; ?>">
    <button type="submit">Filter</button>
</form>

<div class="cards">
    <div class="box">Total<br><?php echo $total; ?></div>
    <div class="box">Pending<br><?php echo $pending; ?></div>
    <div class="box">Resolved<br><?php echo $resolved; ?></div>
</div>

<a class="download" href="report_pdf.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>">
Download PDF
</a>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Crime</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

    $statusClass = ($row['status']=="Resolved") ? "resolved" : "pending";

    echo "<tr>
    <td>".$row['id']."</td>
    <td>".$row['name']."</td>
    <td>".$row['crime_type']."</td>
    <td class='$statusClass'>".$row['status']."</td>
    <td>".$row['created_at']."</td>
    </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data found</td></tr>";
}
?>

</table>

</body>
</html>