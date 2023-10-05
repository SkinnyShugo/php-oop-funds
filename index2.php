<?php
require 'config.php';
require 'User.php';
require 'FundManager.php';
require 'ChatGPT.php';

session_start();

$userClass = new User($pdo);
$fmClass = new FundManager($pdo);
$chatGPT = new ChatGPT('YOUR_OPENAI_API_KEY');

$message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userClass->register($username, $password);
    $message = "Registered successfully!";
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($userClass->login($username, $password)) {
        $_SESSION['username'] = $username;
        $message = "Logged in successfully!";
    } else {
        $message = "Invalid login!";
    }
}

if (isset($_POST['add'])) {
    $amount = $_POST['amount'];
    $fmClass->addFunds($_SESSION['username'], $amount);
    $message = "Funds added successfully!";
}

if (isset($_POST['withdraw'])) {
    $amount = $_POST['amount'];
    $fmClass->withdrawFunds($_SESSION['username'], $amount);
    $message = "Funds withdrawn successfully!";
}

if (isset($_POST['advice'])) {
    $message = $chatGPT->getAdvice("I've just performed a transaction. Any advice?");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funds Management System</title>
</head>
<body>
    <?php if (!isset($_SESSION['username'])): ?>
        <h2>Register</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>

        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    <?php else: ?>
        <h2>Welcome, <?= $_SESSION['username'] ?></h2>

        <h3>Add Funds</h3>
        <form action="" method="post">
            <input type="number" step="0.01" name="amount" placeholder="Amount" required>
            <button type="submit" name="add">Add Funds</button>
        </form>

        <h3>Withdraw Funds</h3>
        <form action="" method="post">
            <input type="number" step="0.01" name="amount" placeholder="Amount" required>
            <button type="submit" name="withdraw">Withdraw Funds</button>
        </form>

        <h3>Get Advice</h3>
        <form action="" method="post">
            <button type="submit" name="advice">Get Advice from ChatGPT</button>
        </form>
    <?php endif; ?>

    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
</body>
</html>
