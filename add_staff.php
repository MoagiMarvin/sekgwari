<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $qualification = isset($_POST['qualification']) ? $_POST['qualification'] : '';
    $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    
    $image_path = '';

    // Handle File Upload
    if (isset($_FILES['staff_image']) && $_FILES['staff_image']['error'] == 0) {
        $target_dir = "assets/uploads/staff/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["staff_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "staff_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["staff_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO staff (name, position, qualification, grade, message, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $position, $qualification, $grade, $message, $image_path);
    
    if ($stmt->execute()) {
        header("Location: admin.html?section=staff&status=success");
    } else {
        header("Location: admin.html?section=staff&status=error");
    }
    
    $stmt->close();
    exit();
} else {
    header("Location: admin.html");
    exit();
}
?>
