<?php require "login.script.php"; ?>
<!DOCTYPE html>

<html>
    <head>
        <title>Inloggen</title>
    </head>
    <body>

        <p><a href="index.php">Terug</a></p>

        <h1>Inloggen</h1>

        <?php if(isset($_POST['email'])): ?>
        <div class="infobox">
            <p>Als dit email adres (<strong><?php echo $_POST['email']; ?></strong>) bekend is in ons systeem, ontvangt u een e-mail.</p>
        </div>
        <?php endif; ?>

        <form method="post">
            <p>
                <label for="email">Email</label>
                <input name="email" type="text" />
            </p>
            <p>
                <input name="submit" value="Login" type="submit" />
            </p>
        </form>
        <p><a href="accountrecovery.php"> E-mail vergeten?</a></p>

    </body>
</html>