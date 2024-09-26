<?php 
include('Dbcon.php'); 
include('header.php'); 

if (isset($_POST['addEmployee'])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department_id = $_POST['department_id']; // Updated to department_id
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];

    // Debug: Check if form data is being received
    echo "<script>console.log('Form data received: first_name=$first_name, last_name=$last_name, address=$address, phone_number=$phone_number, email=$email, position=$position, department_id=$department_id, hire_date=$hire_date, salary=$salary');</script>";

    // Prepare and execute the query
    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare the SQL statement
        $query = $pdo->prepare("INSERT INTO employees (first_name, last_name, address, phone_number, email, position, department_id, hire_date, salary) VALUES (:first_name, :last_name, :address, :phone_number, :email, :position, :department_id, :hire_date, :salary)"); // Updated to department_id
        
        // Bind parameters
        $query->bindParam(':first_name', $first_name);
        $query->bindParam(':last_name', $last_name);
        $query->bindParam(':address', $address);
        $query->bindParam(':phone_number', $phone_number);
        $query->bindParam(':email', $email);
        $query->bindParam(':position', $position);
        $query->bindParam(':department_id', $department_id); // Updated to department_id
        $query->bindParam(':hire_date', $hire_date);
        $query->bindParam(':salary', $salary);

        // Execute the query
        $query->execute();

        // Debug: Check if the query executed successfully
        if ($query->rowCount() > 0) {
            echo "<script>alert('Employee added successfully');
            location.assign('View_Employees.php');
            </script>";
        } else {
            echo "<script>alert('Error: Employee not added.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error adding employee: " . $e->getMessage() . "');</script>";
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
    <title>Add Employee</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
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
            margin: 50px auto;
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

       input{
        background-color: #191c24;
       }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Add Employee</h2>
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Position" required>
            </div>
            <div class="form-group">
                <label for="department_id">Department</label>
                <select class="form-control" id="department_id" name="department_id" required>
                    <?php
                    // Fetch existing department IDs from the departments table
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
            <div class="form-group">
                <label for="hire_date">Hire Date</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date" placeholder="Hire Date" required>
            </div>
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" placeholder="Salary" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2" name="addEmployee">Submit</button>
            <button type="button" class="btn btn-light" onclick="window.location.href='View_Employees.php';">Cancel</button>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
