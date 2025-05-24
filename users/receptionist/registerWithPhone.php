<?php
require_once "../../pdo.php"; // ✅ Corrected path
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'])) {
    $phone = trim($_POST['phone']);

    if (!preg_match("/^9[0-9]{9}$/", $phone)) {
        $_SESSION['error'] = "Invalid phone number format!";
        echo "$phone";
        header("Location: enroll.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM patient_details WHERE phone = ?");
    $stmt->execute([$phone]);
    $patient = $stmt->fetch();

    if ($patient) {
        $_SESSION['id'] = $patient['id'];
                $_SESSION['number'] = $phone;

        $_SESSION['error'] = "This number is already registered!";

        header("Location: enroll.php");
        exit;
    } else {
        $insert = $conn->prepare("INSERT INTO patient_details (phone) VALUES (?)");
        $insert->execute([$phone]);
        $_SESSION['id'] = $conn->lastInsertId();
        $_SESSION['number'] = $phone;

        header("Location: register.php");
        exit;
    }
}
?>
