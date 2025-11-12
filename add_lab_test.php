<?php
include("DBConnection.php");

$msg = "";

if (isset($_POST['submit'])) {
    $test_name = $_POST['test_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sample_required = $_POST['sample_required'];
    $report_time = $_POST['report_time'];
    $preparation = $_POST['preparation'];

    $stmt = $con->prepare("INSERT INTO labtest_details (test_name, description, price, sample_required, report_time, preparation) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $test_name, $description, $price, $sample_required, $report_time, $preparation);

    if ($stmt->execute()) {
        $msg = "✅ Lab Test added successfully!";
    } else {
        $msg = "❌ Error: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Lab Test</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        .form-container { background: white; padding: 20px; width: 500px; margin: auto; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .msg { text-align: center; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Lab Test</h2>

    <?php if ($msg != "") echo "<p class='msg'>$msg</p>"; ?>

    <form method="POST" action="">
        <label>Test Name:</label>
        <input type="text" name="test_name" required>

        <label>Description:</label>
        <textarea name="description" rows="3" required></textarea>

        <label>Price (Rs.):</label>
        <input type="number" name="price" step="0.01" required>

        <label>Sample Required:</label>
        <input type="text" name="sample_required" placeholder="e.g. Blood, Urine" required>

        <label>Report Time:</label>
        <input type="text" name="report_time" placeholder="e.g. 24 hours" required>

        <label>Preparation Instructions:</label>
        <textarea name="preparation" rows="3"></textarea>

        <button type="submit" name="submit">Add Test</button>
        <a href="admin_dashboard.html">Back to dashboard</a>

    </form>
</div>

</body>
</html>
