<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "123") {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Travel Mobil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Travel Mobil</h1>
    <p>Masuk untuk mengakses dashboard</p>
</header>

<main style="text-align:center; margin-top:50px;">
    <section id="login">
        <h2>Form Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </section>
</main>
</body>
</html>
