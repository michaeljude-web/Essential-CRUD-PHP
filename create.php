<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create/Add</title>
    <link rel="stylesheet" href="assets/css/create.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Loading Intro -->
    <div id="loadingIntro">
        <div class="spinner"></div>
        <div id="loadingText">Loading
            <span class="dot" style="--i:1;">.</span>
            <span class="dot" style="--i:2;">.</span>
            <span class="dot" style="--i:3;">.</span>
        </div>
    </div>

    <!-- Content -->
    <div id="mainPage" style="display:none;">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h1>GArdee Crud</h1>
            </div>
            <a href="dashboard_2.php" class="folder"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home</a>
            <a href="create.php" class="folder" id="active"><i class="fa-solid fa-folder-plus"></i>&nbsp;Create</a>
            <a href="read.php" class="folder"><i class="fa-solid fa-book"></i>&nbsp;Read</a>
            <a href="update.php" class="folder"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Update</a>
            <a href="delete.php" class="folder"><i class="fa-solid fa-trash"></i>&nbsp;Delete</a>
            <a href="login.php" class="folder"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
        </div>

        <!-- Content to Add Record-->
        <div class="content-container">
            <div class="content" id="mainContent">
                <h2>Add New Record</h2>
                <form id="addRecordForm" method="POST" action="">
                    <div class="input-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname">
                        <span id="firstnameError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname">
                        <span id="lastnameError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                        <span id="emailError" class="error"></span>
                    </div>
                    <button type="submit" class="submit-btn">Add Record</button>
                    <div id="successMessage" class="success-message"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
    
    <?php
    include 'database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $reg_date = date("Y-m-d H:i:s");

        // CHECK IF THE EMAIL ALREADY EXISTS IN THE DATABASE
        $checkSql = "SELECT * FROM myguest WHERE email = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // IF EMAIL ALREADY EXISTS
            echo "<script>
            document.getElementById('successMessage').innerText = 'Error: Email address already exists.';
            document.getElementById('successMessage').style.color = 'red';
        </script>";
        } else {
            // ADD EMAIL SUCCESS
            $insertSql = "INSERT INTO myguest (firstname, lastname, email, reg_date) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("ssss", $firstname, $lastname, $email, $reg_date);

            // ADD NEW RECORD
            if ($insertStmt->execute()) {
                echo "<script>
                document.getElementById('successMessage').innerText = 'Record added successfully.';
                document.getElementById('successMessage').style.color = 'green';
            </script>";
            } else {
                // ADD RECORD FAILED
                echo "<script>
                document.getElementById('successMessage').innerText = 'Error: Could not add record.';
                document.getElementById('successMessage').style.color = 'red';
            </script>";
            }

            $insertStmt->close();
        }

        $stmt->close();
        $conn->close(); 
    }
?>


</body>

</html>