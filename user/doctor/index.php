<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./header.php"; ?>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .alert-success {
            background-color: lightgreen;
            color: darkgreen;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid darkgreen;
        }

        .view-section {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: wrap;
            padding: 2rem;
        }

        .patient-details {
            width: 300px;
            background-color: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
            text-align: center;
            flex-shrink: 0;
        }

        .patient-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            max-height: 300px;
        }

        .details {
            text-align: left;
            font-size: 14px;
            margin-top: 1rem;
            line-height: 1.6;
        }

        .register-details {
            flex-grow: 1;
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
            min-width: 300px;
        }

        .register-details h4 {
            margin-top: 1rem;
        }

        .register-details input {
            width: 100%;
            margin-bottom: 1rem;
            padding: 0.8rem 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .two-columns {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .two-columns input {
            flex: 1;
        }
    </style>
</head>

<?php 
$successMessage = "";
$patientDetails = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $patientId = $_GET['id'];
    $stmt1 = $conn->prepare("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patient_details WHERE id = :patientId");
    $stmt1->execute(['patientId' => $patientId]);
    $patientDetails = $stmt1->fetch();
}

if (isset($_POST['diseases'], $_POST['height'], $_POST['weight'])) {
    $stmt = $conn->prepare("INSERT INTO doctor_reports (patient_id, diseases, allergies, blood_group, chronic_illness, past_surgery, family_history, height, weight, symptoms, diagnosis, prescriptions, prescribed_medicines) 
                            VALUES (:patient_id, :diseases, :allergies, :blood_group, :chronic_illness, :past_surgery, :family_history, :height, :weight, :symptoms, :diagnosis, :prescriptions, :prescribed_medicines)");
    $stmt->execute([
        'patient_id' => $_POST['patient_id'],
        'diseases' => $_POST['diseases'],
        'allergies' => $_POST['allergies'],
        'blood_group' => $_POST['blood_group'],
        'chronic_illness' => $_POST['chronic_illness'],
        'past_surgery' => $_POST['past_surgery'],
        'family_history' => $_POST['family_history'],
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'symptoms' => $_POST['symptoms'],
        'diagnosis' => $_POST['diagnosis'],
        'prescriptions' => $_POST['prescriptions'],
        'prescribed_medicines' => $_POST['prescribed_medicines'],
    ]);
    $successMessage = "Data updated successfully";
}
?>

<body>
<div class="container">
    <?php displaySidebar($links); displayDashboard(); ?>
    <div class="body-section">
        <h3>Your Appointment</h3>
        <?= flashMessages() ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success" id="successMessage"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($patientDetails): ?>
        <div class="view-section">
            <div class="patient-details">
                <h4>Patient Details</h4>
                <?php
                    $defaultImage = "../img/defUser.jpeg";
                    $uploadedImage = "../uploads/" . $patientDetails['dp'];
                    $imagePath = (!empty($patientDetails['dp']) && file_exists($uploadedImage)) ? $uploadedImage : $defaultImage;
                ?>
                <img src="<?= $imagePath ?>" alt="Patient Photo" class="patient-image">

                <div class="details">
                    <p><strong><?= htmlspecialchars($patientDetails['fname']) ?? 'N/A' ?></strong></p>
                    <p><?= htmlspecialchars($patientDetails['address']) ?? 'N/A' ?></p>
                    <p><?= htmlspecialchars($patientDetails['phone']) ?? 'N/A' ?></p>
                    <p><?= htmlspecialchars($patientDetails['age']) ?? 'N/A' ?> years</p>
                    <p><?= htmlspecialchars($patientDetails['gender']) ?? 'N/A' ?></p>
                    <p><a href="patient-history.php?pid=<?= $patientDetails['id'] ?>" style="color: blue;">View History</a></p>
                </div>
            </div>

            <div class="register-details">
                <form method="POST" action="">
                    <input type="hidden" name="patient_id" value="<?= $patientDetails['id'] ?>">

                    <h4>Vital Signs</h4>
                    <div class="two-columns">
                        <input type="text" name="height" placeholder="Height (e.g., 5.5 ft)" required>
                        <input type="text" name="weight" placeholder="Weight (e.g., 60 kg)" required>
                    </div>

                    <h4>Medical History</h4>
                    <input type="text" name="diseases" placeholder="Diseases" required>
                    <input type="text" name="allergies" placeholder="Allergies" required>
                    <input type="text" name="blood_group" placeholder="Blood Group" required>
                    <input type="text" name="chronic_illness" placeholder="Chronic Illnesses">
                    <input type="text" name="past_surgery" placeholder="Past Surgeries or Procedures">
                    <input type="text" name="family_history" placeholder="Family Medical History">

                    <h4>Prescriptions</h4>
                    <div class="two-columns">
                        <input type="text" name="symptoms" placeholder="Symptoms">
                        <input type="text" name="diagnosis" placeholder="Diagnosis">
                    </div>
                    <div class="two-columns">
                        <input type="text" name="prescriptions" placeholder="Prescriptions">
                        <input type="text" name="prescribed_medicines" placeholder="Prescribed Medicines">
                    </div>

                    <button type="submit" class="display-block-center">Create New Patient</button>
                </form>
            </div>
        </div>
        <?php else: ?>
            <p>No patient ID provided!</p>
        <?php endif; ?>
    </div>
</div>

<script>
    setTimeout(() => {
        const msg = document.getElementById('successMessage');
        if (msg) msg.style.display = 'none';
    }, 5000);
</script>
</body>
</html>