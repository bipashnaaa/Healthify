<?php
session_start();
include "./header.php";

// 🔹 Fingerprint scan logic
if (isset($_POST['scan'])) {
    try {
        $stmt = $conn->prepare("UPDATE status SET status = :status");
        $stmt->execute(["status" => 2]);
        header("location: view-details.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("location: scan-patient.php");
        exit;
    }
}

// 🔹 Phone number login logic
if (isset($_POST['phone_login'])) {
    $phone = $_POST['phone_login'];

    $stmt = $conn->prepare("SELECT fingerprint_id FROM patient_details WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $patient = $stmt->fetch();

    if ($patient && !empty($patient['fingerprint_id'])) {
        $fid = $patient['fingerprint_id'];

        $conn->query("TRUNCATE TABLE retrieve_fingerprint");
        $insert = $conn->prepare("INSERT INTO retrieve_fingerprint (fid) VALUES (:fid)");
        $insert->execute(['fid' => $fid]);

        header("location: view-details.php");
        exit;
    } else {
        $_SESSION['error'] = "No matching patient found or fingerprint ID missing!";
        header("location: scan-patient.php");
        exit;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Patient</title>
    <?php include "./header.php"; ?>
</head>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();
        ?>

        <div class="body-section">
            <div class="scan-fingerprint">
                <h3>Scan Fingerprint</h3>
                <p>
                    Press the Scan button and ask the patient to press his finger in the sensor,
                    after the sensor has sent the ID, <span style="color: #353535;">press reload</span>.
                </p>

                <?php if (isset($_SESSION['error'])): ?>
                    <p style="color:red; font-weight:bold;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <img src="../img/fingerprint-notfound-icon.png">
                <?php else: ?>
                    <img src="../img/fingerprint-icon.png">
                <?php endif; ?>

                <!-- 🔹 Fingerprint Scan Button -->
                <form action="scan-patient.php" method="POST" style="margin-bottom: 30px;">
                    <button type="submit" name="scan">Scan Fingerprint</button>
                </form>

                <!-- OR Divider -->
                <div style="display: flex; align-items: center; margin: 20px 0;">
                    <hr style="flex: 1; border: none; height: 1px; background-color: #ccc;">
                    <span style="margin: 0 15px; font-weight: bold; color: #555;">OR</span>
                    <hr style="flex: 1; border: none; height: 1px; background-color: #ccc;">
                </div>

                <!-- 🔹 Phone Login -->
                <h3>Login with Phone Number</h3>
                <form method="POST" action="scan-patient.php">
                    <input 
                        type="tel" 
                        name="phone_login" 
                        placeholder="Enter patient's phone number" 
                        required 
                        style="padding: 10px; width: 250px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 10px;"
                    >
                    <br>
                    <button 
                        type="submit" 
                        class="add-button" 
                        style="padding: 10px 25px; font-weight: bold; font-size: 16px; white-space: nowrap; width: auto;"
                    >
                        Login with Phone
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
