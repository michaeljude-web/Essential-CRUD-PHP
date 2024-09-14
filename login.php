<?php

include 'database.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: dashboard.php");
    } else {

        $error_message = "Invalid email or password";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <h1>Simple and Efficient Data Management</h1>
            <p>Easily create, view, update, and delete records with a simple and functional interface designed for efficiency.</p>
        </div>
        <div class="right">
            <form method="post" action="">
                <h2 align="center">Login</h2>
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <?php if (!empty($error_message)) { ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>