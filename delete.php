<?php
include("dbcon.php");
session_start();

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Delete the record from the database
    $sql = "DELETE FROM `information` WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 1, 'message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['status' => 0, 'message' => 'Failed to delete record']);
    }

    $stmt->close();
}
$conn->close();
?>
