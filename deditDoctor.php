<?php
include("DBConnection.php");

if(!isset($_GET['id'])) {
    die("Doctor ID missing!");
}
$id = intval($_GET['id']);

// Fetch doctor details
$sql = "SELECT * FROM doctor_details WHERE doctor_Id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    die("Doctor not found!");
}

$doctor = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="doctor_reg.css">
</head>
<body>
    <h2>Edit Doctor Details</h2>
    <form action="dupdateDoctor.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="doctor_id" value="<?= $doctor['doctor_Id']; ?>">

        <label>Name:</label>
        <input type="text" name="doc_name" value="<?= htmlspecialchars($doctor['doc_name']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="doc_email" value="<?= htmlspecialchars($doctor['doc_email']); ?>" required><br>

        <label>Contact:</label>
        <input type="text" name="doc_contactno" value="<?= htmlspecialchars($doctor['doc_contactno']); ?>"><br>

        <label>Specialization:</label>
        <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']); ?>"><br>

        <label>Experience (years):</label>
        <input type="number" name="years_experienced" value="<?= $doctor['years_experienced']; ?>"><br>

        <label>Registration No:</label>
        <input type="text" name="registration_no" value="<?= htmlspecialchars($doctor['registration_no']); ?>"><br>

        <label>Photo:</label>
        <input type="file" name="doctorimage"><br>
        <small>Leave blank to keep existing photo</small><br><br>

        <button type="submit" name="update">Update Doctor</button>
    </form>
</body>
</html>
