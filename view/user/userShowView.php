<?php
/**
 * @var $user
 */
?>

<html>
<head>
    <title>Hello</title>
</head>
<body>
    <h1>Юзер</h1>
    
    <h3>Имя пользователя <?= $user->login ?></h3>
    <h3>Почта <?= $user->email ?></h3>
    <h3>Пароль <?= $user->password ?></h3>
</body>
</html>