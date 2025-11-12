<?php
session_start();
include("DBConnection.php");

if (!isset($_GET['appointment_Id'])) {
    die("Invalid appointment.");
}

$appointment_id = intval($_GET['appointment_Id']);

$sql = "SELECT a.appointment_Id, a.status, a.created_at, d.doc_name, av.available_date, av.start_time, av.end_time
        FROM appointment a
        JOIN doctor_details d ON a.doctor_Id = d.doctor_Id
        JOIN doctor_availabiility av ON a.availability_id = av.id
        WHERE a.appointment_Id = ?";

$stmt = $con->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $con->error);
}
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    die("Invalid appointment.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Appointment Confirmation</title>
</head>
<body>
  <h2>Appointment Confirmed</h2>
  <p><strong>Appointment Number:</strong> <?php echo $appointment['appointment_Id']; ?></p>
  <p><strong>Doctor:</strong> <?php echo $appointment['doc_name']; ?></p>
  <p><strong>Date:</strong> <?php echo $appointment['available_date']; ?></p>
  <p><strong>Time:</strong> <?php echo $appointment['start_time'] . " - " . $appointment['end_time']; ?></p>
  <p><strong>Status:</strong> <?php echo $appointment['status']; ?></p>

  <h3>Choose Payment Method</h3>
  <form method="POST" action="payment.php">
    <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_Id']; ?>">
    <label><input type="radio" name="payment_method" value="Online" required> Online Payment</label><br>
    <label><input type="radio" name="payment_method" value="Cash"> Pay at Hospital</label><br>
    <label><input type="radio" name="payment_method" value="Insurance"> Insurance</label><br><br>
    <button type="submit">Proceed</button>
  </form>
</body>
</html>
