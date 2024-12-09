<?php
include_once("connections/connection.php");

$con = connection();

if (isset($_GET['ID'])) {
    $member_id = $_GET['ID'];

    // Prepare DELETE query
    $sql = "DELETE FROM memberslist WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Member successfully deleted.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error: Could not delete member.'); window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}

$con->close();
?>
