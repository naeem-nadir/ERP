<?php
include('Dbcon.php');
include('header.php');

try {
    // Check if PDO is set and connected
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Fetch all attendance records from the database
    $query = $pdo->query("SELECT * FROM attendance");
    $attendances = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching attendance records: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

// Handle delete request
if (isset($_POST['deleteAttendance'])) {
    $attendance_id = $_POST['attendance_id'];
    try {
        $query = $pdo->prepare("DELETE FROM attendance WHERE attendance_id = :attendance_id");
        $query->bindParam(':attendance_id', $attendance_id);
        $query->execute();
        echo "<script>alert('Attendance record deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting attendance record: " . $e->getMessage() . "');</script>";
    }
}

// Handle update request
if (isset($_POST['updateAttendance'])) {
    $attendance_id = $_POST['attendance_id'];
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];
    $check_in_time = $_POST['check_in_time'];
    $check_out_time = $_POST['check_out_time'];
    $status = $_POST['status'];

    try {
        $query = $pdo->prepare("UPDATE attendance SET employee_id = :employee_id, date = :date, check_in_time = :check_in_time, check_out_time = :check_out_time, status = :status WHERE attendance_id = :attendance_id");
        $query->bindParam(':attendance_id', $attendance_id);
        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':date', $date);
        $query->bindParam(':check_in_time', $check_in_time);
        $query->bindParam(':check_out_time', $check_out_time);
        $query->bindParam(':status', $status);
        $query->execute();
        echo "<script>alert('Attendance record updated successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating attendance record: " . $e->getMessage() . "');</script>";
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
        <h2 class="mb-4">View Attendance Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Attendance ID</th>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendances)) : ?>
                    <?php foreach ($attendances as $attendance) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($attendance['attendance_id']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['date']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['check_in_time']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['check_out_time']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['status']); ?></td>
                            <td>
                                <a href="update_attendance.php?attendance_id=<?php echo urlencode($attendance['attendance_id']); ?>" class="btn btn-primary">Update</a>

                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="attendance_id" value="<?php echo htmlspecialchars($attendance['attendance_id']); ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteAttendance">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No attendance records found.</td>
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
