<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['hero_title']) ? $_POST['hero_title'] : '';
    $subtitle = isset($_POST['hero_subtitle']) ? $_POST['hero_subtitle'] : '';
    
    // Handle File Upload
    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
        $target_dir = "assets/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["hero_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "hero_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["hero_image"]["tmp_name"], $target_file)) {
            // Update image path in database
            $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'hero_image'");
            $stmt->bind_param("s", $target_file);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Update Title and Subtitle
    if ($title !== '') {
        $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'hero_title'");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $stmt->close();
    }

    if ($subtitle !== '') {
        $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'hero_subtitle'");
        $stmt->bind_param("s", $subtitle);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to admin with success message
    header("Location: admin.php?section=homepage&status=success");
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>
