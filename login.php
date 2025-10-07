<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Frappéy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f5f5f5;
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .login-container { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px;
            border: 2px solid #000;
        }
        .login-header { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .login-header img {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
        }
        .login-header h1 { 
            color: #000; 
            font-size: 2em; 
            margin-bottom: 10px; 
        }
        .login-header p {
            color: #666;
            font-size: 1.1em;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            color: #333; 
            font-weight: 600; 
        }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #000; 
            border-radius: 8px; 
            font-size: 1em; 
        }
        .form-group input:focus { 
            outline: none; 
            border-color: #666; 
        }
        .submit-btn { 
            background: #000; 
            color: white; 
            padding: 15px; 
            border: 2px solid #000; 
            border-radius: 8px; 
            font-size: 1.1em; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%;
            transition: all 0.3s;
        }
        .submit-btn:hover { 
            background: white;
            color: #000;
        }
        .error-message { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 20px;
            border: 2px solid #000;
        }
        .back-link { 
            text-align: center; 
            margin-top: 20px; 
        }
        .back-link a { 
            color: #000; 
            text-decoration: none;
            font-weight: 600;
            border-bottom: 2px solid #000;
        }
        .back-link a:hover {
            color: #666;
            border-bottom-color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="assets/logo_main.png" alt="Frappéy Logo">
            <p>Admin Login</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>

        <div class="back-link">
            <a href="index.php">← Back to Application Form</a>
        </div>
    </div>
</body>
</html>