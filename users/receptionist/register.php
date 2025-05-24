<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require "./header.php"; ?>
    
</head>
<?php
require_once "./header.php"; // contains session_start, DB, sidebar, dashboard

// 🔒 Ensure fingerprint was scanned
$stmt = $conn->query("SELECT status FROM status LIMIT 1");
$statusRow = $stmt->fetch();



if (!$statusRow || $statusRow['status'] != 1) {
    $_SESSION['error'] = "Please scan fingerprint first!";
    header("Location: enroll.php");
    exit;
}


// ✅ Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fname'])) {
    // var_dump($_POST);
    // var_dump($_SESSION);
    // die;
    $fname = $_POST['fname'];
    $phone =  $_SESSION['number'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $ephone = $_POST['ephone'];
    $relation = $_POST['relation'];
    $gender = $_POST['gender'];
    $image = "defUser.jpeg"; // default

    $phone_pattern = "/^9[0-9]{9}$/";

    if (!preg_match($phone_pattern, $phone) || !preg_match($phone_pattern, $ephone)) {
        $_SESSION['error'] = "Invalid contact number format!";
        header("Location: register.php");
        exit;
    }

 if (isset($_FILES['dp']) && $_FILES['dp']['error'] == 0) {
    $filename = basename($_FILES["dp"]["name"]);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $_SESSION['error'] = "Unsupported file type!";
        header("Location: register.php");
        exit;
    }

    // First upload location: relative to script
    $dir1 = __DIR__ . "/../../uploads/";
    if (!is_dir($dir1)) mkdir($dir1, 0777, true);
    $target_file1 = $dir1 . $filename;

    // Second upload location: server root
    $dir2 = __DIR__ . "/uploads/";
    if (!is_dir($dir2)) mkdir($dir2, 0777, true);
    $target_file2 = $dir2 . $filename;

    // Upload to first location
    if (!move_uploaded_file($_FILES["dp"]["tmp_name"], $target_file1)) {
        $_SESSION['error'] = "Failed to upload image!";
        header("Location: register.php");
        exit;
    }

    // Copy to second location
    if (!copy($target_file1, $target_file2)) {
        $_SESSION['error'] = "Failed to copy image to public folder!";
        header("Location: register.php");
        exit;
    }

    // Success
    $image = $filename;
}


    try {
        $stmt = $conn->prepare("UPDATE patient_details SET fname=?, address=?, email=?, phone=?, ephone=?, relation=?, gender=?, dob=?, dp=? WHERE id=?");
        $stmt->execute([$fname, $address, $email, $phone, $ephone, $relation, $gender, $dob, $image, $_SESSION['id']]);

        $conn->query("UPDATE status SET status = 0");
        unset($_SESSION['id']);

        $_SESSION['success'] = "Patient registered successfully!";
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error!";
        header("Location: register.php");
        exit;
    }
}

// 🔁 Reload button handler
if (isset($_POST['redirect'])) {
    header("Location: register.php");
    exit;
}

// ✅ Load Patient Data if ID is in session
$emptyData = null;
$rowCount = 0;
if ($statusRow && $statusRow['status'] == 1 && isset($_SESSION['id'])) {
    $stmt = $conn->prepare("SELECT * FROM patient_details WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $emptyData = $stmt->fetch();
    $rowCount = $emptyData ? 1 : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Patient</title>
</head>
<body>
    <div class="container">
        <?php displaySidebar($links); ?>
        <?php displayDashboard(); ?>
        <div class="body-section">
            <?= flashMessages() ?>
            <?php if ($rowCount > 0): ?>
                <div class="register-details">
                    <h3>Patient Form</h3>
                    <form method="POST" action="register.php" enctype="multipart/form-data">
                        <input type="text" name="fname" placeholder="Full Name" required>
                        <input type="text" name="address" placeholder="Address" required>
                        <!-- <input type="number" value="  <?php echo $_SESSION['number']; ?>" name="phone" placeholder="Phone Number" required> -->
                        <input type="number" value="<?php echo isset($_SESSION['number']) ? $_SESSION['number'] : ''; ?>" placeholder="Phone Number" readonly>
                        <input type="email" name="email" placeholder="Email Address" required>

                        <div class="two-columns">
                            <input type="number" name="ephone" placeholder="Emergency Contact Number" required>
                            <select name="relation" required>
                                <option disabled selected>--Relation--</option>
                                <option value="parents">Parents</option>
                                <option value="spouse">Spouse</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                            </select>
                        </div>

                        <div class="two-columns">
                            <select name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                            DOB: <input type="date" name="dob" required>
                        </div>

                        <input class="image-upload" type="file" name="dp" required>
                        <button type="submit" class="display-block-center">Create New Patient</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="fingerprint-registering">
                    <h3>Fingerprint registering...</h3>
                    <img src="../img/spinner.gif" alt="Loading...">
                    <p>Please refresh after scanning the fingerprint.</p>
                    <form method="POST" action="register.php">
                        <button class="submit" name="redirect">Reload</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
