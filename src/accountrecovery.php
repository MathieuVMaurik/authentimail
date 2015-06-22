<?php require "accountrecovery.script.php"; ?>
<!DOCTYPE html>

<html>
<head>
    <title>account terug halen</title>
</head>
<body>

<p><a href="index.php">Terug</a></p>

<h1>account terughalen</h1>

<?php if(isset($_POST['email'])): ?>
    <div class="infobox">
        <p>Er is een email gestuurt naar uw alternative E-mail address.</p>
    </div>
<?php endif; ?>

<form method="post">
    <p>
        <label for="usernameReq">username</label>
        <input name="usernameReq" type="text" />
    </p>
    <p>
        <input name="submit" value="Stuur E-mail" type="submit" />
    </p>
</form>

</body>
</html>