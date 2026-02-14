<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $caption = isset($_POST['caption']) ? $_POST['caption'] : '';
    $image_path = '';

    // Handle File Upload
    if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] == 0) {
        $target_dir = "assets/uploads/gallery/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["gallery_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "gallery_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    if ($image_path !== '') {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO gallery (image_path, caption) VALUES (?, ?)");
        $stmt->bind_param("ss", $image_path, $caption);
        
        if ($stmt->execute()) {
            header("Location: admin.php?section=gallery&status=success");
        } else {
            header("Location: admin.php?section=gallery&status=error");
        }
        $stmt->close();
    } else {
        header("Location: admin.php?section=gallery&status=no_image");
    }
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>
