<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include "./header.php"; ?>
</head>
<?php
if (isset($_POST, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    $name = validate($_POST['name']);
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //  Validation starts here
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("location: adduser.php");
        exit;
    }

    if (strlen($pass) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long!";
        header("location: adduser.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT into users(name, email, password, role) VALUES(:name, :email, :pass, :role)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'pass' => password_hash($pass, PASSWORD_DEFAULT),
            'role' => $_POST['role'],
        ]);
        $_SESSION['success'] = "User added!";
        header("location: users.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Some error occured!";
        header("location: adduser.php");
        exit;
    }
}
?>


<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();
        ?>

        <div class="body-section">
            <h3>Add User</h3>
            <div class="add-user">
                <form action="adduser.php" method="POST">
                    <?=flashMessages()?>
                    <input type="text" name="name" placeholder="User Name" required> <br>
                    <input type="email" name="email" placeholder="Email" required> <br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <select name="role" required>
                        <option selected disabled>--Select role--</option>
                        <option value="FRESPONDER">Emergency Staff</option>
                        <option value="DOCTOR">Doctor</option>
                        <option value="RECEPTIONIST">Receptionist</option>
                    </select><br><br>
                    <button type="submit" class="add-button">Add</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>