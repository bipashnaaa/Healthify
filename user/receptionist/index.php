<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require './header.php'; ?>
    <style>
         :root {
            --primary-color: #3498db;
            --hover-color: #2980b9;
            --text-color: #333;
            --light-bg: #f9f9f9;
            --border-color: #ddd;
            --success-color: #2ecc71;
        }

      

        .search-bar {
            margin: 20px 0;
            display: flex;
            justify-content: flex-end;
        }

        .search-bar form {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px 0 0 4px;
            font-size: 14px;
        }

        .search-button {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-button:hover {
            background-color: var(--hover-color);
        }

        .search-button img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .body-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .body-section h3 {
            margin-top: 0;
            color: var(--text-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .list-wrapper {
            height: 500px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .list-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
        }

        .list-item:hover {
            background-color: var(--light-bg);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .patient-image {
            border-radius: 50%;
            height: 5rem;
            width: 5rem;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .patient-name {
            width: 15rem;
            font-weight: bold;
            color: var(--text-color);
        }

        .patient-address, .patient-phone {
            color: var(--text-color);
            padding: 0 10px;
        }

        .patient-address {
            width: 18rem;
        }

        .patient-phone {
            width: 10rem;
        }

        .dropdown-toggle {
            padding: 8px 12px;
            font-size: 14px;
            width: auto;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .dropdown-toggle:hover {
            background-color: var(--hover-color);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
            overflow: hidden;
            width: auto;
            min-width: 200px;
            background-color: #fff;
        }

        .dropdown-content.show {
            display: block;
        }

        .doctor-button {
            padding: 10px 15px;
            font-size: 14px;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            background-color: #fff;
            border: none;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            color: var(--text-color);
            transition: background-color 0.2s;
        }

        .doctor-button:hover {
            background-color: var(--light-bg);
        }

        .doctor-button:last-child {
            border-bottom: none;
        }

        .no-data {
            padding: 20px;
            text-align: center;
            color: var(--text-color);
        }

        .alert {
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.2);
            border: 1px solid var(--success-color);
            color: #27ae60;
        }

        @media screen and (max-width: 768px) {
            .list-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .patient-name, .patient-address, .patient-phone {
                width: 100%;
                margin: 5px 0;
            }

            .dropdown {
                margin-top: 10px;
                align-self: flex-end;
            }
        }
        .dropdown-toggle {
            padding: 5px 10px;
            font-size: 14px;
            width: auto;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .doctor-button {
            padding: 8px 12px;
            font-size: 14px;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            cursor: pointer;
            border-radius: 2px;
            color: #333;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 2px;
            overflow: hidden;
            width: auto;
        }

        .dropdown-content button {
            display: block;
            padding: 8px 12px;
            text-align: left;
            border: none;
            background-color: #fff;
            width: 100%;
            cursor: pointer;
            border-radius: 0;
            color: #333;
        }

        .list-wrapper {
            height: 500px;
            overflow-y: auto;
        }

        a.patient-link {
            color: #333;
            text-decoration: underline;
            font-weight: 600;
        }

        a.patient-link:hover {
            color: #2c7;
        }
    </style>
</head>

<?php
$sql = "SELECT * from patient_details";

if (isset($_POST['search'])) {
    $s = $_POST['search'];
    $sql = "SELECT * FROM patient_details WHERE fname LIKE '%$s%'";
}

if (isset($_POST['doctor_id'], $_POST['patient_id'])) {
    $doctorId = $_POST['doctor_id'];
    $patientId = $_POST['patient_id'];
    $stmt = $conn->prepare("INSERT INTO appointments(user_id, patient_id, status) VALUES(:user_id, :patient_id, :status)");
    $stmt->execute([
        'user_id' => $doctorId,
        'patient_id' => $patientId,
        'status' => 'pending'
    ]);
    $_SESSION['success'] = "Doctor assigned";
    header("location: index.php");
    exit;
}
?>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();
        ?>

        <div class="search-bar">
            <form action="index.php" method="POST">
                <input type="text" name="search" size="30" placeholder="Search Patient">
                <button type="submit" class="search-button">
                    <img src="../img/search.png">
                </button>
            </form>
        </div>

        <div class="body-section">
            <h3>Patient List</h3>
            <div class="list-wrapper">
                <?php
                flashMessages();
                $stmt = $conn->query($sql);
                $stmt->execute();
                $patientDetails = $stmt->fetchAll();
                ?>

                <div class="list">
                    <?php
                    if ($stmt->rowCount() > 0) {
                        foreach ($patientDetails as $patient) {
                    ?>
                            <div class="list-item">
                                <div><img style="border-radius: 50%; height: 5rem; width:5rem;" src="../uploads/<?= $patient['dp'] ?? 'defUser.jpeg' ?>"></div>

                                
                                <div style="width: 15rem; font-weight: bold;">
                                 <?= htmlspecialchars($patient['fname']) ?>
                                </div>


                                <div style="width: 18rem;"><?= htmlspecialchars($patient['address']) ?? '-' ?></div>
                                <div style="width: 10rem;"><?= htmlspecialchars($patient['phone']) ?? '-' ?></div>

                                <div class="dropdown">
                                    <button class="dropdown-toggle" onclick="toggleDropdown(this)">Assign Doctor</button>
                                    <div class="dropdown-content">
                                        <?php
                                        $stmt1 = $conn->query("SELECT id, name FROM users WHERE role='DOCTOR'");
                                        $stmt1->execute();
                                        $doctors = $stmt1->fetchAll();
                                        if ($stmt1->rowCount() > 0) {
                                            foreach ($doctors as $doc) {
                                        ?>
                                                <form action="index.php" class="dropdown-form" method="POST">
                                                    <input type='hidden' name="patient_id" value="<?= $patient['id'] ?>">
                                                    <input type='hidden' name="doctor_id" value="<?= $doc['id'] ?>">
                                                    <button type="submit" class="doctor-button"><?= htmlspecialchars($doc['name']) ?></button>
                                                </form>
                                        <?php
                                            }
                                        } else {
                                            echo "No Doctors Available!";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No data found!";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(button) {
            button.nextElementSibling.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-toggle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>

</html>
