<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include "./header.php"; ?>
    <style>
        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {background-color: #f2f2f2;}
        table tr:hover {background-color: #ddd;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #7c7c7c;
            color: white;
        }

        .hospital-report {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.03);
            font-family: 'Segoe UI', sans-serif;
        }

        .report-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .report-header p {
            font-size: 14px;
            color: #444;
        }

        .report-section {
            margin-bottom: 25px;
        }

        .report-section h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #222;
            border-left: 4px solid #3366cc;
            padding-left: 10px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px 20px;
        }

        .report-section p {
            margin: 6px 0;
            font-size: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    displaySidebar($links);
    displayDashboard();
    ?>
    <div class="body-section">
        <h3>First Responder Reports</h3>
        <table>
            <tr>
                <th>Location</th>
                <th>Incident Cause</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
            </tr>
            <?php
             $patientId = $_GET['pid'];

             // ✅ Fetch patient details to show name, age, gender, etc.
             $stmt = $conn->prepare("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patient_details WHERE id = :id");
             $stmt->execute(['id' => $patientId]);
             $patientDetails = $stmt->fetch();
             
             $stmt = $conn->query("SELECT * FROM fresponder_reports WHERE patient_id = $patientId");
             $stmt->execute();
             $fresponder_reports = $stmt->fetchAll();
             

            foreach ($fresponder_reports as $fr) {
                ?>
                <tr>
                    <td><?= $fr['location'] ?? 'N/A' ?></td>
                    <td><?= $fr['incident_cause'] ?? 'N/A' ?></td>
                    <td><?= $fr['description'] ?? 'N/A' ?></td>
                    <td>
                        <?php
                        $image = !empty($fr['image']) && file_exists("../uploads/" . $fr['image'])
                            ? "../uploads/" . $fr['image']
                            : "../img/defUser.jpeg";
                        ?>
                        <img src="<?= $image ?>" alt="Patient Image" width="100" height="100" style="object-fit: cover; border-radius: 10px;">
                    </td>
                    <td><?= htmlspecialchars($fr['created_at'] ?? 'N/A') ?></td>
                </tr>
            <?php } ?>
        </table>

        <br><br>
        <h3>Doctor Reports</h3>

        <?php
        $stmt = $conn->query("SELECT * FROM doctor_reports WHERE patient_id = $patientId");
        $stmt->execute();
        $doctor_reports = $stmt->fetchAll();

        foreach ($doctor_reports as $dr):
        ?>
        <div class="hospital-report">
            <div class="report-header">
                <h2>🩺 Medical Report</h2>
                <p><strong>Date Issued:</strong> <?= $dr['created_at'] ?? 'N/A' ?></p>
            </div>

            <div class="report-section">
                <h3>🧾 Patient Overview</h3>
                <div class="grid-2">
                    <p><strong>Full Name:</strong> <?= $patientDetails['fname'] ?? 'N/A' ?></p>
                    <p><strong>Age:</strong> <?= $patientDetails['age'] ?? 'N/A' ?> years</p>
                    <p><strong>Gender:</strong> <?= $patientDetails['gender'] ?? 'N/A' ?></p>
                    <p><strong>Contact:</strong> <?= $patientDetails['phone'] ?? 'N/A' ?></p>
                    <p><strong>Address:</strong> <?= $patientDetails['address'] ?? 'N/A' ?></p>
                    <p value="Doctor bahadur"><strong>Email:</strong> <?= $patientDetails['email'] ?? 'N/A' ?></p>

                </div>
            </div>
            <?php
// Check if message exists and isn't expired (server-side)
// if (isset($_SESSION['success_message_send'])) {
//     $messageData = $_SESSION['success_message_send'];
//     $currentTime = time();
    
//     if (is_array($messageData) && isset($messageData['timestamp'])) {
//         $messageAge = $currentTime - $messageData['timestamp'];
//         if ($messageAge < 10) { // 10 second window
//             echo '<div class="alert alert-success" id="success-message">' 
//                 . $messageData['message'] 
//                 . '</div>';
//         }
//     } else {
//         // Fallback for simple string messages
//         echo '<div class="alert alert-success" id="success-message">' 
//             . $messageData 
//             . '</div>';
//     }
    
//     unset($_SESSION['success_message_send']);
// }
?>

<script>
    // Client-side hiding after 5 seconds
    if (document.getElementById('success-message')) {
        setTimeout(function() {
            var element = document.getElementById('success-message');
            if (element) {
                element.style.opacity = '0';
                setTimeout(function() {
                    element.style.display = 'none';
                }, 1000); // Fade out duration
            }
        }, 5000); // Display duration
    }
</script>
            <div class="report-section">
                <h3>📋 Clinical Information</h3>
                <div class="grid-2">
                    <p><strong>Disease:</strong> <?= $dr['diseases'] ?? 'N/A' ?></p>
                    <p><strong>Height:</strong> <?= $dr['height'] ?? 'N/A' ?></p>
                    <p><strong>Weight:</strong> <?= $dr['weight'] ?? 'N/A' ?> kg</p>
                    <p><strong>Blood Group:</strong> <?= $dr['blood_group'] ?? 'N/A' ?></p>
                    <p><strong>Allergies:</strong> <?= $dr['allergies'] ?? 'N/A' ?></p>
                    <p><strong>Chronic Illnesses:</strong> <?= $dr['chronic_illnesses'] ?? 'N/A' ?></p>
                    <p><strong>Past Surgeries:</strong> <?= $dr['past_surgeries'] ?? 'N/A' ?></p>
                    <p><strong>Family History:</strong> <?= $dr['family_history'] ?? 'N/A' ?></p>
                </div>
            </div>

            <div class="report-section">
                <h3>🔍 Diagnosis & Symptoms</h3>
                <p><strong>Symptoms:</strong> <?= $dr['symptoms'] ?? 'N/A' ?></p>
                <p><strong>Diagnosis:</strong> <?= $dr['diagnosis'] ?? 'N/A' ?></p>
            </div>

            <div class="report-section">
                <h3>💊 Prescription & Advice</h3>
                <p><strong>Prescription:</strong> <?= $dr['prescriptions'] ?? 'N/A' ?></p>
                <p><strong>Prescribed Medicines:</strong> <?= $dr['prescribed_medicines'] ?? 'N/A' ?></p>
                <div class="send-report-btn">
                <form action="../controllers/send-report.php" method="POST">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>">
    <div class="send-report-btn">
    <form action="../controllers/send-report.php" method="POST">
        <input type="hidden" name="patient_id" value="<?= $patientId ?>">
        <input type="hidden" name="patient_email" value="<?= $patientDetails['email'] ?? '' ?>">
        <input type="hidden" name="report_data" value="<?= htmlspecialchars(json_encode([
            'patient_name' => $patientDetails['fname'] ?? 'N/A',
            'age' => $patientDetails['age'] ?? 'N/A',
            'gender' => $patientDetails['gender'] ?? 'N/A',
            'phone' => $patientDetails['phone'] ?? 'N/A',
            'address' => $patientDetails['address'] ?? 'N/A',
            'email' => $patientDetails['email'] ?? 'N/A',
            'disease' => $dr['diseases'] ?? 'N/A',
            'height' => $dr['height'] ?? 'N/A',
            'weight' => $dr['weight'] ?? 'N/A',
            'blood_group' => $dr['blood_group'] ?? 'N/A',
            'allergies' => $dr['allergies'] ?? 'N/A',
            'chronic_illnesses' => $dr['chronic_illnesses'] ?? 'N/A',
            'past_surgeries' => $dr['past_surgeries'] ?? 'N/A',
            'family_history' => $dr['family_history'] ?? 'N/A',
            'symptoms' => $dr['symptoms'] ?? 'N/A',
            'diagnosis' => $dr['diagnosis'] ?? 'N/A',
            'prescription' => $dr['prescriptions'] ?? 'N/A',
            'prescribed_medicines' => $dr['prescribed_medicines'] ?? 'N/A',
            'date_issued' => $dr['created_at'] ?? 'N/A'
        ]), ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">Send Medical Report to Patient</button>
    </form>
</div>
</div>
</form>


            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>
</body>
</html>