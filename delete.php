<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = getDBConnection();
    $stmt = $conn->prepare("DELETE FROM franchise_applications WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: admin.php?deleted=1");
        exit;
    } else {
        echo "❌ Error deleting record: " . $conn->error;
    }
} else {
    header("Location: admin.php");
    exit;
}
?>