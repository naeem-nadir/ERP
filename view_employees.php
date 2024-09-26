<?php 
include('Dbcon.php'); 
include('header.php'); 

// Initialize employees array
$employees = [];

try {
    $query = $pdo->prepare("SELECT * FROM employees");
    $query->execute();
    $employees = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching employees: " . $e->getMessage() . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
   
    
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
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Employee List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Department ID</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th >Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($employees) > 0): ?>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['address']); ?></td>
                        <td><?php echo htmlspecialchars($employee['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($employee['email']); ?></td>
                        <td><?php echo htmlspecialchars($employee['position']); ?></td>
                        <td><?php echo htmlspecialchars($employee['department_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['hire_date']); ?></td>
                        <td><?php echo htmlspecialchars($employee['salary']); ?></td>
                        <td class= "bttt">
                            <a href="update_employees.php?employee_id=<?php echo htmlspecialchars($employee['employee_id']); ?>" class="btn btn-primary">Update</a>
                            <a href="delete_employee.php?employee_id=<?php echo htmlspecialchars($employee['employee_id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No employees found.</td>
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
