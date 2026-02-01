<?php
// create_account.php
session_start();
include "config/db_connection.php";

$error = '';
$fullname = '';
$username = '';
$role = '';
$department = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = $_POST['role'];
    $department = $_POST['department'];

    // Basic validations
    if($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif(empty($username) || empty($password) || empty($fullname) || empty($role)) {
        $error = "Please fill in all required fields!";
    } else {
        // TODO: Save user to database with hashed password
        // Example: password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['success'] = "Account created successfully!";
        header("Location: login.php");
        exit;
    }
}
?>
