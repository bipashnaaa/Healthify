<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./header.php"; ?>
    <style>
        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: lightgrey;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        displaySidebar($links);
        displayDashboard();

        $stmt = $conn->query("SELECT user_id, created_at FROM appointments");
        $stmt->execute();
        $doctorLogs = $stmt->fetchAll();

        $stmt = $conn->query("SELECT user_id, created_at FROM fresponder_reports");
        $stmt->execute();
        $fresponderLogs = $stmt->fetchAll();
        ?>
        <div class="body-section">
            <h3>Logs</h3>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Created At</th>
                </tr>

                <!-- Doctor Logs -->
                <?php foreach ($doctorLogs as $dr) : 
                    $stmt = $conn->query("SELECT name FROM users WHERE id = " . $dr['user_id']);
                    $name = $stmt->fetch();
                    if (!$name) continue;
                ?>
                <tr>
                    <td><?= $dr['user_id'] ?></td>
                    <td><?= $name[0] ?></td>
                    <td><?= $dr['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>

                <!-- First Responder Logs -->
                <?php foreach ($fresponderLogs as $fr) : 
                    $stmt = $conn->query("SELECT name FROM users WHERE id = " . $fr['user_id']);
                    $name = $stmt->fetch();
                    if (!$name) continue;
                ?>
                <tr>
                    <td><?= $fr['user_id'] ?></td>
                    <td><?= $name[0] ?></td>
                    <td><?= $fr['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>
</body>

</html>
