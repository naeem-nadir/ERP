<?php
include('Dbcon.php');
include('header.php');

// Handle delete request
if (isset($_POST['deleteSale'])) {
    $sale_id = $_POST['sale_id'];
    try {
        $query = $pdo->prepare("DELETE FROM sales WHERE sale_id = :sale_id");
        $query->bindParam(':sale_id', $sale_id);
        $query->execute();
        echo "<script>alert('Sale deleted successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error deleting sale: " . $e->getMessage() . "');</script>";
    }
}

// Handle add request
if (isset($_POST['addSale'])) {
    $sale_id = $_POST['sale_id'];
    $customer_id = $_POST['customer_id'];
    $sale_date = $_POST['sale_date'];
    $amount = $_POST['amount'];

    try {
        $query = $pdo->prepare("INSERT INTO sales (sale_id, customer_id, sale_date, amount) VALUES (:sale_id, :customer_id, :sale_date, :amount)");
        $query->bindParam(':sale_id', $sale_id);
        $query->bindParam(':customer_id', $customer_id);
        $query->bindParam(':sale_date', $sale_date);
        $query->bindParam(':amount', $amount);
        $query->execute();
        echo "<script>alert('Sale added successfully'); location.reload();</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error adding sale: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
  
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
            background-color: #fff;
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
        <h2 class="mb-4">Manage Sales</h2>

        <!-- Form for adding new sales -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="sale_id">Sale ID</label>
                <input type="text" class="form-control" id="sale_id" name="sale_id" placeholder="Sale ID" required>
            </div>
            <div class="form-group">
                <label for="customer_id">Customer ID</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Customer ID" required>
            </div>
            <div class="form-group">
                <label for="sale_date">Sale Date</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2" name="addSale">Submit</button>
            <button type="button" class="btn btn-light">Cancel</button>
        </form>

       
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
