<?php
include('Dbcon.php');
include('header.php');

try {
    // Check if PDO is set and connected
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Fetch all projects from the database
    $query = $pdo->query("SELECT * FROM projects");
    $projects = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching projects: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

// Handle delete request
if (isset($_POST['deleteProject'])) {
    $project_id = $_POST['project_id'];
    try {
        $query = $pdo->prepare("DELETE FROM projects WHERE project_id = :project_id");
        $query->bindParam(':project_id', $project_id);
        $query->execute();
        echo "<script>alert('Project deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting project: " . $e->getMessage() . "');</script>";
    }
}

// Handle update request
if (isset($_POST['updateProject'])) {
    $project_id = $_POST['project_id'];
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];

    try {
        $query = $pdo->prepare("UPDATE projects SET project_name = :project_name, description = :description, start_date = :start_date, end_date = :end_date, status = :status, assigned_to = :assigned_to WHERE project_id = :project_id");
        $query->bindParam(':project_id', $project_id);
        $query->bindParam(':project_name', $project_name);
        $query->bindParam(':description', $description);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':status', $status);
        $query->bindParam(':assigned_to', $assigned_to);
        $query->execute();
        echo "<script>alert('Project updated successfully'); location.reload();</script>";
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
            max-width: 800px;
            margin: 50px auto;
            background-color: #191c24;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .action{
        display: flex;
            gap: 10px;
        }
        h2{
            color:#eb1616 ;
        }
        td{
            color:#eb1616 ;  
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
    </style>

</head>
<body>
<div class="container">
    <h2>View Projects</h2>
    <table>
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($projects)) : ?>
                <?php foreach ($projects as $project) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['project_id']); ?></td>
                        <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                        <td><?php echo htmlspecialchars($project['description']); ?></td>
                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['status']); ?></td>
                        <td><?php echo htmlspecialchars($project['assigned_to']); ?></td>
                        <td class= "action">
                            <a href="update_project.php?project_id=<?php echo urlencode($project['project_id']); ?>" class="btn btn-primary">Update</a>

                            <form method="POST" action="view_projects.php" style="display:inline;">
                                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['project_id']); ?>">
                                <button type="submit" class="btn btn-danger" name="deleteProject">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No projects found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
