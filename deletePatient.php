<?php
include("DBConnection.php");

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->prepare("DELETE FROM patient_details WHERE patient_Id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        echo "<script>alert('Patient deleted successfully'); window.location='view_Patients.php';</script>";
    } else {
        echo "<script>alert('Error deleting patient'); history.back();</script>";
    }

    $stmt->close();
}
$con->close();
?>