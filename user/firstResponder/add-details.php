<?php
session_start();
require "./utils.php";
require "./pdo.php";

// ✅ Only allow emergency staff
if (!isset($_SESSION['userInfo']) || $_SESSION['userInfo']['role'] !== "FRESPONDER") {
    $_SESSION['error'] = "[403] Access Denied!";
    header("location: ../../login.php");
    exit;
}

// ✅ Process injury report submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['injuries'], $_POST['condition'], $_POST['desc'])) {
        $condition = $_POST['condition'];
        $injuries = $_POST['injuries'];
        $desc = validate($_POST['desc']);
        $lastId = "";
        $patientId = $_SESSION['id'] ?? null;

        if (!$patientId) {
            $_SESSION['error'] = "Patient not selected. Please scan fingerprint or login with phone.";
            header("location: scan-patient.php");
            exit;
        }

        // ✅ Handle optional image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $dir = "../uploads/";
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $target_file = $dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['error'] = "[400] File type not allowed!";
                header("location: add-details.php");
                exit;
            }

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $_SESSION['error'] = "[400] File not uploaded!";
                header("location: add-details.php");
                exit;
            }

            $imagePath = $target_file;
        }

        // ✅ Insert into patient_injuries_desc with patient_id
        try {
            $sql = "INSERT INTO patient_injuries_desc(description, status, image, patient_id) 
                    VALUES(:description, :status, :image, :patient_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                "description" => $desc,
                "status" => $condition,
                "image" => $imagePath,
                "patient_id" => $patientId
            ]);
            $lastId = $conn->lastInsertId();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while saving description!";
            header("location: add-details.php");
            exit;
        }

        // ✅ Link selected injuries
        try {
            $sql = "INSERT INTO patient_injuries(injury_id, desc_id) VALUES(:injuryId, :descId)";
            $stmt = $conn->prepare($sql);
            foreach ($injuries as $injury) {
                $stmt->execute([
                    ":injuryId" => $injury,
                    ":descId" => $lastId
                ]);
            }
            $_SESSION['success'] = "Details added successfully!";
            header("location: add-details.php");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error linking injuries!";
            header("location: add-details.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please fill in all details!";
        header("location: add-details.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Patient Details</title>
    <?php include "./header.php"; ?>
</head>
<body>
    <?php include "./navbar.php"; ?>
    <div class="area">
        <div class="content">
            <h2>Add Details</h2>
            <?= flashMessages() ?>

            <?php
            // ✅ Show patient name
            if (isset($_SESSION['id'])) {
                $stmt = $conn->prepare("SELECT fname FROM patient_details WHERE id = ?");
                $stmt->execute([$_SESSION['id']]);
                $patient = $stmt->fetch();
                if ($patient) {
                    echo "<p><strong>Patient:</strong> " . htmlspecialchars($patient['fname']) . "</p>";
                }
            }
            ?>

            <form action="add-details.php" method="post" enctype="multipart/form-data">
                <label for="injury">Injury Type</label><br>
                <?php
                $result = $conn->query("SELECT * FROM injuries");
                $rows = $result->fetchAll();
                foreach ($rows as $row) {
                    echo '<input type="checkbox" name="injuries[]" value="' . $row['id'] . '"> ' . $row['title'] . '<br>';
                }
                ?>
                <br>
                <label for="condition">Condition</label><br>
                <input type="radio" name="condition" value="dead" required> Dead
                <input type="radio" name="condition" value="unconscious" required> Unconscious
                <input type="radio" name="condition" value="conscious" required> Conscious
                <br><br>
                <textarea name="desc" cols="60" rows="8" placeholder="Comments" required></textarea>
                <br><br>
                Image (optional): <input type="file" name="image">
                <br><br>
                <input type="submit" value="Add">
            </form>
        </div>
    </div>
</body>
</html>
