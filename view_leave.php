<?php
include('header.php');
include('Dbcon.php'); // Ensure the database connection is included

try {
    // Check if PDO is set and connected
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Fetch all leave applications from the database
    $query = $pdo->query("SELECT * FROM employeeleave");
    $leaves = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching leave applications: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

// Handle delete request
if (isset($_POST['deleteLeave'])) {
    $leave_id = $_POST['leave_id'];
    try {
        $query = $pdo->prepare("DELETE FROM employeeleave WHERE leave_id = :leave_id");
        $query->bindParam(':leave_id', $leave_id);
        $query->execute();
        echo "<script>alert('Leave application deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting leave application: " . $e->getMessage() . "');</script>";
    }
}

// Handle update request
if (isset($_POST['updateLeave'])) {
    $leave_id = $_POST['leave_id'];
    $employee_id = $_POST['employee_id'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    try {
        $query = $pdo->prepare("UPDATE employeeleavez SET employee_id = :employee_id, leave_type = :leave_type, start_date = :start_date, end_date = :end_date, status = :status WHERE leave_id = :leave_id");
        $query->bindParam(':leave_id', $leave_id);
        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':leave_type', $leave_type);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':status', $status);
        $query->execute();
        echo "<script>alert('Leave application updated successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating leave application: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Applications</title>
    <!-- Bootstrap CSS -->
            
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
           max-width: 95%;
            margin: 50px auto;
            background-color: #191c24;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
       
        .bttt{
            display: flex;
            gap: 10px;
        }
       
        .btn-update, .btn-delete {
            margin-right: 5px;
            display: flex;
            gap: 10px;
        }
        td{
            color: #eb1616;
        }
        .action{
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">View Leave Applications</h2>
        <table>
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaves)) : ?>
                    <?php foreach ($leaves as $leave) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($leave['leave_id']); ?></td>
                            <td><?php echo htmlspecialchars($leave['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                            <td><?php echo htmlspecialchars($leave['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($leave['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($leave['status']); ?></td>
                            <td class= "action">
                                <a href="update_leave.php?leave_id=<?php echo urlencode($leave['leave_id']); ?>" class="btn btn-primary ">Update</a>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($leave['leave_id']); ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteLeave">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No leave applications found.</td>
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
