<?php 
include('Dbcon.php'); 
include('header.php'); 

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Fetch employee details from the database
    try {
        $query = $pdo->prepare("SELECT * FROM employees WHERE employee_id = :employee_id");
        $query->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $query->execute();
        $employee = $query->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            echo "<script>alert('Employee not found'); location.assign('View_Employees.php');</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error fetching employee details: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('No employee ID provided'); location.assign('View_Employees.php');</script>";
    exit();
}

if (isset($_POST['updateEmployee'])) {
    // Retrieve updated form data
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department_id = $_POST['department_id'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];

    // Prepare and execute the update query
    try {
        $query = $pdo->prepare("UPDATE employees SET user_id = :user_id, first_name = :first_name, last_name = :last_name, address = :address, phone_number = :phone_number, email = :email, position = :position, department_id = :department_id, hire_date = :hire_date, salary = :salary WHERE employee_id = :employee_id");
        $query->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':position', $position, PDO::PARAM_STR);
        $query->bindParam(':department_id', $department_id, PDO::PARAM_STR);
        $query->bindParam(':hire_date', $hire_date, PDO::PARAM_STR);
        $query->bindParam(':salary', $salary, PDO::PARAM_INT);

        // Execute the query
        $query->execute();

        echo "<script>alert('Employee updated successfully'); location.assign('View_Employees.php');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating employee: " . $e->getMessage() . "');</script>";
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
        <h2 class="mb-4">Update Employee</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo htmlspecialchars($employee['user_id']); ?>" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($employee['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($employee['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($employee['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
            </div>
            <div class="form-group">
                <label for="department_id">Department ID</label>
                <input type="text" class="form-control" id="department_id" name="department_id" value="<?php echo htmlspecialchars($employee['department_id']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hire_date">Hire Date</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date" value="<?php echo htmlspecialchars($employee['hire_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" value="<?php echo htmlspecialchars($employee['salary']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2 mt-2" name="updateEmployee">Update</button>
            <a href="View_Employees.php" class="btn btn-light mt-2">Cancel</a>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
