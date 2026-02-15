<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $event_date = isset($_POST['event_date']) && !empty($_POST['event_date']) ? $_POST['event_date'] : null;
    
    $image_path = '';

    // Handle File Upload
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] == 0) {
        $target_dir = "assets/uploads/news/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "news_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO news_events (title, content, event_date, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $event_date, $image_path);
    
    if ($stmt->execute()) {
        header("Location: admin.php?section=news&status=success");
    } else {
        header("Location: admin.php?section=news&status=error");
    }
    
    $stmt->close();
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>
