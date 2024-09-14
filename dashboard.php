<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
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

    <!-- Main Page -->
    <div id="mainPage" style="display:none;">

        <!-- Sidebar  -->
        <div class="sidebar">
            <div class="logo">
                <h1>Gardee Crud</h1>
            </div>
            <a href="dashboard_2.php" class="folder"><i class="fa fa-home"></i>&nbsp;Home</a>
            <a href="create.php" class="folder"><i class="fa-solid fa-folder-plus"></i>&nbsp;Create</a>
            <a href="read.php" class="folder"><i class="fa-solid fa-book"></i>&nbsp;Read</a>
            <a href="update.php" class="folder"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Update</a>
            <a href="delete.php" class="folder"><i class="fa-solid fa-trash"></i>&nbsp;Delete</a>
            <a href="login.php" class="folder"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
        </div>

        <!-- Content -->
        <div class="content-container">
            <div class="content" id="mainContent">
                <h1>Welcome</h1>
                <p>Feel free to explore the CRUD application l've developed.</p>
                <video class="home-vid" width="350" autoplay muted loop disablePictureInPicture controlslist="nodownload nofullscreen noremoteplayback">
                    <source src="assets/video/vid1.mp4">
                </video>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>

</html>