<?php 
    @session_start();
    require "./utils.php";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <link rel="stylesheet" type="text/css" href="./css/app.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-image">
            <img src="./img/doctorr.png">
        </div>
        <div class="login-form">
            <div class="form">
            <form method="POST" action="login-process.php">
                <img class="logo" src="./img/healthifyy.png">
                <p class="subtitle"><i>"Your <span style="color: #2663A7;">health  </span style="color: #2663A7;> <span style="color:#2663A7;>matters</span style="color:#2663A7">"</i></p>
                <h3>Login</h3>
                <?=flashMessages()?>
                <input type="email" placeholder="Email" name="email" required> 
                <br>
                <img src="./img/hide-eye-icon.png" class="hide-eye" id="toggle">
                <input type="password" placeholder="Password" name="password" id="pw" required>
                <br>
               
                
               
                <button type="submit">Login</button><br><br>
            </form>
            </div>
        </div>
    </div>

    <script>
    const pwBtn = document.querySelector('#pw')
    document.querySelector('#toggle').addEventListener('click', (event) => {
        pwBtn.type === "password" ? pwBtn.type = "text" : pwBtn.type = "password"
        console.log("clicked");
    })
</script>
</body>

</html>