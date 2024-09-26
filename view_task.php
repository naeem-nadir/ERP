<?php
include('Dbcon.php');
include('header.php');

try {
    // Check if PDO is set and connected
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Fetch all tasks from the database
    $query = $pdo->query("SELECT * FROM task");
    $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching tasks: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

// Handle delete request
if (isset($_POST['deleteTask'])) {
    $task_id = $_POST['task_id'];
    try {
        $query = $pdo->prepare("DELETE FROM task WHERE task_id = :task_id");
        $query->bindParam(':task_id', $task_id);
        $query->execute();
        echo "<script>alert('Task deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting task: " . $e->getMessage() . "');</script>";
    }
}

// Handle update request
if (isset($_POST['updateTask'])) {
    $task_id = $_POST['task_id'];
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
        echo "<script>alert('Task updated successfully'); location.reload();</script>";
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
        max-width: 800px;
        margin: 50px auto;
        background-color: #191c24;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .action {
        display: flex;
        gap: 10px;
    }
    h2 {
        color: #eb1616;
    }
    td {
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
</style>

</head>
<body>
<div class="container">
    <h2>View Tasks</h2>
    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Assignee</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tasks)) : ?>
                <?php foreach ($tasks as $task) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                        <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                        <td><?php echo htmlspecialchars($task['assignee']); ?></td>
                        <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                        <td><?php echo htmlspecialchars($task['priority']); ?></td>
                        <td class="action">
                            <a href="update_task.php?task_id=<?php echo urlencode($task['task_id']); ?>" class="btn btn-primary">Update</a>

                            <a href="delete_task.php?task_id=<?php echo urlencode($task['task_id']); ?>" class="btn btn-danger">Delete</a>

                          
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No tasks found.</td>
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
