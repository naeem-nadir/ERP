<?php
include('Dbcon.php');
include('header.php');

// Check if project_id is provided in the URL
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    // Fetch project details from the database
    try {
        $query = $pdo->prepare("SELECT * FROM projects WHERE project_id = :project_id");
        $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query->execute();
        $project = $query->fetch(PDO::FETCH_ASSOC);

        if (!$project) {
            echo "<script>alert('Project not found'); location.assign('view_project.php');</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error fetching project details: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('No project ID provided'); location.assign('view_project.php');</script>";
    exit();
}

// Fetch users for the dropdown
$userQuery = $pdo->query("SELECT user_id, username FROM users");
$users = $userQuery->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['updateProject'])) {
    // Retrieve updated form data
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];

    // Prepare and execute the update query
    try {
        $query = $pdo->prepare("UPDATE projects SET project_name = :project_name, description = :description, start_date = :start_date, end_date = :end_date, status = :status, assigned_to = :assigned_to WHERE project_id = :project_id");
        $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query->bindParam(':project_name', $project_name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':assigned_to', $assigned_to, PDO::PARAM_INT);

        // Execute the query
        $query->execute();

        echo "<script>alert('Project updated successfully'); location.assign('view_project.php');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating project: " . $e->getMessage() . "');</script>";
    }
}
?>

<style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .container {
            flex: 1;
            max-width: 80%;
            margin: 30px auto;
            background-color: #191c24;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        h2 {
            color: #eb1616;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: right;
            padding: 10px;
            position: fixed;
            bottom: 0;
            right: 0;
            left: auto;
            width: 100%;
        }


        .form-control {
            border:1px solid black;
            background-color: #fff;
        }
       .form-control::placeholder{
        color: #eb1616;
       }
    </style>

</head>

<body>
    <div class="container">
        <h2 class="mb-4">Update Project</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo htmlspecialchars($project['project_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($project['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($project['start_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($project['end_date']); ?>">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option <?php if ($project['status'] == 'Not Started') echo 'selected'; ?>>Not Started</option>
                    <option <?php if ($project['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option <?php if ($project['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="assigned_to">Assigned To</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <option value="" disabled>Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['user_id']); ?>" <?php if ($project['assigned_to'] == $user['user_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2 mt-2" name="updateProject">Update</button>
            <a href="view_project.php" class="btn btn-light mt-2">Cancel</a>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
