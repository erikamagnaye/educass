<?php
include 'server/server.php';
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Find the user with this token
    $stmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE activation_token = ? AND is_activated = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Activate the user
        $stmt = $conn->prepare("UPDATE student SET is_activated = 1, activation_token = NULL WHERE activation_token = ?");
        $stmt->bind_param("s", $token);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'success';
            $_SESSION['mess'] = 'Your account has been activated successfully. You can now log in.';
        } else {
            $_SESSION['success'] = 'danger';
            $_SESSION['mess'] = 'There was an error activating your account.';
        }
        $stmt->close();
    } else {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'Invalid or expired activation token.';
    }

    $conn->close();
} else {
    $_SESSION['success'] = 'danger';
    $_SESSION['mess'] = 'No activation token provided.';
}

header("Location: login.php");
?>
