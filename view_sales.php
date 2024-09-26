<?php
include('Dbcon.php');
include('header.php');

// Fetch sales from the database
try {
    if (!isset($pdo)) {
        throw new Exception("Database connection not established.");
    }

    // Prepare and execute the query
    $query = $pdo->prepare("SELECT * FROM sales");
    $query->execute();
    $sales = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching sales: " . $e->getMessage() . "');</script>";
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

// Handle delete sale request
if (isset($_POST['deleteSale'])) {
    $sale_id = $_POST['sale_id'];

    try {
        // Prepare and execute the delete query
        $query = $pdo->prepare("DELETE FROM sales WHERE sale_id = :sale_id");
        $query->bindParam(':sale_id', $sale_id);
        $query->execute();

        // Refresh the page to reflect the deletion
        echo "<script>alert('Sale deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting sale: " . $e->getMessage() . "');</script>";
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
    <title>View Sales</title>
   
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
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        h2{
            color:#eb1616;
        }
        .action{
        display: flex;
            gap: 10px;
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
        <h2 class="mb-4">Sales</h2>
        <!-- Table displaying existing sales -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Customer ID</th>
                    <th>Sale Date</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sales)) : ?>
                    <?php foreach ($sales as $sale) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale['sale_id']); ?></td>
                            <td><?php echo htmlspecialchars($sale['customer_id']); ?></td>
                            <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                            <td><?php echo htmlspecialchars($sale['amount']); ?></td>
                            <td class= "action">
                                <!-- Update and Delete actions (implement update functionality as needed) -->
                                <a href="update_sale.php?sale_id=<?php echo urlencode($sale['sale_id']); ?>" class="btn btn-warning btn-sm">Update</a>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="sale_id" value="<?php echo htmlspecialchars($sale['sale_id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteSale">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No sales found.</td>
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
