<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./header.php"; ?>
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();

        // ✅ Fetch counts from database
        $patients = $conn->query("SELECT COUNT(*) FROM patient_details")->fetchColumn();
        $doctors = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'DOCTOR'")->fetchColumn();
        $receptionists = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'RECEPTIONIST'")->fetchColumn();
        $responders = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'FRESPONDER'")->fetchColumn();
        $allUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
        ?>

        <div class="body-section">
            <h2 style="margin-bottom: 20px;">Admin Dashboard Overview</h2>

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">

                <div style="flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; background: #f9f9f9; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3>Total Patients</h3>
                    <p style="font-size: 24px; font-weight: bold;"><?= $patients ?></p>
                </div>

                <div style="flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; background: #e7f3ff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3>Total Doctors</h3>
                    <p style="font-size: 24px; font-weight: bold;"><?= $doctors ?></p>
                </div>

                <div style="flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; background: #fff3cd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3>Total Receptionists</h3>
                    <p style="font-size: 24px; font-weight: bold;"><?= $receptionists ?></p>
                </div>

                <div style="flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; background: #d4edda; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3>First Responders</h3>
                    <p style="font-size: 24px; font-weight: bold;"><?= $responders ?></p>
                </div>

                <div style="flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; background: #f0e2ff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3>Total Users</h3>
                    <p style="font-size: 24px; font-weight: bold;"><?= $allUsers ?></p>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
