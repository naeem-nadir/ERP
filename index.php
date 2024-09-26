<?php
session_start();
include("Dbcon.php"); 
include("header.php");



if (!isset($_SESSION['username'])) {
    echo "<script>
    location.assign('login.php');
    </script>";
}



try {
    // Fetch Total Employees
    $query = $pdo->query("SELECT COUNT(*) AS total FROM employees");
    $totalEmployees = $query->fetchColumn();
} catch (PDOException $e) {
    echo "<script>alert('Error fetching data: " . $e->getMessage() . "');</script>";
}

try {
    // Fetch Total Projects
    $query = $pdo->query("SELECT COUNT(*) AS total FROM projects");
    $totalProjects = $query->fetchColumn();
} catch (PDOException $e) {
    echo "<script>alert('Error fetching data: " . $e->getMessage() . "');</script>";
}

try {
    // Fetch Total Tasks
    $query = $pdo->query("SELECT COUNT(*) AS total FROM task");
    $totalTasks = $query->fetchColumn();
} catch (PDOException $e) {
    echo "<script>alert('Error fetching data: " . $e->getMessage() . "');</script>";
}

try {
    // Fetch Total Departments
    $query = $pdo->query("SELECT COUNT(*) AS total FROM departments");
    $totalDepartments = $query->fetchColumn();
} catch (PDOException $e) {
    echo "<script>alert('Error fetching data: " . $e->getMessage() . "');</script>";
}
?>



            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
        <!-- Total Employees -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2"><a href="view_employees.php"> Total Employees
                    </a>
                    </p>
                    <h6 class="mb-0"><?php echo htmlspecialchars($totalEmployees); ?></h6>
                </div>
            </div>
            </div>
        <!-- Total Projects -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-project-diagram fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2"><a href="view_project.php">Total Projects</a></p>
                    <h6 class="mb-0"><?php echo htmlspecialchars($totalProjects); ?></h6>
                </div>
            </div>
        </div>
                
        <!-- Total Tasks -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-tasks fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2"><a href="view_task.php">Total Tasks</a></p>
                    <h6 class="mb-0"><?php echo htmlspecialchars($totalTasks); ?></h6>
                </div>
            </div>
        </div>
                    <!-- Total Departments -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-building fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2"><a href="view_department.php">Total Departments</a></p>
                    <h6 class="mb-0"><?php echo number_format($totalDepartments); ?></h6>
                </div>  
            </div>
        </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <!-- <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Worldwide Sales</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Salse & Revenue</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Sales Chart End -->


           


            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
    <div class="h-100 bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Project Due Dates</h6>
            <a href="">Show All</a>
        </div>

        <?php
      

        try {
            // Check if PDO is set and connected
            if (!isset($pdo)) {
                throw new Exception("Database connection not established.");
            }

            // Get current date
            $currentDate = new DateTime();

            // Fetch all tasks that are due tomorrow
            $query = $pdo->query("SELECT * FROM projects WHERE DATEDIFF(end_date, CURDATE()) = 1");
            $tasks = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($tasks)) {
                foreach ($tasks as $task) {
                    ?>
                    <div class="d-flex align-items-center border-bottom py-3">
                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0"><?php echo htmlspecialchars($task['project_name']); ?></h6>
                                <small><?php echo htmlspecialchars($task['end_date']); ?></small>
                            </div>
                            <span>It's the last day for this project!</span>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="d-flex align-items-center py-3">
                    <div class="w-100 text-center">
                        <span>No projects are due tomorrow.</span>
                    </div>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error fetching projects: " . $e->getMessage() . "');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
        ?>
    </div>
</div>

                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                 
                    
                            <div class="col-sm-12 col-md-6 col-xl-4">
    <div class="h-100 bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Leave Due Dates</h6>
            <a href="">Show All</a>
        </div>

        <?php
     

        try {
            // Check if PDO is set and connected
            if (!isset($pdo)) {
                throw new Exception("Database connection not established.");
            }

            // Get current date
            $currentDate = new DateTime();

            // Fetch all leaves that are ending tomorrow
            $query = $pdo->query("SELECT * FROM employeeleave WHERE DATEDIFF(end_date, CURDATE()) = 1");
            $leaves = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($leaves)) {
                foreach ($leaves as $leave) {
                    ?>
                    <div class="d-flex align-items-center border-bottom py-3">
                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0"><?php echo htmlspecialchars($leave['employee_id']); ?></h6>
                                <small><?php echo htmlspecialchars($leave['end_date']); ?></small>
                            </div>
                            <span>It's the last day of your leave!</span>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="d-flex align-items-center py-3">
                    <div class="w-100 text-center">
                        <span>No leaves are ending tomorrow.</span>
                    </div>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error fetching leave data: " . $e->getMessage() . "');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
        ?>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


            <?php
       include("footer.php");
            ?>
