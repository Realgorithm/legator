<?php
// Check if the form is submitted
if (($_POST['hiddenInput']) === 'upload') {
    // Database connection
    include 'conn.php';
    // Handle file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust the size according to your requirements)
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, now insert into database
            $imagePath = $targetFile;  // store this path in the database

            // Insert image path into the database (customize your SQL query)
            $sql = "INSERT INTO images (image_path) VALUES (?)";
            $stmt = $connect_db->prepare($sql);
            $stmt->bind_param("s", $imagePath);
            if ($stmt->execute()) {
                echo "Image uploaded and stored in the database.";
                header("Location: ../index2.php?page=deposit_final&success=1");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error;
                header("Location: ../index2.php?page=deposit_final&error=1");
                exit();

            }
        } else {
            echo "Sorry, there was an error uploading your file.";
            // echo "sorry for incovinience please re enter the transaction id and send" . $error . "";
            header("Location: ../index2.php?page=deposit_final&error=1");
            exit();
        }
    }

    // Close the database connection
    $connect_db->close();
}
?>