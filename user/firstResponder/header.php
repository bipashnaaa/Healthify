<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../layouts/sidebar.php";
require_once "../layouts/dashboard.php";
require_once "../pdo.php";
require_once "../utils.php";

if (!isset($_SESSION['userInfo']) || $_SESSION['userInfo']['role'] !== "FRESPONDER") {
    $_SESSION['error'] = "[403] Access Denied!";
    unset($_SESSION['userInfo']);
    header("location: ../../login.php");
    exit;
}

$links = [
    [
        'title' => 'dashboard',
        'link' => 'index.php',
    ],
    [
        'title' => 'scan patient',
        'link' => 'scan-patient.php',
    ],
];
?>

<link rel="stylesheet" type="text/css" href="../../css/dashboard.css">
<link rel="stylesheet" type="text/css" href="../../css/sidebar.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<title>FResponder Panel</title>
