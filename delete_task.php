<?php
include('Dbcon.php');

// Check if task_id is provided
if (!isset($_POST['task_id'])) {
    echo "<script>alert('No task ID provided.'); window.location.href='View_Task.php';</script>";
    exit;
}

$task_id = $_POST['task_id'];

try {
    // Prepare and execute the deletion query
    $query = $pdo->prepare("DELETE FROM task WHERE task_id = :task_id");
    $query->bindParam(':task_id', $task_id);
    $query->execute();

    // Check if the query executed successfully
    if ($query->rowCount() > 0) {
        echo "<script>alert('Task deleted successfully'); window.location.href='View_Task.php';</script>";
    } else {
        echo "<script>alert('Error: Task not found or already deleted.'); window.location.href='View_Task.php';</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Error deleting task: " . $e->getMessage() . "'); window.location.href='View_Task.php';</script>";
}
?>
