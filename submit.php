mysqli_query($conn, $sql);

// ID nikaal
$last_id = mysqli_insert_id($conn);

// MESSAGE + LINK
echo "<h2>Complaint Submitted ✅</h2>";
echo "<p>Your Complaint ID is: <b>$last_id</b></p>";
echo "<a href='track.php?id=$last_id'>Track Your Complaint</a>";