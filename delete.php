<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="assets/css/delete.css">
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

    <!-- Page Content -->
    <div id="mainPage" style="display:none;">
        <!-- Sidebar with Folders -->
        <div class="sidebar">
            <div class="logo">
                <h1>GArdee Crud</h1>
            </div>
            <a href="dashboard_2.php" class="folder"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home</a>
            <a href="create.php" class="folder"><i class="fa-solid fa-folder-plus"></i>&nbsp;Create</a>
            <a href="read.php" class="folder"><i class="fa-solid fa-book"></i>&nbsp;Read</a>
            <a href="update.php" class="folder"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Update</a>
            <a href="delete.php" id="active" class="folder"><i class="fa-solid fa-trash"></i>&nbsp;Delete</a>
            <a href="login.php" class="folder"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
        </div>

        <!-- Content -->
        <div class="content-container">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name or email" required>
                <button type="submit">Search</button>
            </form>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'database.php';

                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];

                            // PREPARE DELETE
                            $stmt = $conn->prepare("DELETE FROM myguest WHERE id = ?");
                            $stmt->bind_param("i", $id);

                            if ($stmt->execute()) {
                                echo "";
                            } else {
                                echo "<p style='color: red;'>Error deleting record: " . $conn->error . "</p>";
                            }

                            $stmt->close();
                        }

                        // SEARCH FUNCTION
                        $search = isset($_POST['search']) ? $_POST['search'] : '';
                        $searchTerm = "%" . $search . "%";

                        // PAGINATION SETUP
                        $limit = 8;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $start = ($page - 1) * $limit;

                        $sql = $conn->prepare("SELECT id, firstname, lastname, email, reg_date 
                           FROM myguest 
                           WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? 
                           ORDER BY firstname ASC 
                           LIMIT ?, ?");
                        $sql->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $start, $limit);
                        $sql->execute();
                        $result = $sql->get_result();

                        // DISPLAY RECORDS
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                    <td>" . htmlspecialchars($row["firstname"]) . "</td>
                    <td>" . htmlspecialchars($row["lastname"]) . "</td>
                    <td>" . htmlspecialchars($row["email"]) . "</td>
                    <td>" . htmlspecialchars($row["reg_date"]) . "</td>
                    <td>
                        <a href='?id=" . $row["id"] . "&page=$page' onclick='return confirm(\"Are you sure you want to delete this record?\")'>
                            <i class='fas fa-trash delete-icon'></i>
                        </a>
                    </td>
                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }

                        // PAGINATION
                        $totalRecordsResult = $conn->query("SELECT COUNT(*) as count 
                                        FROM myguest 
                                        WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%'");
                        $totalRecords = $totalRecordsResult->fetch_assoc()['count'];
                        $totalPages = ceil($totalRecords / $limit);
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $active = $i == $page ? 'active' : '';
                    echo "<a href='?page=$i" . ($search ? "&search=" . urlencode($search) : "") . "' class='pagination-link $active'>$i</a> ";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>

</body>

</html>