<?php
session_start();
require "./header.php"; // includes DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'])) {
    $phone = $_POST['phone'];

    // Get patient using phone number
    $stmt = $conn->prepare("SELECT fingerprint_id FROM patient_details WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $patient = $stmt->fetch();

    if ($patient && !empty($patient['fingerprint_id'])) {
        $fid = $patient['fingerprint_id'];

        // Clean and insert fingerprint ID to simulate scan
        $conn->query("TRUNCATE TABLE retrieve_fingerprint");
        $insert = $conn->prepare("INSERT INTO retrieve_fingerprint (fid) VALUES (:fid)");
        $insert->execute(['fid' => $fid]);

        header("Location: view-details.php");
        exit;
    } else {
        $_SESSION['error'] = "Patient not found or fingerprint ID missing!";
        header("Location: scan-patient.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: scan-patient.php");
    exit;
}
