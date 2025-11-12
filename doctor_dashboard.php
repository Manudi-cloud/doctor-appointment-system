<?php
session_start();
include("DBConnection.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit;
}
$doctorId   = $_SESSION['doctor_id'];  
$doctorName = $_SESSION['doctor_name'];
$doctorEmail = $_SESSION['doctor_email'];
// Fetch doctor availability
$stmt = $con->prepare("SELECT available_date, start_time, end_time FROM doctor_availabiility WHERE doctor_Id = ? ORDER BY available_date ASC, start_time ASC");
if (!$stmt) {
    die("Prepare failed: " . $con->error);
}
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$availResult = $stmt->get_result();
$availabilities = [];
while ($row = $availResult->fetch_assoc()) {
    $availabilities[] = $row;
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.sidebar { position: fixed; top:0; bottom:0; left:0; width:220px; background:#212529; padding-top:20px; }
.sidebar .nav-link { color:#adb5bd; margin:8px 0; }
.sidebar .nav-link.active, .sidebar .nav-link:hover { color:#fff; background:#343a40; border-radius:8px; }
.main-content { margin-left:240px; padding:20px; }
</style>
</head>
<body>

<div class="sidebar">
  <h5 class="text-white text-center mb-4">Doctor Panel</h5>
  <ul class="nav flex-column px-3">
    <li><a href="doctor_dashboard.php" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
    <li><a href="doctorProfile.php" class="nav-link"><i class="bi bi-person-circle me-2"></i> Profile</a></li>

    <li><a href="booked_appointments.php" class="nav-link"><i class="bi bi-bell me-2"></i> Notifications</a></li>
    <li>
     <a href="#" class="nav-link text-danger" onclick="confirmLogout()">
       <i class="bi bi-box-arrow-right me-2"></i> Logout
     </a>
    </li>

    <script>
      function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
           window.location.href = "logout.php";
        }
      }
    </script>

  </ul>
</div>

<div class="main-content">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Welcome,  <?php echo htmlspecialchars($doctorName); ?></h2>
    
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Set Your Available Time</h5>
      <form action="save_availability.php" method="post" class="row g-3">
        <div class="col-md-4">
          <label for="available_date" class="form-label">Available Date</label>
          <input type="date" class="form-control" name="available_date" required>
        </div>
        <div class="col-md-4">
          <label for="start_time" class="form-label">Start Time</label>
          <input type="time" class="form-control" name="start_time" required>
        </div>
        <div class="col-md-4">
          <label for="end_time" class="form-label">End Time</label>
          <input type="time" class="form-control" name="end_time" required>
        </div>
        <input type="hidden" name="doctor_id" value="<?php echo $doctorId; ?>">
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Save Availability</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Your Availability</h5>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($availabilities as $av): ?>
            <tr>
              <td><?php echo htmlspecialchars($av['available_date']); ?></td>
              <td><?php echo htmlspecialchars($av['start_time']); ?></td>
              <td><?php echo htmlspecialchars($av['end_time']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(empty($availabilities)) echo '<tr><td colspan="3">No availability set yet.</td></tr>'; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
