<?php
include("dbcon.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Step 1: Retrieve the file paths from the database
    $sql = "SELECT profile, files FROM `information` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($profilePicture, $files);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Delete the files from the server
    if ($profilePicture && file_exists('uploads/' . $profilePicture)) {
        unlink('uploads/' . $profilePicture);
    }

    $fileArray = explode(',', $files);
    foreach ($fileArray as $file) {
        $filePath = 'uploads/' . $file;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Step 3: Delete the record from the database
    $sql = "DELETE FROM `information` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 1,
            'message' => 'Record and files deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 0,
            'message' => 'Failed to delete record'
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>
