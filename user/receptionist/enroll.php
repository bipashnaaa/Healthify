<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require "./header.php"; ?>
</head>
<?php
    if(isset($_POST, $_POST['enroll'])){
        $stmt = $conn->prepare("UPDATE status SET status =:status");
        $stmt->execute([
            "status" => 1,
        ]);
    
        header("location: register.php");
        exit;
    }
?>
<body>
    <div class="container">
    <?php
        displaySidebar($links);
        displayDashboard();
        ?>
        <div class="body-section">
        <div class="scan-fingerprint">
                <h3>Add Fingerprint</h3>
                <p>Press the Scan button and ask the patient to press his finger in the sensor, after the sensor has sent the ID, <span style="color: #353535;">press reload</span>.</p>
                <?php if (isset($_SESSION['error'])) :
                    flashMessages();
                ?>
                    <img src="../img/fingerprint-notfound-icon.png">
                <?php else : ?>
                    <img src="../img/fingerprint-icon.png">
                <?php endif; ?>

                <form action="enroll.php" method="POST">
    <button type="submit" name="enroll">Add Fingerprint</button>
</form>

<div style="display: flex; align-items: center; margin: 40px 0;">
    <hr style="flex: 1; border: none; height: 1px; background-color: #ccc;">
    <span style="margin: 0 15px; font-weight: bold; color: #333;">OR</span>
    <hr style="flex: 1; border: none; height: 1px; background-color: #ccc;">
</div>

<!-- 📱 Register with Phone -->
<hr style="margin: 40px 0;">

<div style="text-align:center;">
    <h3>  Register with Phone Number</h3>

    <form method="POST" action="registerWithPhone.php">
        <input 
            type="tel" 
            name="phone" 
            placeholder="Enter patient's phone number" 
            required 
            style="padding: 10px; width: 260px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 10px;"
        >
        <br><br>
        <button 
        type="submit" 
    class="add-button" 
    style="padding: 10px 25px; font-weight: bold; font-size: 16px; white-space: nowrap; width: auto;"
        >
            Register with Phone
        </button>
    </form>
</div>

</body>

</html>