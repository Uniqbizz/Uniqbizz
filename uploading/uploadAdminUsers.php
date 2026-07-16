<?php

    // file specifically for Institution file upload. with new upload design.
    // working with add form

    // Check if a file was selected
    if (!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
        echo 3; // No file selected
        exit;
    }

    // Maximum file size (2MB)
    $max_size = 2 * 1024 * 1024;

    // Get upload folder
    $folder = trim($_POST['folder'] ?? '');

    if (empty($folder)) {
        echo 1;
        exit;
    }

    // Create folder if it doesn't exist
    if (!is_dir($folder)) {
        if (!mkdir($folder, 0777, true)) {
            echo 1;
            exit;
        }
    }

    $file = $_FILES['file'];

    $filename = $file['name'];
    $tmp_name = $file['tmp_name'];
    $file_size = $file['size'];

    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $filename_without_extension = pathinfo($filename, PATHINFO_FILENAME);

    // Allowed extensions
    $valid_extensions = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'jfif',
        'pdf'
    ];

    // Check file size
    if ($file_size > $max_size) {
        echo 4; // File exceeds 2MB
        exit;
    }

    // Check extension
    if (!in_array($extension, $valid_extensions)) {
        echo 2; // Invalid extension
        exit;
    }

    // Generate unique filename
    $new_name = uniqid($filename_without_extension . "_", true) . "." . $extension;

    // Destination path
    $destination = $folder . "/" . $new_name;

    // Move uploaded file
    if (move_uploaded_file($tmp_name, $destination)) {

        // Return relative path
        echo $destination;

    } else {

        echo 1; // Upload failed

    }

?>