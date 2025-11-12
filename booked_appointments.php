<?php
session_start();
include("DBConnection.php");

if (!isset($_SESSION['doctor_id'])) {
    die("Please login first.");
}

$doctor_id = $_SESSION['doctor_id'];

$sql = "SELECT a.appointment_Id, a.status, a.created_at,
               p.name AS patient_name, p.username AS patient_email,
               av.available_date, av.start_time, av.end_time
        FROM appointment a
        JOIN patient_details p ON a.patient_id = p.patient_Id
        JOIN doctor_availabiility av ON a.availability_id = av.id
        WHERE a.doctor_id = ?
        ORDER BY av.available_date, av.start_time";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Appointments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Upcoming Appointments</h2>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['appointment_Id']; ?></td>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($row['patient_email']); ?></td>
            <td><?php echo $row['available_date']; ?></td>
            <td><?php echo $row['start_time'] . " - " . $row['end_time']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No upcoming appointments.</p>
    <?php endif; ?>
</div>
</body>
</html>

