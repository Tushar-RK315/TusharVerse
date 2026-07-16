<?php

use TusharRk315\Tusharverse\Core\Session;

$user = Session::get('user');
?>

<!DOCTYPE html>
<html>
<head>
    <title>TusharVerse</title>
</head>
<body>

<h1>Welcome <?= htmlspecialchars($user['name']) ?> 🚀</h1>

<p><?= htmlspecialchars($user['email']) ?></p>

</body>
</html>