<?php

    $errorMessage = $_GET['errorMessage'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="?acao=fazerLogin" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="senha">
        <br>
        <button type="submit">Login</button>    
        <span id="errorMessage"><?= htmlspecialchars($errorMessage) ?></span>
</body>
</html>