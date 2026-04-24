<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-900 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-serif font-bold text-gray-800">Admin Login</h1>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-2">Rajkumar Shah & Associates</p>
        </div>
        <form onsubmit="handleLogin(event)" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Password</label>
                <input type="password" id="password" class="w-full border-b-2 border-gray-200 py-2 focus:outline-none focus:border-[#D4AF37] transition-colors" placeholder="Enter access key">
            </div>
            <button type="submit" class="w-full bg-[#D4AF37] text-white py-3 font-bold uppercase tracking-widest text-xs rounded hover:bg-[#c5a059] transition-colors">
                Enter Dashboard
            </button>
        </form>
    </div>

    <script>
        async function handleLogin(e) {
            e.preventDefault();
            const password = document.getElementById('password').value;
            
            try {
                const res = await fetch('../api.php?action=login', {
                    method: 'POST',
                    body: JSON.stringify({ password: password })
                });
                const result = await res.json();
                
                if (result.success) {
                    window.location.href = 'dashboard.php';
                } else {
                    Swal.fire('Access Denied', 'Invalid password.', 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Error', 'Connection failed.', 'error');
            }
        }
    </script>
</body>
</html>