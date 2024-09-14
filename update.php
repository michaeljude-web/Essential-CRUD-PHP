<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="assets/css/update.css">
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
            <a href="update.php" class="folder" id="active"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Update</a>
            <a href="delete.php" class="folder"><i class="fa-solid fa-trash"></i>&nbsp;Delete</a>
            <a href="login.php" class="folder"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
        </div>

        <!-- Content -->
        <div class="content-container">
            <form method="POST" class="search">
                <input type="text" name="search" placeholder="Search name or email" required>
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

                        if (isset($_POST['update'])) {
                            $id = $_POST['id'];
                            $firstname = $_POST['firstname'];
                            $lastname = $_POST['lastname'];
                            $email = $_POST['email'];

                            // CHECK FOR DUPLICATE EMAIL
                            $emailCheck = $conn->prepare("SELECT id FROM myguest WHERE email = ? AND id != ?");
                            $emailCheck->bind_param("si", $email, $id);
                            $emailCheck->execute();
                            $emailResult = $emailCheck->get_result();

                            if ($emailResult->num_rows > 0) {
                                echo "<p class='error'>Email already exists. Please choose a different email.</p>";
                            } else {
                                $stmt = $conn->prepare("UPDATE myguest SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
                                $stmt->bind_param("sssi", $firstname, $lastname, $email, $id);

                                if ($stmt->execute()) {
                                    echo "<p style='color: green;'></p>";
                                } else {
                                    echo "<p class='error'>Error updating record: " . $conn->error . "</p>";
                                }

                                $stmt->close();
                            }
                        }

                        // SEARCH FUNCTION
                        $search = isset($_POST['search']) ? $_POST['search'] : '';
                        $searchTerm = "%" . $search . "%";

                        //PAGINATION SETUP
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
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['reg_date']) . "</td>";
                                echo "<td><i class='fa fa-solid fa-user-pen update-icon' data-id='" . $row['id'] . "' data-firstname='" . $row['firstname'] . "' data-lastname='" . $row['lastname'] . "' data-email='" . $row['email'] . "'></i></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }

                        // PAGINATION
                        $totalRecordsResult = $conn->query("SELECT COUNT(*) as count FROM myguest WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%'");
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

    <!-- Modal sa Update -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Record</h2>
            <form method="post" id="updateForm">
                <input type="hidden" name="id" id="modal-id">
                <label for="modal-firstname">First Name:</label>
                <input type="text" name="firstname" id="modal-firstname" required><br>
                <label for="modal-lastname">Last Name:&nbsp;</label>
                <input type="text" name="lastname" id="modal-lastname" required><br>
                <label for="modal-email" style="padding-left: 7px;">Email: &nbsp; &nbsp; &nbsp; &nbsp; </label>
                <input type="email" name="email" id="modal-email" required>
                <button type="submit" name="update" class="update-btn">Update</button>
            </form>
            <p id="errorMessage" class="error"></p>
        </div>
    </div>

    <!--JavaScript-->
    <script src="assets/js/script.js" defer></script>
</body>

</html>