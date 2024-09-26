<?php
include('Dbcon.php');
include('header.php');

if (isset($_POST['submitAttendance'])) {
    // Retrieve form data
    $department_id = $_POST['department_id'];
    $date = $_POST['date'];
    $attendance = $_POST['attendance'];

    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Insert attendance records into the database
        $pdo->beginTransaction();
        foreach ($attendance as $employee_id => $status) {
            $query = $pdo->prepare("INSERT INTO attendance (employee_id, department_id, date, status) VALUES (:employee_id, :department_id, :date, :status)");
            $query->bindParam(':employee_id', $employee_id);
            $query->bindParam(':department_id', $department_id);
            $query->bindParam(':date', $date);
            $query->bindParam(':status', $status);
            $query->execute();
        }
        $pdo->commit();
        echo "<script>alert('Attendance submitted successfully'); location.assign('view_attendance.php');</script>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<script>alert('Error submitting attendance: " . $e->getMessage() . "');</script>";
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
    <title>Mark Attendance</title>
  
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
    <h2 class="mb-4">Mark Attendance</h2>
    <form method="GET" action="">
        <div class="form-group">
            <label for="department_id">Select Department</label>
            <select class="form-control" id="department_id" name="department_id" required>
                <?php
                // Fetch existing departments from the departments table
                try {
                    $dept_query = $pdo->query("SELECT department_id, department_name FROM departments");
                    while ($dept = $dept_query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($dept['department_id']) . "'>" . htmlspecialchars($dept['department_name']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error loading departments</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Select Department</button>
    </form>

    <?php
    if (isset($_GET['department_id'])) {
        $department_id = $_GET['department_id'];
        // Fetch employees in the selected department
        try {
            $employee_query = $pdo->prepare("SELECT employee_id, first_name, last_name FROM employees WHERE department_id = :department_id");
            $employee_query->bindParam(':department_id', $department_id);
            $employee_query->execute();
            $employees = $employee_query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<script>alert('Error loading employees: " . $e->getMessage() . "');</script>";
        }
        ?>

        <h2 class="mt-5">Department: <?php echo htmlspecialchars($_GET['department_id']); ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department_id); ?>">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['first_name'] . " " . $employee['last_name']); ?></td>
                        <td>
                            <input type="hidden" name="attendance[<?php echo htmlspecialchars($employee['employee_id']); ?>]" value="absent">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="attendance[<?php echo htmlspecialchars($employee['employee_id']); ?>]" id="attendance_<?php echo htmlspecialchars($employee['employee_id']); ?>" value="present">
                                <label class="form-check-label" for="attendance_<?php echo htmlspecialchars($employee['employee_id']); ?>">Present</label>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary" name="submitAttendance">Submit Attendance</button>
        </form>
    <?php
    }
    ?>

</div>

<?php include('footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
