<?php
session_start();
// header.php

function getAppointmentsWithPatients($conn) {
    // Check if session user ID is set
    if (!isset($_SESSION['userId'])) {
        echo "<tr><td colspan='8'>No user logged in</td></tr>";
        return;
    }

    $userId = $_SESSION['userId'];

    // SQL query to join appointments and patient_details tables with a condition on user_id
    // and order the results by appointment_date in descending order
    $sql = "SELECT appointments.id AS appointment_id, appointments.user_id, appointments.status, appointments.created_at AS appointment_date,
                       patient_details.fname AS patient_name, patient_details.id AS patient_id, patient_details.phone AS patient_phone, patient_details.email AS patient_email
            FROM appointments
            INNER JOIN patient_details ON appointments.patient_id = patient_details.id
            WHERE appointments.user_id = :userId
            ORDER BY appointments.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // Output data of each row
        foreach ($result as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["user_id"]) . "</td>
                    <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                    <td>" . htmlspecialchars($row["patient_name"]) . "</td>
                    <td>" . htmlspecialchars($row["patient_phone"]) . "</td>
                    <td>" . htmlspecialchars($row["patient_email"]) . "</td>
                    <td>" . htmlspecialchars($row["status"]) . "</td>
                    <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                    <td><a href='index.php?id=" . htmlspecialchars($row["patient_id"]) . "' class='view-button'>View</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No results</td></tr>";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./header.php"; ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .view-button {
            background-color: #4caf50;
            border-radius: 10px;
            text-align: center;
            padding: 3px 5px;
            color: white;
            text-decoration: none;
        }

        .view-button:hover {
            background-color: #87CEEB;
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
            <h3>Your Appointments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Doctor ID</th>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Patient Phone</th>
                        <th>Patient Email</th>
                        <th>Status</th>
                        <th>Appointment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php getAppointmentsWithPatients($conn); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
