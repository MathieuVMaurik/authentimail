<?php require 'authregistration.script.php'; ?>
<script src="include/JavaScript.js" language="Javascript" type="text/javascript"></script>


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

        <p>Voer hier uw gewenste gebruikersnaam in en alternative e-mail in.</p>

        <form method="post">
            <p>
                <div id="InputDiv">
                <label for="username">Username</label>
                <input type="text" name="username" required="required" />
                <label for="AltEmail">Alternative E-mail</label>
                <input type="text" name="AltEmail[1]" id="AltEmail[1]"/>
                <input type="button" value="Klik om een extra email in te vullen" onclick="AltEmailInputAdd('InputDiv');" />
                <div id="errorbox"></div>
            </div>
            </p>
            <p>
                <input type="submit" value="Registreren" />
            </p>
        </form>

    </body>
</html>