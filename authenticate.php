<?php require 'authenticate.script.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Authentimail</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>

    <h1>Inloggen</h1>

    <?php if($errors): ?>
    <div class="errorbox">
        <ul>
        <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if($authenticated): ?>
        <p>U bent succesvol ingelogd.</p>
        <p><a href="index.php">Klik hier</a> om verder te gaan.</p>
    <?php endif; ?>

    </body>
</html>