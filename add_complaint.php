<!DOCTYPE html>
<html>
<head>
<title>Report Complaint</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Floating Animation */
.form-box {
    background: white;
    padding: 30px;
    width: 350px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: floatBox 4s ease-in-out infinite;
}

/* Floating effect */
@keyframes floatBox {
    0%,100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

/* Heading with gradient animation */
h2 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: 700;
    background: linear-gradient(90deg, #6366f1, #ec4899);
    -webkit-background-clip: text;
    color: transparent;
    animation: bounceIn 1s ease, glow 2s infinite alternate;
}

/* Glow animation */
@keyframes glow {
    from { text-shadow: 0 0 5px #6366f1; }
    to { text-shadow: 0 0 15px #ec4899; }
}

/* Bounce */
@keyframes bounceIn {
    0% { transform: translateY(-50px); opacity: 0; }
    60% { transform: translateY(10px); }
    100% { transform: translateY(0); opacity: 1; }
}

/* Inputs */
select, input, textarea {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin-top: 8px;
    transition: 0.3s;
    font-size: 14px;
}

/* Input focus glow */
select:focus, input:focus, textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 12px rgba(99,102,241,0.6);
    transform: scale(1.03);
    outline: none;
}

/* Textarea */
textarea {
    resize: none;
    height: 100px;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 15px;
    transition: 0.3s;
    position: relative;
    overflow: hidden;
}

/* Button hover */
button:hover {
    transform: scale(1.08);
}

/* Ripple effect */
button::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.3);
    top: 0;
    left: -100%;
    transition: 0.5s;
}

button:hover::after {
    left: 100%;
}

/* Label */
label {
    font-weight: 500;
    margin-top: 10px;
    display: block;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Report Complaint</h2>

<form action="save_complaint.php" method="POST">

    <label>Crime Type</label>
    <select name="crime_type" id="crime_type" onchange="toggleOther()" required>
        <option value="">Select Crime Type</option>
        <option value="UPI Scam">UPI Scam</option>
        <option value="Online Fraud">Online Fraud</option>
        <option value="Hacking">Hacking</option>
        <option value="Fake Call">Fake Call</option>
        <option value="Cyber Bullying">Cyber Bullying</option>
        <option value="Others">Others</option>
    </select>

    <input type="text" name="other_crime" id="other_crime" 
    placeholder="Enter your crime type" style="display:none;">

    <label>Description</label>
    <textarea name="description" placeholder="Enter complaint" required></textarea>

    <button type="submit">Submit Complaint</button>

</form>

</div>

<script>
function toggleOther(){
    var select = document.getElementById("crime_type");
    var other = document.getElementById("other_crime");

    if(select.value === "Others"){
        other.style.display = "block";
        other.required = true;
    } else {
        other.style.display = "none";
        other.required = false;
    }
}
</script>

</body>
</html>