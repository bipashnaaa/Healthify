<?php
require_once '../../pdo.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $HEALTH_CARE_EMAIL ='healthify.receptionist@gmail.com';
    $patientId = $_POST['patient_id'];
    $patientEmail = $_POST['patient_email'];
    $reportData = json_decode($_POST['report_data'], true);

    // Validate email
    if (empty($patientEmail) || !filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address";
        header("Location: ../views/patient-reports.php?pid=" . $patientId);
        exit();
    }

    // Prepare HTML email content with your exact CSS
    $subject = "Your Medical Report";
    
    $htmlMessage = '
    <!DOCTYPE html>
    <html>
    <head>
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
                font-family: "Segoe UI", sans-serif;
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
        <div class="hospital-report">
            <div class="report-header">
                <h2>🩺 Medical Report</h2>
                <p><strong>Date Issued:</strong> '.htmlspecialchars($reportData['date_issued']).'</p>
            </div>

            <div class="report-section">
                <h3>🧾 Patient Overview</h3>
                <div class="grid-2">
                    <p><strong>Full Name:</strong> '.htmlspecialchars($reportData['patient_name']).'</p>
                    <p><strong>Age:</strong> '.htmlspecialchars($reportData['age']).' years</p>
                    <p><strong>Gender:</strong> '.htmlspecialchars($reportData['gender']).'</p>
                    <p><strong>Contact:</strong> '.htmlspecialchars($reportData['phone']).'</p>
                    <p><strong>Address:</strong> '.htmlspecialchars($reportData['address']).'</p>
                    <p><strong>Email:</strong> '.htmlspecialchars($reportData['email']).'</p>
                </div>
            </div>

            <div class="report-section">
                <h3>📋 Clinical Information</h3>
                <div class="grid-2">
                    <p><strong>Disease:</strong> '.htmlspecialchars($reportData['disease']).'</p>
                    <p><strong>Height:</strong> '.htmlspecialchars($reportData['height']).'</p>
                    <p><strong>Weight:</strong> '.htmlspecialchars($reportData['weight']).' kg</p>
                    <p><strong>Blood Group:</strong> '.htmlspecialchars($reportData['blood_group']).'</p>
                    <p><strong>Allergies:</strong> '.htmlspecialchars($reportData['allergies']).'</p>
                    <p><strong>Chronic Illnesses:</strong> '.htmlspecialchars($reportData['chronic_illnesses']).'</p>
                    <p><strong>Past Surgeries:</strong> '.htmlspecialchars($reportData['past_surgeries']).'</p>
                    <p><strong>Family History:</strong> '.htmlspecialchars($reportData['family_history']).'</p>
                </div>
            </div>

            <div class="report-section">
                <h3>🔍 Diagnosis & Symptoms</h3>
                <p><strong>Symptoms:</strong> '.htmlspecialchars($reportData['symptoms']).'</p>
                <p><strong>Diagnosis:</strong> '.htmlspecialchars($reportData['diagnosis']).'</p>
            </div>

            <div class="report-section">
                <h3>💊 Prescription & Advice</h3>
                <p><strong>Prescription:</strong> '.htmlspecialchars($reportData['prescription']).'</p>
                <p><strong>Prescribed Medicines:</strong> '.htmlspecialchars($reportData['prescribed_medicines']).'</p>
            </div>
        </div>
    </body>
    </html>';

    // Create plain text version for email clients that don't support HTML
    $plainMessage = "Doctor Reports\n";
    $plainMessage .= "🩺 Medical Report\n";
    $plainMessage .= "Date Issued: ".$reportData['date_issued']."\n\n";
    $plainMessage .= "🧾 Patient Overview\n";
    $plainMessage .= "Full Name: ".$reportData['patient_name']."\n";
    $plainMessage .= "Age: ".$reportData['age']." years\n";
    $plainMessage .= "Gender: ".$reportData['gender']."\n";
    $plainMessage .= "Contact: ".$reportData['phone']."\n";
    $plainMessage .= "Address: ".$reportData['address']."\n";
    $plainMessage .= "Email: ".$reportData['email']."\n\n";
    $plainMessage .= "📋 Clinical Information\n";
    $plainMessage .= "Disease: ".$reportData['disease']."\n";
    $plainMessage .= "Height: ".$reportData['height']."\n";
    $plainMessage .= "Weight: ".$reportData['weight']." kg\n";
    $plainMessage .= "Blood Group: ".$reportData['blood_group']."\n";
    $plainMessage .= "Allergies: ".$reportData['allergies']."\n";
    $plainMessage .= "Chronic Illnesses: ".$reportData['chronic_illnesses']."\n";
    $plainMessage .= "Past Surgeries: ".$reportData['past_surgeries']."\n";
    $plainMessage .= "Family History: ".$reportData['family_history']."\n\n";
    $plainMessage .= "🔍 Diagnosis & Symptoms\n";
    $plainMessage .= "Symptoms: ".$reportData['symptoms']."\n";
    $plainMessage .= "Diagnosis: ".$reportData['diagnosis']."\n\n";
    $plainMessage .= "💊 Prescription & Advice\n";
    $plainMessage .= "Prescription: ".$reportData['prescription']."\n";
    $plainMessage .= "Prescribed Medicines: ".$reportData['prescribed_medicines']."\n";

    // Set email headers for multipart message
    $headers = "From: ".$HEALTH_CARE_EMAIL."\r\n";
    $headers .= "Reply-To: ".$HEALTH_CARE_EMAIL."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"boundary123\"\r\n";
    
    // Email body with both plain text and HTML versions
    $emailBody = "--boundary123\r\n";
    $emailBody .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $emailBody .= $plainMessage."\r\n\r\n";
    
    $emailBody .= "--boundary123\r\n";
    $emailBody .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
    $emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $emailBody .= $htmlMessage."\r\n\r\n";
    $emailBody .= "--boundary123--";
    echo  $patientEmail;
    // Send email
    if (mail($patientEmail, "Medical report", $emailBody, $headers)) {
        $_SESSION['success_message_send'] = [
            'message' => "Medical report sent successfully to ".htmlspecialchars($patientEmail),
            'expires_at' => time() + 10
        ];
    } else {
        $_SESSION['error'] = "Failed to send email";
    }

    header("Location: ../doctor/patient-history.php?pid=".$patientId);
    exit();
}