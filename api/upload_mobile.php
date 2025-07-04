<?php
    
    $targetDir = "../uploading/";
    $DirUrl = "uploading/";
    if (!isset($_POST['folder']) || empty($_POST['folder'])) {
        echo "NO folder Specified"; // No folder specified
        exit;
    }
 
    $folder = basename($_POST['folder']);
    $targetDir .= $folder . '/';
 
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
 
    if (isset($_FILES['file']['name'])) {
        $filename = basename($_FILES['file']['name']);
        $targetFilePath = $targetDir . $filename;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
 
        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            echo "Invalid file extension"; // Invalid file extension
            exit;
        }
 
        // Validate file size (2MB limit)
        if ($_FILES['file']['size'] > 2 * 1024 * 1024) {
            echo "File too large"; // File too large
            exit;
        }
 
        // Move uploaded file
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            
            // Get the full URL (including domain name)
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domainName = $_SERVER['HTTP_HOST']; // Get the domain
            $fullImageUrl = $protocol . "://" . $domainName . "/" . $DirUrl . $filename;
            error_log("Full URL: ". $fullImageUrl);
            
            echo $filename." Success"; // Success, return the filename
            error_log("Target Directory: " . $targetDir);
            error_log("Target File Path: " . $targetFilePath);
            error_log("File Upload Error: " . print_r($_FILES, true));
            error_log("File Upload Success");
        } else {
            
            // Get the full URL (including domain name)
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domainName = $_SERVER['HTTP_HOST']; // Get the domain
            $fullImageUrl = $protocol . "://" . $domainName . "/" . $DirUrl . $filename;
            error_log("Full URL: ". $fullImageUrl);
            
            echo "Upload failed"; // Upload failed
            error_log("Upload error: " . print_r(error_get_last(), true));
            error_log("File Upload Failed");
        }
    } else {
        echo "No file selected"; // No file selected
    }
?>