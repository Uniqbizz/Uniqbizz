<?php

    // if($_FILES['file']['name'] != ''){

    //     $folder = $_POST['folder'];

    //     $filename = $_FILES['file']['name'];

    //     $extension = pathinfo($filename, PATHINFO_EXTENSION);

    //     $valid_extensions = array("jpg","jpeg","png","gif","jfif");

    //     if(in_array($extension, $valid_extensions)){

    //         $new_name = rand() ."." . $extension;

    //         $path = $folder ."/". $new_name;

    //         if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){

    //             // echo '<img src="'.$path.'"/><br/><br/>

    //             // <button data-path="'.$path.'" id="delete_btn">Delete</button>';

    //             echo $path;
    //             // echo $folder;
                
    //         }else{
    //             echo 1; //File Upload Failed
    //         }
    //     }else{
    //         echo 2; //File validation Failed
    //     }
    // }else{
    //     echo 3; //File Not selected
    // }

    
    if($_FILES['file']['name'] != ''){

        // Set the file size limit to 2MB (2 * 1024 * 1024 bytes)
        $max_size = 2 * 1024 * 1024; 

        // Get the folder and file details
        $folder = $_POST['folder'];

        $filename = $_FILES['file']['name'];
        $file_info = pathinfo($filename);
        $filename_without_extension = $file_info['filename']; // "dummy-profile-image"

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Valid extensions
        $valid_extensions = array("jpg", "PNG", "jpeg", "png", "gif", "jfif");

        // Check if the file size exceeds the limit
        if ($_FILES['file']['size'] > $max_size) {
            echo 4; // File size exceeds 2MB
        } else {
            // Check if the file extension is valid
            if (in_array($extension, $valid_extensions)) {

                // Generate a new random file name
                $new_name = $filename_without_extension."_".rand() . "." . $extension;

                // Set the file upload path
                $path = $folder . "/" . $new_name;

                // Try to move the uploaded file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {

                    // If successful, return the file path
                    echo $path;

                } else {
                    echo 1; // File upload failed
                }
            } else {
                echo 2; // File validation failed
            }
        }

    } else {
        echo 3; // No file selected
    }



?>