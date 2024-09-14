<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read/view</title>
    <link rel="stylesheet" href="assets/css/read.css">
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
        <!-- Sidebar with Folders -->
        <div class="sidebar">
            <div class="logo">
                <h1>GArdee Crud</h1>
            </div>
            <a href="dashboard_2.php" class="folder"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home</a>
            <a href="create.php" class="folder"><i class="fa-solid fa-folder-plus"></i>&nbsp;Create</a>
            <a href="read.php" class="folder" id="active"><i class="fa-solid fa-book"></i>&nbsp;Read</a>
            <a href="update.php" class="folder"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Update</a>
            <a href="delete.php" class="folder"><i class="fa-solid fa-trash"></i>&nbsp;Delete</a>
            <a href="login.php" class="folder"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
        </div>

        <!-- Content -->
        <div class="content-container">
            <div class="content" id="mainContent">

                <?php
                
                include 'database.php';
                
                $search = isset($_POST['search']) ? $_POST['search'] : '';
                $searchTerm = "%$search%";
                $limit = 6;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                $sql = $conn->prepare("SELECT firstname, lastname, email, reg_date 
                       FROM myguest 
                       WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? 
                       ORDER BY firstname ASC 
                       LIMIT ?, ?");
                $sql->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $start, $limit);
                $sql->execute();
                $result = $sql->get_result();

                // DISPLAY SEARCH
                echo '<form method="POST" class="search">
        <input type="text" name="search" placeholder="Search name or email" value="' . htmlspecialchars($search) . '" required>
        <button type="submit">Search</button>
      </form>';

                // DISPLAY TABLE
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Registration Date</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["reg_date"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    // PAGINATION
                    $totalRecordsResult = $conn->prepare("SELECT COUNT(*) as count FROM myguest WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ?");
                    $totalRecordsResult->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                    $totalRecordsResult->execute();
                    $totalRecords = $totalRecordsResult->get_result()->fetch_assoc()['count'];
                    $totalPages = ceil($totalRecords / $limit);

                    echo "<div class='pagination-container'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $active = $i == $page ? 'active' : '';
                        echo "<a href='?page=$i" . ($search ? "&search=" . urlencode($search) : "") . "' class='pagination-link $active'>$i</a> ";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No records found.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js">
    </script>
</body>

</html>