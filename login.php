<?php
session_start();
include('Dbcon.php'); 

if (isset($_POST['login'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query
    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare the SQL statement
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        // Fetch the user
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['username'] = $user['username'];
            echo "<script>
            location.assign('index.php');
            </script>";
        } else {
            // Incorrect credentials
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error logging in: " . $e->getMessage() . "');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>


    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
        }

        .container {
            flex: 1;
            max-width: 600px;
            margin: 50px auto;
            background-color: #191c24;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
            font-size: 2rem; 
            font-weight: bold; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
            letter-spacing: 1px; 
        }

        .input-container {
            position: relative;
            margin-bottom: 30px;
        }

        .input-container input[type="text"],
        .input-container input[type="password"] {
            font-size: 20px;
            width: 100%;
            border: none;
            border-bottom: 2px solid #ccc;
            padding: 10px 0;
            background-color: transparent;
            outline: none;
            color: #fff;
        }

        .input-container .label {
            position: absolute;
            top: 0;
            left: 0;
            color: #ccc;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-container input[type="text"]:focus ~ .label,
        .input-container input[type="text"]:valid ~ .label,
        .input-container input[type="password"]:focus ~ .label,
        .input-container input[type="password"]:valid ~ .label {
            top: -20px;
            font-size: 16px;
            color: #fff;
        }

        .input-container .underline {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 100%;
            background-color: #fff;
            transform: scaleX(0);
            transition: all 0.3s ease;
        }

        .input-container input[type="text"]:focus ~ .underline,
        .input-container input[type="password"]:focus ~ .underline,
        .input-container input[type="text"]:valid ~ .underline,
        .input-container input[type="password"]:valid ~ .underline {
            transform: scaleX(1);
        }

        button {
           
            --hover-color: #333;
            --arrow-width: 10px;
            --arrow-stroke: 2px;
            box-sizing: border-box;
            border: 0;
            border-radius: 20px;
            color: var(--secondary-color);
            padding: 1em 1.8em;
            --primary-color: #645bff;
    background-color: #EB1616;
    border-color: #EB1616;
            display: flex;
            align-items: center;
            gap: 0.6em;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s background;
        }

        button .arrow-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button .arrow {
            margin-top: 1px;
            width: var(--arrow-width);
            background: var(--primary-color);
            height: var(--arrow-stroke);
            position: relative;
            transition: 0.2s;
        }

        button .arrow::before {
            content: "";
            box-sizing: border-box;
            position: absolute;
            border: solid var(--secondary-color);
            border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
            display: inline-block;
            top: -3px;
            right: 3px;
            transition: 0.2s;
            padding: 3px;
            transform: rotate(-45deg);
        }

        button:hover {
            background-color: #9f1f1f;
        }

        button:hover .arrow {
            background: var(--secondary-color);
        }

        button:hover .arrow::before {
            right: 0;
        }

        .footer {
            background-color: #1e1e1e;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .register-option {
            text-align: center;
            margin-top: 20px;
        }

        .register-option a {
            color: #EB1616 ;
            text-decoration: none;
            font-weight: bold;
        }

        .register-option a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Login</h2>
        <form method="POST">
            <div class="input-container">
                <input type="text" id="username" name="username" required>
                <label for="username" class="label">Username</label>
                <div class="underline"></div>
            </div>

            <div class="input-container">
                <input type="password" id="password" name="password" required>
                <label for="password" class="label">Password</label>
                <div class="underline"></div>
            </div>

            <button type="submit" class="btn btn-primary mr-2" name="login">Login</button>
        </form>

        <div class="register-option">
            <p>Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
