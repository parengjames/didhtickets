<?php
// login.php
session_start();

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Example validation (replace with your DB check)
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['user'] = [
            'name' => 'IT Admin',
            'role' => 'Administrator',
            'username' => $username
        ];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
