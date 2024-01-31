<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['upload'] == 'upload') {
        // Database connection
        include 'conn.php';
        $_SESSION['error_msg']= '';
        $_SESSION['success_msg']= '';
        // Handle file upload
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['error_msg'] = "File is not an image.";
            
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $_SESSION['error_msg'] .= "Sorry, file already exists.";
            
            $uploadOk = 0;
        }

        // Check file size (adjust the size according to your requirements)
        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION['error_msg'] .= "Sorry, your file is too large.";
            
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $_SESSION['error_msg'] .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['error_msg'] .= "Sorry, your file was not uploaded.";
            $executeCardAuth = false;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, now insert into database
                $imagePath = $targetFile;  // store this path in the database
                $username = $_SESSION['username'];
                // Insert image path into the database (customize your SQL query)
                $sql = "INSERT INTO images (image_path, username) VALUES (?, ?)";
                $stmt = $connect_db->prepare($sql);
                $stmt->bind_param("ss", $imagePath, $username);
                if ($stmt->execute()) {
                    $_SESSION['success_msg'] .= "Image uploaded and stored in the database.";
                    $executeCardAuth = true;
                    
                } else {
                    echo "Error: " . $sql . "<br>" . $stmt->error;
                }
            } else {
                $_SESSION['error_msg'] .= "Sorry, there was an error uploading your file.";
                

            }
        }

    }
}