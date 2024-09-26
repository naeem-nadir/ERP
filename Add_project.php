<?php
include('Dbcon.php');
include('header.php');

// Fetch users for the dropdown
$userQuery = $pdo->query("SELECT user_id, username FROM users");
$users = $userQuery->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['addProject'])) {
    // Retrieve form data
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];

    // Debug: Check if form data is being received
    echo "<script>console.log('Form data received: project_name=$project_name, description=$description, start_date=$start_date, end_date=$end_date, status=$status, assigned_to=$assigned_to');</script>";

    // Prepare and execute the query
    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare the SQL statement
        $query = $pdo->prepare("INSERT INTO projects (project_name, description, start_date, end_date, status, assigned_to) VALUES (:project_name, :description, :start_date, :end_date, :status, :assigned_to)");
        
        // Bind parameters
        $query->bindParam(':project_name', $project_name);
        $query->bindParam(':description', $description);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':status', $status);
        $query->bindParam(':assigned_to', $assigned_to);

        // Execute the query
        $query->execute();

        // Debug: Check if the query executed successfully
        if ($query->rowCount() > 0) {
            echo "<script>alert('Project added successfully');
            location.assign('view_project.php');
            </script>";
        } else {
            echo "<script>alert('Error: Project not added.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error adding project: " . $e->getMessage() . "');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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
        <h2 class="mb-4">Add Project</h2>
        <form method="POST">
            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Project Name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option>Not Started</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="assigned_to">Assigned To</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <option value="" disabled selected>Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['user_id']); ?>">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2" name="addProject">Submit</button>
            <button type="button" class="btn btn-light" onclick="window.history.back();">Cancel</button>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
