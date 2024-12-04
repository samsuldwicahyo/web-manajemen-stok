<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
    }
}
?>
