<?php
session_start();
require "./pdo.php";
require "./utils.php";

if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['email'], $_POST['password'])) {
    header("location: login.php");
    exit;
}

$email = validate($_POST['email']);
$pass = validate($_POST['password']);

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['userInfo'] = $user;
    $_SESSION['userId'] = $user['id'];
    // Redirect based on user role
    switch ($user['role']) {
        case "ADMIN":
            header("location: users/admin/index.php");
            break;
        case "FRESPONDER":
            header("location: users/firstResponder/index.php");
            break;
        case "RECEPTIONIST":
            header("location: users/receptionist/index.php");
            break;
        case "PATIENT":
            header("location: users/patient/index.php");
            break;
        case "DOCTOR":
            header("location: users/doctor/patient-list.php");
            break;
        default:
            $_SESSION['error'] = "[403] Access Denied!";
            header("location: login.php");
    }
} else {
    $_SESSION['error'] = "Invalid email or password combination!";
    header("location: login.php");
    exit;
}
?>