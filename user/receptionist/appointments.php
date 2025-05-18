<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Management</title>
    <?php require './header.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --secondary: #95a5a6;
            --light: #f5f5f5;
            --border: #ddd;
            --text: #333;
            --text-light: #7f8c8d;
        }
       
        .container {
            margin: 0 auto;
            /* padding: 20px; */
            /* max-width: 1200px; */
        }
       
        .page-title {
            color: var(--text);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }
       
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
       
        .alert-success {
            background-color: rgba(46, 204, 113, 0.15);
            border-left: 4px solid var(--success);
            color: #27ae60;
        }
       
        .alert-error {
            background-color: rgba(231, 76, 60, 0.15);
            border-left: 4px solid var(--danger);
            color: #c0392b;
        }
       
        .alert-info {
            background-color: rgba(52, 152, 219, 0.15);
            border-left: 4px solid var(--primary);
            color: #2980b9;
        }
       
        .filter-section {
            background-color: var(--light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
       
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-end;
        }
       
        .form-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
            flex-grow: 1;
        }
       
        .form-group label {
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text);
        }
       
        .form-control {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }
       
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
       
        .btn {
            padding: 10px 16px;
            font-weight: 500;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
       
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
       
        .btn:active {
            transform: translateY(1px);
        }
       
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
       
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
       
        .btn-success {
            background-color: var(--success);
            color: white;
        }
       
        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }
       
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
       
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 800px;
        }
       
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
       
        .table th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: var(--text);
            position: sticky;
            top: 0;
        }
       
        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
       
        .status-pending {
            color: var(--warning);
            font-weight: 500;
            padding: 5px 10px;
            background-color: rgba(243, 156, 18, 0.1);
            border-radius: 4px;
            display: inline-block;
        }
       
        .status-confirmed {
            color: var(--success);
            font-weight: 500;
            padding: 5px 10px;
            background-color: rgba(46, 204, 113, 0.1);
            border-radius: 4px;
            display: inline-block;
        }
       
        .status-cancelled {
            color: var(--danger);
            font-weight: 500;
            padding: 5px 10px;
            background-color: rgba(231, 76, 60, 0.1);
            border-radius: 4px;
            display: inline-block;
        }
       
        .action-buttons {
            display: flex;
            gap: 8px;
        }
       
        .action-buttons .btn {
            padding: 8px 12px;
            font-size: 13px;
        }
       
        .no-appointments {
            text-align: center;
            padding: 40px 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            color: var(--text-light);
            border: 1px dashed var(--border);
            margin-bottom: 30px;
        }
       
        .no-appointments i {
            font-size: 48px;
            display: block;
            margin-bottom: 15px;
            color: var(--secondary);
        }
       
        .no-appointments p {
            font-size: 16px;
            margin: 0;
        }
       
        .bulk-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
       
        .bulk-reminder .btn {
            padding: 12px 20px;
        }
       
        @media (max-width: 768px) {
            .form-group {
                width: 100%;
                min-width: unset;
            }
           
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
           
            .table th, .table td {
                padding: 10px 8px;
            }
           
            .bulk-actions {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();
        ?>
       
        <h2 class="page-title">Notification Management</h2>
       
        <?php flashMessages(); ?>
       
        <div class="bulk-actions">
            <div class="bulk-reminder">
                <form method="POST" onsubmit="return confirm('Send reminders to all patients with appointments tomorrow?');">
                    <button type="submit" name="send_tomorrow_reminders" class="btn btn-success">
                        <i class="fas fa-bell"></i> Send Tomorrow's Reminders
                    </button>
                </form>
            </div>
        </div>
       
        <div class="filter-section">
            <form action="appointments.php" method="GET" class="filter-form">
                <div class="form-group">
                    <label for="start_date">From Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                           value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                </div>
               
                <div class="form-group">
                    <label for="end_date">To Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                           value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                </div>
               
                <div class="form-group">
                    <label for="doctor">Doctor</label>
                    <select id="doctor" name="doctor" class="form-control">
                        <option value="">All Doctors</option>
                        <?php
                        $stmt = $conn->query("SELECT id, name FROM users WHERE role='DOCTOR'");
                        $doctors = $stmt->fetchAll();
                       
                        foreach($doctors as $doctor) {
                            $selected = (isset($_GET['doctor']) && $_GET['doctor'] == $doctor['id']) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($doctor['id'])."' $selected>".htmlspecialchars($doctor['name'])."</option>";
                        }
                        ?>
                    </select>
                </div>
               
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="confirmed" <?php echo (isset($_GET['status']) && $_GET['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="appointments.php" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </form>
        </div>
       
        <?php
        // Build the base query
        $sql = "SELECT a.id, a.created_at as appointment_date, a.status,
                p.fname as patient_name, p.phone as patient_phone, p.dob as patient_dob, p.email as patient_email,
                u.name as doctor_name, u.email as doctor_email
                FROM appointments a
                JOIN patient_details p ON a.patient_id = p.id
                JOIN users u ON a.user_id = u.id";
       
        // Add conditions based on filters
        $conditions = [];
        $params = [];
       
        if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
            $conditions[] = "DATE(a.created_at) >= :start_date";
            $params['start_date'] = $_GET['start_date'];
        }
       
        if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
            $conditions[] = "DATE(a.created_at) <= :end_date";
            $params['end_date'] = $_GET['end_date'];
        }
       
        if (isset($_GET['doctor']) && !empty($_GET['doctor'])) {
            $conditions[] = "a.user_id = :doctor_id";
            $params['doctor_id'] = $_GET['doctor'];
        }
       
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $conditions[] = "a.status = :status";
            $params['status'] = $_GET['status'];
        }
       
        // Combine conditions
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
       
        // Add sorting
        $sql .= " ORDER BY a.created_at DESC";
       
        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $appointments = $stmt->fetchAll();
       
        // Handle appointment cancellation
        if (isset($_POST['cancel_appointment'])) {
            $appointmentId = $_POST['appointment_id'];
            $stmt = $conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = :id");
            $stmt->execute(['id' => $appointmentId]);
            $_SESSION['success'] = "Appointment cancelled successfully";
            header("Location: appointments.php");
            exit;
        }
       
        // Handle sending reminder for single appointment
        if (isset($_POST['send_reminder'])) {
            $appointmentId = $_POST['appointment_id'];
           
            $stmt = $conn->prepare("
                SELECT
                    a.created_at AS appointment_date,
                    a.status,
                    u.name AS doctor_name,
                    u.email AS doctor_email,
                    p.fname AS patient_name,
                    p.email AS patient_email,
                    p.phone AS patient_phone
                FROM appointments a
                JOIN users u ON a.user_id = u.id
                JOIN patient_details p ON a.patient_id = p.id
                WHERE a.id = :id
            ");
            $stmt->execute(['id' => $appointmentId]);
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if ($appointment) {
                $date = date('M d, Y h:i A', strtotime($appointment['appointment_date']));
                $patient_email = $appointment['patient_email'];
                $patient_name = $appointment['patient_name'];
                $doctor_email = $appointment['doctor_email'];
                $doctor_name = $appointment['doctor_name'];
               
                // Email Headers
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= "From: Healthify Reminder <no-reply@yourclinic.com>\r\n";
               
                // Patient Email
                $patient_message = "
                    <html>
                    <body>
                        <p>Dear <b>".htmlspecialchars($patient_name)."</b>,</p>
                        <p>This is a reminder for your appointment on <b>$date</b> with Dr. <b>".htmlspecialchars($doctor_name)."</b>.</p>
                        <p>Please arrive 15 minutes before your scheduled time.</p>
                        <p>Thank you,<br>Healthify Team</p>
                    </body>
                    </html>
                ";
               
                // Doctor Email
                $doctor_message = "
                    <html>
                    <body>
                        <p>Dear Dr. <b>".htmlspecialchars($doctor_name)."</b>,</p>
                        <p>This is a reminder for your appointment with <b>".htmlspecialchars($patient_name)."</b> on <b>$date</b>.</p>
                        <p>Patient Contact: ".htmlspecialchars($appointment['patient_phone'])."</p>
                        <p>Thank you,<br>Healthify Team</p>
                    </body>
                    </html>
                ";
               
                // Send emails
                $patient_sent = mail($patient_email, "Appointment Reminder", $patient_message, $headers);
                $doctor_sent = mail($doctor_email, "Appointment Reminder", $doctor_message, $headers);
               
                if ($patient_sent && $doctor_sent) {
                    $_SESSION['success'] = "Reminder sent successfully to both doctor and patient";
                } else {
                    $_SESSION['error'] = "Failed to send reminder to ".(!$patient_sent ? "patient" : "").(!$patient_sent && !$doctor_sent ? " and " : "").(!$doctor_sent ? "doctor" : "");
                }
            } else {
                $_SESSION['error'] = "Appointment not found";
            }
           
            // header("Location: appointments.php");
            echo "<script>window.location.href='redirect_to_appointment.php';</script>";

            exit;
        }
       
        // Handle sending tomorrow's reminders
        if (isset($_POST['send_tomorrow_reminders'])) {
            date_default_timezone_set('Asia/Kathmandu');
       
            // Set tomorrow's date
           
            try {
                $tomorrow = date('Y-m-d', strtotime('+1 day'));
                // Use prepared statement to safely pass the variable into the query
                $query = "SELECT a.id, a.created_at AS appointment_date, u.name AS doctor_name, u.email AS doctor_email, p.fname AS patient_name, p.email AS patient_email, p.phone AS patient_phone
                FROM appointments a
                JOIN users u ON a.user_id = u.id
                JOIN patient_details p ON a.patient_id = p.id
                WHERE DATE(a.created_at) = '" . $tomorrow . "'
                AND a.status != 'cancelled'";
     
     
                echo $query;
                // Prepare the query
                $stmt = $conn->prepare($query);
                // Bind the parameter
                // $stmt->bindParam(1, $tomorrow, PDO::PARAM_STR);

                // echo '';
                // Execute the query
                $stmt->execute();
       
                // Fetch all results
                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "Count : ";
                echo count($appointments);
       
                echo "Appointments created for Tomorrow (" . $tomorrow . "): " . count($appointments) . "<br>";
       
                if (count($appointments) > 0) {
                    $success_count = 0;
                    $error_count = 0;
       
                    foreach ($appointments as $appointment) {
                        $date = date('M d, Y h:i A', strtotime($appointment['appointment_date']));
                        $patient_email = $appointment['patient_email'];
                        $patient_name = $appointment['patient_name'];
                        $doctor_email = $appointment['doctor_email'];
                        $doctor_name = $appointment['doctor_name'];
       
                        // Email Headers
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $headers .= "From: Healthify Reminder <no-reply@yourclinic.com>\r\n";
       
                        // Patient Email
                        $patient_message = "
                            <html>
                            <body>
                                <p>Dear <b>" . htmlspecialchars($patient_name) . "</b>,</p>
                                <p>This is a reminder for your appointment tomorrow (<b>$date</b>) with Dr. <b>" . htmlspecialchars($doctor_name) . "</b>.</p>
                                <p>Please arrive 15 minutes before your scheduled time.</p>
                                <p>Thank you,<br>Healthify Team</p>
                            </body>
                            </html>
                        ";
       
                        // Doctor Email
                        $doctor_message = "
                            <html>
                            <body>
                                <p>Dear Dr. <b>" . htmlspecialchars($doctor_name) . "</b>,</p>
                                <p>This is a reminder for your appointment tomorrow (<b>$date</b>) with <b>" . htmlspecialchars($patient_name) . "</b>.</p>
                                <p>Patient Contact: " . htmlspecialchars($appointment['patient_phone']) . "</p>
                                <p>Thank you,<br>Healthify Team</p>
                            </body>
                            </html>
                        ";
       
                        // Send emails
                        $patient_sent = mail($patient_email, "Appointment Reminder for Tomorrow", $patient_message, $headers);
                        $doctor_sent = mail($doctor_email, "Appointment Reminder for Tomorrow", $doctor_message, $headers);
       
                        if ($patient_sent && $doctor_sent) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    }
       
                    echo "Success Count: $success_count<br>";
                    echo "Error Count: $error_count<br>";
       
                    if ($success_count > 0) {
                        $_SESSION['success'] = "Successfully sent reminders for $success_count appointment(s)";
                    }
                    if ($error_count > 0) {
                        $_SESSION['error'] = "Failed to send reminders for $error_count appointment(s)";
                    }
                } else {
                    $_SESSION['info'] = "No appointments found for tomorrow";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            echo "<script>window.location.href='appointments.php';</script>";
    exit();
            exit;
        }
       
        ?>
       
        <?php if (count($appointments) > 0): ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Appointment Date</th>
                            <th>Patient</th>
                            <th>Patient DOB</th>
                            <th>Patient Phone</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo date('M d, Y h:i A', strtotime($appointment['appointment_date'])); ?></td>
                                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($appointment['patient_dob'])); ?></td>
                                <td><?php echo htmlspecialchars($appointment['patient_phone']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                <td>
                                    <span class="status-<?php echo htmlspecialchars($appointment['status']); ?>">
                                        <?php echo ucfirst(htmlspecialchars($appointment['status'])); ?>
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <?php if ($appointment['status'] != 'cancelled'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                            <button type="submit" name="send_reminder" class="btn btn-success" title="Send Reminder">
                                                <i class="fas fa-bell"></i> Remind
                                            </button>
                                        </form>
                                       
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                            <button type="submit" name="cancel_appointment" class="btn btn-danger" title="Cancel Appointment" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">No actions available</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-appointments">
                <i class="fas fa-calendar-times"></i>
                <p>No appointments found matching your criteria.</p>
                <p style="margin-top: 10px; font-size: 14px;">Try adjusting your filters or adding new appointments.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>