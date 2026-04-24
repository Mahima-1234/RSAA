<?php
// Simple Password Hash Generator
$output = "";

if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if (strlen($password) > 0) {
        // Generate the secure hash
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Create the exact line of code needed
        $code = "define('ADMIN_PASSWORD', '$hash');";
        
        $output = "
        <div style='background: #e0f7fa; border: 2px solid #006064; padding: 20px; margin-bottom: 20px;'>
            <h3 style='margin-top:0'>Hash Generated!</h3>
            <p>Copy the line below and replace the existing line in your <strong>config.php</strong> file:</p>
            <textarea style='width:100%; height:50px; font-family:monospace; font-size:14px;' readonly>$code</textarea>
        </div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate Hash</title>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin-bottom: 15px; box-sizing: border-box; }
        button { background: #333; color: white; border: none; padding: 10px 20px; cursor: pointer; font-weight: bold; width: 100%; }
        button:hover { background: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Set New Password</h2>
        <?php echo $output; ?>
        <form method="post">
            <label>Enter New Password:</label><br>
            <input type="text" name="password" placeholder="e.g. MySecretPass2025" required>
            <button type="submit">Generate Code</button>
        </form>
    </div>
</body>
</html>