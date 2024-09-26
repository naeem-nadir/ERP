<?php
include('Dbcon.php');
include('header.php');

// Fetch departments from the database
try {
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Prepare and execute the query
    $query = $pdo->prepare("SELECT * FROM departments");
    $query->execute();
    $departments = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching departments: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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
        <h2 class="mb-4">Departments</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>Manager ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($departments)) : ?>
                    <?php foreach ($departments as $department) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($department['department_id']); ?></td>
                            <td><?php echo htmlspecialchars($department['department_name']); ?></td>
                            <td><?php echo htmlspecialchars($department['manager_id']); ?></td>
                            <td class= "action">
                                <a href="update_department.php?department_id=<?php echo urlencode($department['department_id']); ?>" class="btn btn-primary btn-sm">Update</a>
                                <form method="POST" action="delete_department.php" style="display:inline;">
                                    <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department['department_id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteDepartment">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">No departments found.</td>
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
