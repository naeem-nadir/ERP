<?php
include('Dbcon.php');

if (isset($_POST['register'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    // Debug: Check if form data is being received
    echo "<script>console.log('Form data received: username=$username, email=$email, role=$role');</script>";

    // Prepare and execute the query
    try {
        // Check if PDO is set and connected
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        // Prepare the SQL statement
        $query = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        
        // Bind parameters
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->bindParam(':role', $role);

        // Execute the query
        $query->execute();

        // Debug: Check if the query executed successfully
        if ($query->rowCount() > 0) {
            echo "<script>alert('User registered successfully');
            location.assign('index.php');
            </script>";
        } else {
            echo "<script>alert('Error: User not registered.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error registering user: " . $e->getMessage() . "');</script>";
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
    color: #eb1616;
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
.input-container input[type="email"],
.input-container input[type="password"],
.input-container select {
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
.input-container input[type="email"]:focus ~ .label,
.input-container input[type="email"]:valid ~ .label,
.input-container input[type="password"]:focus ~ .label,
.input-container input[type="password"]:valid ~ .label,
.input-container select:focus ~ .label,
.input-container select:valid ~ .label {
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
.input-container input[type="text"]:valid ~ .underline,
.input-container input[type="email"]:focus ~ .underline,
.input-container input[type="email"]:valid ~ .underline,
.input-container input[type="password"]:focus ~ .underline,
.input-container input[type="password"]:valid ~ .underline,
.input-container select:focus ~ .underline,
.input-container select:valid ~ .underline {
    transform: scaleX(1);
}

button {
    --primary-color: #645bff;
    background-color: #EB1616;
    border-color: #EB1616;
    --hover-color: #333;
    --arrow-width: 10px;
    --arrow-stroke: 2px;
    box-sizing: border-box;
    border: 0;
    border-radius: 20px;
    color: var(--secondary-color);
    padding: 1em 1.8em;
 

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

button:hover .arrow:before {
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



.login-option {
    text-align: center;
    margin-top: 20px;
}

.login-option a {
    color: #EB1616;
    text-decoration: none;
    font-weight: bold;
}

.login-option a:hover {
    text-decoration: underline;
}
</style>

</head>
<body>
    <div class="container">
        <h2 class="mb-4">Register</h2>
        <form method="POST">
            <div class="input-container">
                <input type="text" id="username" name="username" required>
                <label for="username" class="label">User Name</label>
                <div class="underline"></div>
            </div>

            <div class="input-container">
                <input type="email" id="email" name="email" required>
                <label for="email" class="label">Email</label>
                <div class="underline"></div>
            </div>

            <div class="input-container">
                <input type="password" id="password" name="password" required>
                <label for="password" class="label">Password</label>
                <div class="underline"></div>
            </div>

            <div class="input-container">
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected></option>
                    <option>Admin</option>
                    <option>User</option>
                </select>
                <label for="role" class="label">Role</label>
                <div class="underline"></div>
            </div>
            
            <button type="submit" class="btn btn-primary mr-2" name="register">Register</button>
            <button type="button" class="btn btn-light">Cancel</button>
        </form>

        <div class="login-option">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
