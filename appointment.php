<?php
session_start();
include("DBConnection.php");

// -- Require login (helps avoid undefined session errors). Remove if you have a global guard.
if (!isset($_SESSION['patient_id'])) {
    die("You must be logged in as a patient to book. Debug session: <pre>" . htmlspecialchars(print_r($_SESSION, true)) . "</pre>");
}

$patient_id = intval($_SESSION['patient_id']);

if (!isset($_POST['availability_id']) || !isset($_POST['doctor_id'])) {
    die("Invalid request.");
}
$availability_id = intval($_POST['availability_id']);
$doctor_id = intval($_POST['doctor_id']);

// Prepare insert (note table name is 'appointment' and columns as in your DB)
$sql = "INSERT INTO appointment (patient_Id, doctor_Id, availability_id, status) VALUES (?, ?, ?, 'Booked')";
$stmt = $con->prepare($sql);
if (!$stmt) die("SQL Error (prepare): " . $con->error);

$stmt->bind_param("iii", $patient_id, $doctor_id, $availability_id);
if ($stmt->execute()) {
    // get inserted appointment id (auto-increment)
    $appointment_id = $con->insert_id;
    header("Location: confirm_appointment.php?appointment_Id=" . $appointment_id);
    exit;
} else {
    die("Error booking appointment: " . $stmt->error);
}
?>
