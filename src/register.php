<?php include 'register.script.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Authentimail - Registreren</title>
    </head>
    <body>

        <p><a href="index.php">Terug</a></p>

        <h1>Registreren</h1>

        <?php if($registered == true): ?>
            <p>Er is een email gestuurd naar <strong><?php echo $_POST['email']; ?></strong> met nadere instructies.</p>
        <?php endif; ?>

        <form method="post">
            <p>
                <label for="email">Email Adres</label>
                <input type="text" name="email" />
            </p>

            <p>
                <input type="submit" name="submit" value="Registreren"/>
            </p>
        </form>

    </body>
</html>