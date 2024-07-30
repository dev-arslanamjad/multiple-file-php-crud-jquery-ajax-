<?php
include("dbcon.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file uploads and insert data into the database
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Handle profile picture upload
    $profilePicture = $_FILES['profilepicture']['name'];
    $profilePictureTmp = $_FILES['profilepicture']['tmp_name'];
    $profilePicturePath = 'uploads/' . basename($profilePicture);
    move_uploaded_file($profilePictureTmp, $profilePicturePath);

    // Handle documents upload
    $files = [];
    foreach ($_FILES['files']['name'] as $key => $file) {
        $filePath = 'uploads/' . basename($file);
        move_uploaded_file($_FILES['files']['tmp_name'][$key], $filePath);
        $files[] = $file;
    }
    $files = implode(',', $files);

    // Insert into the database
    $sql = "INSERT INTO `information` (name, email, profile, files) VALUES ('$name', '$email', '$profilePicture', '$files')";
    if ($conn->query($sql) === TRUE) {
        // Fetch the new record
        $id = $conn->insert_id;
        $result = $conn->query("SELECT * FROM `information` WHERE ID = $id");
        $newRecord = $result->fetch_assoc();

        echo json_encode([
            'status' => 1,
            'message' => 'Submission added successfully',
            'record' => $newRecord
        ]);
    } else {
        echo json_encode([
            'status' => 0,
            'message' => 'Failed to add submission'
        ]);
    }

    $conn->close();
}
?>
