<?php
session_start();
include('DBConnection.php'); 

// Check if user is logged in
if (!isset($_SESSION['login'])) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Get the logged-in username
$username = $_SESSION['login'];

// Prepare statement to get user details
$stmt = $con->prepare("SELECT name, email, contactno, username, password FROM admin_details WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user details
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found.";
    exit;
}

// Close the statement and connection
$stmt->close();
$con->close();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="../Pages/images/logo new.ico">
    <link rel="stylesheet" href="adminProfile.css">

    
</head>
<body>
    <div class="profile-container">
        <h1> Profile</h1>
        <div class="profile-details">
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user['contactno']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Password :</strong> <?php echo htmlspecialchars($user['password']); ?></p>
        </div>
        <a href="admin_dashboard.html">Back to Dashboard</a>
    </div>
</body>
</html>
