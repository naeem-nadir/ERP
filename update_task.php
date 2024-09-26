<?php
include('Dbcon.php');
include('header.php');

// Check if task_id is provided
if (!isset($_GET['task_id'])) {
    echo "<script>alert('No task ID provided.'); window.location.href='View_Tasks.php';</script>";
    exit;
}

$task_id = $_GET['task_id'];

// Retrieve task details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $query = $pdo->prepare("SELECT * FROM task WHERE task_id = :task_id");
        $query->bindParam(':task_id', $task_id);
        $query->execute();
        $task = $query->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            echo "<script>alert('Task not found.'); window.location.href='View_Tasks.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error fetching task: " . $e->getMessage() . "');</script>";
    }
}

// Handle form submission
if (isset($_POST['updateTask'])) {
    $task_name = $_POST['task_name'];
    $assignee = $_POST['assignee'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    try {
        $query = $pdo->prepare("UPDATE task SET task_name = :task_name, assignee = :assignee, due_date = :due_date, priority = :priority WHERE task_id = :task_id");
        $query->bindParam(':task_id', $task_id);
        $query->bindParam(':task_name', $task_name);
        $query->bindParam(':assignee', $assignee);
        $query->bindParam(':due_date', $due_date);
        $query->bindParam(':priority', $priority);
        $query->execute();

        echo "<script>alert('Task updated successfully'); window.location.href='View_Task.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating task: " . $e->getMessage() . "');</script>";
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
    <h2 class="mb-4">Update Task</h2>
    <form method="POST">
        <div class="form-group">
            <label for="task_name">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="assignee">Assignee</label>
            <input type="text" class="form-control" id="assignee" name="assignee" value="<?php echo htmlspecialchars($task['assignee']); ?>" required>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="priority">Priority</label>
            <select class="form-control" id="priority" name="priority" required>
                <option value="Low" <?php echo ($task['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo ($task['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo ($task['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2" name="updateTask">Update</button>
        <a href="View_Task.php" class="btn btn-light mt-2">Cancel</a>
    </form>
</div>

<?php include('footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
