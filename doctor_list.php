<?php
include("DBConnection.php");

$sql = "SELECT doctor_Id, doc_name, doc_email, specialization FROM doctor_details";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="doctor_reg.css">
</head>
<body>
    <h2>Doctor Management</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['doctor_Id']; ?></td>
                <td><?= htmlspecialchars($row['doc_name']); ?></td>
                <td><?= htmlspecialchars($row['doc_email']); ?></td>
                <td><?= htmlspecialchars($row['specialization']); ?></td>
                <td>
                    <!-- Edit doctor -->
                    <a href="editDoctor.php?id=<?= $row['doctor_Id']; ?>" class="btn-edit">Edit</a>
                    <!-- Delete doctor -->
                    <a href="deleteDoctor.php?id=<?= $row['doctor_Id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this doctor?');" 
                       class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="admin_dashboard.html">Back to Dashboard</a>
</body>
</html>
<?php mysqli_close($con); ?>

   