<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = [
        'school_phone',
        'school_email',
        'school_address',
        'operating_hours',
        'school_tagline'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->bind_param("ss", $value, $field);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: admin.php?section=contacts&status=success");
    exit();
} else {
    header("Location: admin.php");
    exit();
}
?>
