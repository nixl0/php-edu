<?php
/**
 * @var $login
 * @var $email
 */
?>

<html>
<head>
    <title>Hello</title>
</head>
<body>
    <h1>Юзер</h1>
    
    <h1>Привет <?= $login ?></h1>
    <p>Ваша почта <?= $email ?></p>
    <a href="/user/select">
        <button class="user__back-button">Назад</button>
    </a>
</body>
</html>