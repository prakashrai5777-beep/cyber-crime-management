<?php
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

$result = mysqli_query($conn, "SELECT * FROM complaints ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Report</title>
<style>
body { font-family: Arial; }
table { width:100%; border-collapse: collapse; }
th, td { border:1px solid black; padding:8px; }
th { background:#ddd; }
</style>
</head>

<body onload="window.print()">

<h2>Cyber Crime Report</h2>

<table>
<tr>
<th>ID</th>
<th>Crime</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['crime_type']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>