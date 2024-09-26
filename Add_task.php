    <?php
    include('Dbcon.php');
    include('header.php');


    if (isset($_POST['addTask'])) {
        // Retrieve form data
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $assignee = $_POST['assignee'];
        $due_date = $_POST['due_date'];
        $priority = $_POST['priority'];

        // Debug: Check if form data is being received
        echo "<script>console.log('Form data received: task_id=$task_id, task_name=$task_name, assignee=$assignee, due_date=$due_date, priority=$priority');</script>";

        // Prepare and execute the query
        try {
            // Check if PDO is set and connected
            if (!isset($pdo)) {
                throw new Exception("Database connection not established.");
            }

            // Prepare the SQL statement
            $query = $pdo->prepare("INSERT INTO task (task_id, task_name, assignee, due_date, priority) VALUES (:task_id, :task_name, :assignee, :due_date, :priority)");
            
            // Bind parameters
            $query->bindParam(':task_id', $task_id);
            $query->bindParam(':task_name', $task_name);
            $query->bindParam(':assignee', $assignee);
            $query->bindParam(':due_date', $due_date);
            $query->bindParam(':priority', $priority);

            // Execute the query
            $query->execute();

            // Debug: Check if the query executed successfully
            if ($query->rowCount() > 0) {
                echo "<script>alert('Task added successfully');
                location.assign('View_Task.php');
                </script>";
            } else {
                echo "<script>alert('Error: Task not added.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error adding task: " . $e->getMessage() . "');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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
            <h2 class="mb-4">Manage Tasks</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="task_id">Task ID</label>
                    <input type="text" class="form-control" id="task_id" name="task_id" placeholder="Task ID">
                </div>
                <div class="form-group">
                    <label for="task_name">Task Name</label>
                    <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name">
                </div>
                <div class="form-group">
                    <label for="assignee">Assignee</label>
                    <input type="text" class="form-control" id="assignee" name="assignee" placeholder="Assignee">
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date">
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-control" id="priority" name="priority">
                        <option>Low</option>
                        <option>Medium</option>
                        <option>High</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="addTask">Submit</button>
                <button type="button" class="btn btn-light">Cancel</button>
            </form>
        </div>

        <?php include('footer.php'); ?>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
