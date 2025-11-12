<?php
session_start();
include("DBConnection.php");

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    die("Please login as a patient to book a test.");
}

$patient_id = $_SESSION['patient_id'];

// Validate lab test ID
if (!isset($_GET['id'])) {
    die("Invalid request.");
}
$test_id = intval($_GET['id']);

// Fetch lab test details
$stmt = $con->prepare("SELECT test_id, test_name, description, price 
                       FROM labtest_details 
                       WHERE test_id = ?");
if (!$stmt) {
    die("SQL Error: " . $con->error);
}
$stmt->bind_param("i", $test_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Lab test not found.");
}
$test = $result->fetch_assoc();

// Handle booking confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $insert = $con->prepare("INSERT INTO lab_booking (patient_id, test_id, status) VALUES (?, ?, 'Confirmed')");
    if (!$insert) {
        die("SQL Error: " . $con->error);
    }
    $insert->bind_param("ii", $patient_id, $test_id);

    if ($insert->execute()) {
        echo "<script>alert('Booking confirmed successfully!'); window.location='my_lab_bookings.php';</script>";
        exit;
    } else {
        echo "Error: " . $insert->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm Booking - <?php echo htmlspecialchars($test['test_name']); ?></title>
  <link rel="stylesheet" href="lab.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="lab-confirm">
  <h2>Confirm Booking</h2>
  <p><strong>Test:</strong> <?php echo htmlspecialchars($test['test_name']); ?></p>
  <p><strong>Description:</strong> <?php echo htmlspecialchars($test['description']); ?></p>
  <p><strong>Price:</strong> Rs. <?php echo number_format($test['price'], 2); ?></p>

  <form method="post">
    <button type="submit" class="lab-btn">Confirm Booking</button>
    <a href="lab.php" class="lab-btn cancel">Cancel</a>
  </form>
</div>

<?php include('footer.php'); ?>
</body>
</html>
