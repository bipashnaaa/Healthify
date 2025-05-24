<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./header.php"; ?>
</head>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();

        $patientDetails = null;

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $patientId = $_GET['id'];
            $stmt = $conn->prepare("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patient_details WHERE id = :id");
            $stmt->execute(['id' => $patientId]);
            $patientDetails = $stmt->fetch();
        }
        ?>

        <div class="body-section">
            <h3>Accidental Details</h3>
            <div class="view-section">
                <div class="patient-details">
                    <h4>Patient Details</h4>
                    <div style="position: relative">
                        <?php
                        $defaultImage = "../img/defUser.jpeg";
                        $uploadedImage = "../uploads/" . $patientDetails['dp'];
                        $imagePath = (!empty($patientDetails['dp']) && file_exists($uploadedImage)) ? $uploadedImage : $defaultImage;
                        ?>
                        <img src="<?= $imagePath ?>" style="width: 250px; height: 250px; object-fit: cover; border-radius: 10px;">
                        <p class="details">
                            <span><?= htmlspecialchars($patientDetails['fname']) ?? 'N/A' ?></span><br><br>
                            <span><?= htmlspecialchars($patientDetails['phone']) ?? 'N/A' ?></span><br><br>
                            <span><?= $patientDetails['age'] ?? 'N/A' ?></span><br><br>
                            <span><?= htmlspecialchars($patientDetails['gender']) ?? 'N/A' ?></span><br><br>
                        </p>
                    </div>
                    <hr>
                    <div>
                        <h4>Medical History</h4>
                        <p>Blood Group: <?= htmlspecialchars($patientDetails['blood_group'] ?? 'N/A') ?></p>
                        <p>Allergies: <?= htmlspecialchars($patientDetails['allergies'] ?? 'N/A') ?></p>
                        <p>Prescribed Medicines: <?= htmlspecialchars($patientDetails['prescribed_medicines'] ?? 'N/A') ?></p>
                    </div>
                </div>

                <div class="patient-form">
                    <form method="POST" action="view-details.php" enctype="multipart/form-data">
                        <input type="hidden" name="patient_id" value="<?= $patientDetails['id'] ?>">
                        <input type="text" name="location" placeholder="Location"><br>
                        <input type="text" name="incident_cause" placeholder="Incident Cause"><br>
                        <textarea name="description" placeholder="Description" cols="55" rows="10"></textarea><br>
                        <input type="file" name="image" class="image-upload"><br>
                        <button type="submit">Add Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
