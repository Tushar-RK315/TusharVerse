<?php
use TusharRk315\Tusharverse\Core\Flash;
use TusharRk315\Tusharverse\Core\Session;
use TusharRk315\Tusharverse\Core\Csrf;

$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$basePath = rtrim($basePath, '/');
$actionBase = $basePath === '' || $basePath === '/' ? '' : $basePath;

$errors = [];
$success = null;

if (Flash::has('errors')) {
    $errors = json_decode(Flash::get('errors'), true) ?: [];
}

if (Flash::has('success')) {
    $success = Flash::get('success');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($success): ?>
    <div style="color: green; margin-bottom: 1rem;">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin-bottom: 1rem;">
        <ul>
            <?php foreach ($errors as $fieldErrors): ?>
                <?php foreach ((array) $fieldErrors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= htmlspecialchars($actionBase . '/login', ENT_QUOTES, 'UTF-8') ?>" method="POST">

    <input
    type="hidden"
    name="_token"
    value="<?= htmlspecialchars(Csrf::generate(), ENT_QUOTES, 'UTF-8') ?>"
    ><br>
    
    <label>Email</label><br>
    <input
    type="email"
    name="email"
    value="<?= htmlspecialchars((string) Session::old('email'), ENT_QUOTES, 'UTF-8') ?>"
    ><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>
    
    <button type="submit">
        Login
    </button>

</form>

</body>
</html>