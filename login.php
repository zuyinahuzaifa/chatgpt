<?php
session_start();

// Database connection (you should replace these with your actual database credentials)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'chat_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: chat.php');
            exit();
        }
    }
    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Chat System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #0f172a;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #fff;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #94a3b8;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #e2e8f0;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #334155;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        .login-button {
            width: 100%;
            padding: 0.75rem;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-button:hover {
            background: #2563eb;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 0.75rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #94a3b8;
        }

        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Animation background */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #0f172a, #1e293b);
        }

        .background span {
            position: absolute;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            animation: move 8s infinite linear;
        }

        @keyframes move {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(var(--move-x), var(--move-y));
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <?php
        // Create animated background elements
        for ($i = 0; $i < 5; $i++) {
            $size = rand(100, 300);
            $x = rand(0, 100);
            $y = rand(0, 100);
            $moveX = rand(-500, 500);
            $moveY = rand(-500, 500);
            echo "<span style='width: {$size}px; height: {$size}px; left: {$x}%; top: {$y}%; --move-x: {$moveX}px; --move-y: {$moveY}px;'></span>";
        }
        ?>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please sign in to continue</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="login-button">Sign In</button>
        </form>

        <div class="register-link">
            Don't have an account? <a href="register.php">Register</a>
        </div>
    </div>

    <script>
        // Add some interactivity to the form
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.style.transition = 'all 0.3s ease';
            });

            input.addEventListener('blur', function() {
