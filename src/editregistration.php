<?php require 'editregistration.script.php'; ?>

<html>
    <head>
        <title>Authentimail - Registreren</title>
        <link rel="stylesheet" type="text/css" href="include/style.css" />
    </head>
    <body>

        <h1>Registreren</h1>

        <?php if($errors): ?>
            <div class="errorbox">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <p>Voer hier uw nieuwe gewenste gebruikersnaam in.</p>

        <form method="post">
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" />
            </p>
            <p>
                <input type="submit" value="Registreren" />
            </p>
        </form>

    </body>
</html>