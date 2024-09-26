<?php
include('Dbcon.php');

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    try {
        $query = $pdo->prepare("DELETE FROM employee WHERE employee_id = :employee_id");
        $query->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $query->execute();

        echo "<script>alert('Employee deleted successfully'); location.assign('View_Employees.php');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting employee: " . $e->getMessage() . "'); location.assign('View_Employees.php');</script>";
    }
} else {
    echo "<script>alert('No employee ID provided'); location.assign('View_Employees.php');</script>";
}
?>
