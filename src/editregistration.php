<?php require 'editregistration.script.php'; ?>
<script src="../src/include/JavaScript.js" language="Javascript" type="text/javascript"></script>

<html>
    <head>
        <title>Authentimail - Account Aanpassen</title>
        <link rel="stylesheet" type="text/css" href="include/style.css" />
    </head>
    <body>

        <h1>Account Aanpassen</h1>

        <?php if($errors): ?>
            <div class="errorbox">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <p>Voer hier uw nieuwe gewenste gebruikersnaam in en alternative e-mail in.</p>

        <form method="post">
            <p>
                <?php if(isset($_GET["Recover"]))
                {
                    echo'<label for="Email" > Email</label >
                         <input type = "text" name = "Email" required = "required" />';
                }
                ?>
                <label for="username">Username</label>
                <input type="text" name="username" required="required" />
                <label for="AltEmail">Alternative E-mail</label>
                <input type="text" name="AltEmail[]" required="required" />
                <input type="button" value="Klik om een extra email in te vullen" onclick="addInput('AltEmailInputAdd');" />
            </p>
            <p>
                <input type="submit" value="Registreren" />
            </p>
        </form>

    </body>
</html>