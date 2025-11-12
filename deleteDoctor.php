<?php
include("DBConnection.php");

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->prepare("DELETE FROM doctor_details WHERE doctor_Id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        echo "<script>alert('Doctor deleted successfully'); window.location='doctor_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting doctor'); history.back();</script>";
    }

    $stmt->close();
}
$con->close();
?>
