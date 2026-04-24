<?php
$conn = mysqli_connect("localhost", "root", "", "cyber_crime");

$result = mysqli_query($conn, "
SELECT complaints.*, user.name 
FROM complaints 
LEFT JOIN user ON complaints.user_id = user.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Cases</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

/* BODY */
/* BODY */
/* BODY */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: #f1f5f9;
    color: #111;
}

/* HEADING */
h2 {
    text-align:center;
    margin-top:25px;
    font-size:32px;
    font-weight:600;
    animation: fadeSlide 0.6s ease;
}

/* ANIMATION */
@keyframes fadeSlide {
    from { opacity:0; transform:translateY(-20px); }
    to { opacity:1; transform:translateY(0); }
}

/* TABLE */
table {
    width:90%;
    margin:30px auto;
    border-collapse:collapse;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    animation: fadeUp 0.6s ease;
}

/* HEAD */
th {
    background:#111;
    color:white;
    padding:14px;
    font-weight:500;
}

/* CELLS */
td {
    padding:13px;
    text-align:center;
    border-bottom:1px solid #eee;
    transition:0.2s;
}

/* ROW HOVER */
tr:hover {
    background:#f9fafb;
    transform: scale(1.01);
}

/* STATUS */
.status-pending { 
    color: orange;
    font-weight:600;
}

.status-resolved { 
    color: green;
    font-weight:600;
}

/* RESOLUTION BOX */
.resolved-box{
    background:#f1f5f9;
    padding:8px;
    border-radius:8px;
    font-size:13px;
}

/* BUTTON BASE */
.action-btn {
    padding:7px 14px;
    border-radius:8px;
    font-size:13px;
    cursor:pointer;
    border:none;
    transition:0.2s;
}

/* RESOLVE BUTTON */
.resolve-btn {
    background:#111;
    color:white;
}

.resolve-btn:hover {
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* DELETE */
.delete {
    background:red;
    color:white;
}

.delete:hover {
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(255,0,0,0.3);
}

/* MODAL */
.modal {
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
}

/* MODAL BOX */
.modal-content {
    background:#fff;
    color:#111;
    padding:25px;
    border-radius:14px;
    width:320px;
    text-align:center;
    animation: zoomFade 0.3s ease;
}

/* MODAL ANIMATION */
@keyframes zoomFade {
    from{transform:scale(0.7); opacity:0;}
    to{transform:scale(1); opacity:1;}
}

/* TEXTAREA */
textarea {
    width:100%;
    height:85px;
    margin:10px 0;
    border-radius:8px;
    padding:8px;
    border:1px solid #ccc;
}

/* MODAL BUTTONS */
.modal-content button {
    padding:8px 12px;
    margin:5px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* FADE UP */
@keyframes fadeUp{
    from{opacity:0; transform:translateY(25px);}
    to{opacity:1; transform:translateY(0);}
}
</style>

</head>

<body>

<h2>Cases / Complaints</h2>

<table>
<tr>
<th>ID</th>
<th>User</th>
<th>Crime</th>
<th>Status</th>
<th>Description</th>
<th>Resolution</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { 
$statusClass = (strtolower($row['status']) == 'pending') ? 'status-pending' : 'status-resolved';
?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['crime_type'] ?></td>

<td class="<?= $statusClass ?>">
<?= ucfirst($row['status']) ?>

<?php if(strtolower($row['status']) == 'resolved' && !empty($row['resolved_at'])){ ?>
<br>
<small>🕒 <?= date("d M Y, h:i A", strtotime($row['resolved_at'])) ?></small>
<?php } ?>
</td>

<td><?= $row['description'] ?></td>

<td>
<?php if(!empty($row['resolution_note'])){ ?>
<div class="resolved-box">
✅ <?= $row['resolution_note'] ?>
</div>
<?php } else { echo "-"; } ?>
</td>

<td>

<?php if (strtolower($row['status']) == 'pending'){ ?>
<button type="button" 
onclick="openModal(<?= $row['id'] ?>)" 
class="action-btn resolve-btn">
Resolve
</button>
<?php } ?>

<a href="delete.php?id=<?= $row['id'] ?>" 
class="action-btn delete"
onclick="return confirm('Delete karna hai?')">
Delete
</a>

</td>
</tr>

<?php } ?>

</table>

<!-- MODAL -->
<div id="resolveModal" class="modal">
<div class="modal-content">
<h3>Resolve Complaint</h3>

<form method="POST" action="resolve.php">
<input type="hidden" name="id" id="complaintId">

<textarea name="note" placeholder="Write solution (optional)"></textarea>

<br>
<button type="submit" name="resolve" style="background:#22c55e;color:white;">Submit</button>
<button type="button" onclick="closeModal()" style="background:#ef4444;color:white;">Cancel</button>
</form>

</div>
</div>

<script>

function openModal(id){
    document.getElementById("resolveModal").style.display = "flex";
    document.getElementById("complaintId").value = id;
}

function closeModal(){
    document.getElementById("resolveModal").style.display = "none";
}

</script>

</body>
</html>