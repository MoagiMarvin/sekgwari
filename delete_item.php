<?php
require_once 'db_config.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    
    if ($type === 'staff') {
        // Fetch image path to delete file
        $stmt = $conn->prepare("SELECT image_path FROM staff WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($row['image_path'] && file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }
        }
        $stmt->close();

        // Delete from DB
        $stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php?section=staff&status=success");
        
    } elseif ($type === 'gallery') {
        // Fetch image path to delete file
        $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($row['image_path'] && file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }
        }
        $stmt->close();

        // Delete from DB
        $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php?section=gallery&status=success");
    }
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>
