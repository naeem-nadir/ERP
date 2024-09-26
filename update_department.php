<?php
include('Dbcon.php');
include('header.php');

if (isset($_GET['department_id'])) {
    $department_id = $_GET['department_id'];

    // Fetch department details from the database
    try {
        $query = $pdo->prepare("SELECT * FROM departments WHERE department_id = :department_id");
        $query->bindParam(':department_id', $department_id, PDO::PARAM_INT);
        $query->execute();
        $department = $query->fetch(PDO::FETCH_ASSOC);

        if (!$department) {
            echo "<script>alert('Department not found'); location.assign('view_department.php');</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error fetching department details: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('No department ID provided'); location.assign('view_department.php');</script>";
    exit();
}

if (isset($_POST['updateDepartment'])) {
    // Retrieve updated form data
    $department_name = $_POST['department_name'];
    $manager_id = $_POST['manager_id'];

    try {
        // Prepare and execute the update query
        $query = $pdo->prepare("UPDATE departments SET department_name = :department_name, manager_id = :manager_id WHERE department_id = :department_id");
        $query->bindParam(':department_id', $department_id, PDO::PARAM_INT);
        $query->bindParam(':department_name', $department_name, PDO::PARAM_STR);
        $query->bindParam(':manager_id', $manager_id, PDO::PARAM_INT);

        // Execute the query
        $query->execute();

        echo "<script>alert('Department updated successfully'); location.assign('view_department.php');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating department: " . $e->getMessage() . "');</script>";
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
        <h2 class="mb-4">Update Department</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="department_name">Department Name</label>
                <input type="text" class="form-control" id="department_name" name="department_name" value="<?php echo htmlspecialchars($department['department_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="manager_id">Manager ID</label>
                <input type="text" class="form-control" id="manager_id" name="manager_id" value="<?php echo htmlspecialchars($department['manager_id']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2" name="updateDepartment">Update</button>
            <a href="view_department.php" class="btn btn-light">Cancel</a>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
