<?php
include('Dbcon.php');
include('header.php');

if (isset($_POST['applyLeave'])) {
    // Retrieve form data
    $leave_id = $_POST['leave_id'];
    $employee_id = $_POST['employee_id'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    // Debug: Check if form data is being received
    echo "<script>console.log('Form data received: leave_id=$leave_id, employee_id=$employee_id, leave_type=$leave_type, start_date=$start_date, end_date=$end_date, status=$status');</script>";

    // Prepare and execute the query
    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare the SQL statement
        $query = $pdo->prepare("INSERT INTO employeeleave (leave_id, employee_id, leave_type, start_date, end_date, status) VALUES (:leave_id, :employee_id, :leave_type, :start_date, :end_date, :status)");
        
        // Bind parameters
        $query->bindParam(':leave_id', $leave_id);
        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':leave_type', $leave_type);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':status', $status);

        // Execute the query
        $query->execute();

        // Debug: Check if the query executed successfully
        if ($query->rowCount() > 0) {
            echo "<script>alert('Leave applied successfully');
            location.assign('View_Leave.php');
            </script>";
        } else {
            echo "<script>alert('Error: Leave not applied.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error applying leave: " . $e->getMessage() . "');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
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
            border: 1px solid black;
            background-color: #fff;
        }
        .form-control::placeholder {
            color: #eb1616;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Apply for Leave</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="leave_id">Leave ID</label>
                <input type="text" class="form-control" id="leave_id" name="leave_id" placeholder="Leave ID" required>
            </div>
            <div class="form-group">
                <label for="employee_id">Employee ID</label>
                <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Employee ID" required>
            </div>
            <div class="form-group">
                <label for="leave_type">Leave Type</label>
                <select class="form-control" id="leave_type" name="leave_type" required>
                    <option value="">Select Leave Type</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Maternity Leave">Maternity Leave</option>
                    <option value="Paternity Leave">Paternity Leave</option>
                    <option value="Annual Leave">Annual Leave</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="applyLeave">Submit</button>
            <a href="index.php" class="btn btn-light">Cancel</a>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
