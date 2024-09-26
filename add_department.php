<?php
include('Dbcon.php');
include('header.php');

if (isset($_POST['addDepartment'])) {
    // Retrieve form data
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $manager_id = $_POST['manager_id'];

    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare and execute the query
        $query = $pdo->prepare("INSERT INTO departments (department_id, department_name, manager_id) VALUES (:department_id, :department_name, :manager_id)");
        
        // Bind parameters
        $query->bindParam(':department_id', $department_id);
        $query->bindParam(':department_name', $department_name);
        $query->bindParam(':manager_id', $manager_id);

        // Execute the query
        $query->execute();

        echo "<script>alert('Department added successfully'); location.assign('view_department.php');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error adding department: " . $e->getMessage() . "');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

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
        <h2 class="mb-4">Add Department</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="department_id">Department ID</label>
                <input type="text" class="form-control" id="department_id" name="department_id" placeholder="Department ID" required>
            </div>
            <div class="form-group">
                <label for="department_name">Department Name</label>
                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Department Name" required>
            </div>
            <div class="form-group">
                <label for="manager_id">Manager ID</label>
                <input type="text" class="form-control" id="manager_id" name="manager_id" placeholder="Manager ID" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2" name="addDepartment">Submit</button>
            <button type="button" class="btn btn-light" onclick="window.location.href='view_department.php';">Cancel</button>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
