<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require './header.php'; ?>
</head>

<?php
if (isset($_POST['redirect'])) {
    header("location: view-details.php");
    exit;
}

$fid = null;
$patientDetails = null;

// ✅ Determine patient from fingerprint or phone login
if (isset($_SESSION['from_phone']) && $_SESSION['from_phone'] === true && isset($_SESSION['id'])) {
    $stmt = $conn->prepare("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patient_details WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['id']]);
    $patientDetails = $stmt->fetch();
    unset($_SESSION['from_phone']);
} else {
    $stmt = $conn->query("SELECT fid FROM retrieve_fingerprint");
    $fid = $stmt->fetchColumn();
    if ($fid) {
        $stmt = $conn->prepare("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patient_details WHERE fingerprint_id = :fid");
        $stmt->execute(['fid' => $fid]);
        $patientDetails = $stmt->fetch();
    }
}

if (isset($_POST['location'], $_POST['description'], $_POST['incident_cause'])) {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $incident_cause = $_POST['incident_cause'];
    $patientId = $_POST['patient_id'] ?? null;
    $user_id = $_SESSION['userInfo']['id'];
    $image = "";

    if (isset($_FILES['image'])) {
        $dir = "../uploads/";
        if (!is_dir($dir)) mkdir($dir, 0777);

        $target_file = $dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $_SESSION['error'] = "[400] File type not allowed!";
            header("location: view-details.php");
            exit;
        }

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_SESSION['error'] = "[400] File not uploaded!";
            header("location: view-details.php");
            exit;
        }

        $image = $_FILES['image']['name'];
    } else {
        $image = "defUser.jpeg";
    }

    try {
        $stmt = $conn->prepare("INSERT INTO fresponder_reports(location, incident_cause, description, image, patient_id, user_id) 
            VALUES(:location, :incident_cause, :description, :image, :patient_id, :user_id)");
        $stmt->execute([
            'location' => $location,
            'incident_cause' => $incident_cause,
            'description' => $description,
            'image' => $image,
            'patient_id' => $patientId,
            'user_id' => $user_id,
        ]);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("location: view-details.php");
        exit;
    }
}
?>

<body>
<div class="container">
    <?php displaySidebar($links); displayDashboard(); ?>
    <div class="body-section">
        <h3>Accidental Details</h3>
        <?php flashMessages(); ?>

        <?php if (!$patientDetails): ?>
            <div class="fingerprint-registering">
                <h3>Fetching Details...</h3>
                <img src="../img/spinner.gif">
                <p>Kindly refresh the page after a few minutes!</p>
                <form method="POST" action="view-details.php">
                    <button class="submit" name="redirect">Reload</button>
                </form>
            </div>
        <?php else: ?>
            <div class="view-section">
                <div class="patient-details">
                    <h4>Patient Details</h4>
                    <div style="position: relative">
                        <?php
                        $defaultImage = "../img/defUser.jpeg";
                        $uploadedImage = "../uploads/" . $patientDetails['dp'];
                        $imagePath = (!empty($patientDetails['dp']) && file_exists($uploadedImage)) ? $uploadedImage : $defaultImage;
                        ?>
                        <img src="<?= $imagePath ?>" style="width: 200px; border-radius: 10px;">
                        <p class="details">
                            <span><?= $patientDetails['fname'] ?></span><br><br>
                            <span><?= $patientDetails['address'] ?></span><br><br>
                            <span><?= $patientDetails['phone'] ?></span><br><br>
                            <span><?= $patientDetails['age'] ?></span><br><br>
                            <span><?= $patientDetails['gender'] ?></span><br><br>
                        </p>
                    </div>
                    <hr>
                    <div>
                        <?php
                        $id = $patientDetails['id'];
                        $stmt1 = $conn->prepare("SELECT * FROM doctor_reports WHERE patient_id = :id ORDER BY created_at DESC");
                        $stmt1->execute(['id' => $id]);
                        $medicalDetails = $stmt1->fetch();
                        ?>
                       <h4>Medical History</h4>
                        <p><b>Blood Group</b>: <?= $medicalDetails['blood_group'] ?? 'N/A' ?></p>
                        <p><b>Allergies</b>: <?= $medicalDetails['allergies'] ?? 'N/A' ?></p>
                        <p><b>Prescribed Medicines</b>: <?= $medicalDetails['prescribed_medicines'] ?? 'N/A' ?></p>
                    </div>
                </div>
               <!--  <form action="../email/send-report.php" method="POST">
                <input type="hidden" name="patient_id" value="<?= $patientDetails['id'] ?>">
                 <button type="submit" class="btn btn-primary" style="margin-top: 1rem; background-color: #4285f4; color: white; padding: 10px 20px; border: none; border-radius: 6px;">
                   Send Medical Report to Patient
                  </button>
                 </form>  -->


                <div class="patient-form">
                    <form method="POST" action="view-details.php" enctype="multipart/form-data">
                        <input type="hidden" name="patient_id" value="<?= $patientDetails['id'] ?>">
                        <input type="text" name="location" placeholder="Location" required><br>
                        <input type="text" name="incident_cause" placeholder="Incident Cause" required><br>
                        <textarea name="description" placeholder="Description" cols="55" rows="10" required></textarea><br>
                        <input type="file" name="image" class="image-upload"><br>
                        <button type="submit">Add Details</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
