<?php

session_start();

?>

<!DOCTYPE html>

<html>
	<head>
		<title>Authentimail</title>
	</head>
	<body>

        <?php if(isset($_GET['registered']) && $_GET['registered'] == 1): ?>
            <p>U bent succesvol geregistreerd.</p>
        <?php elseif(isset($_GET['registered']) && $_GET['registered'] == 2): ?>
            <p>Uw registratie is succesvol aangepast.</p>
        <?php endif; ?>

		<?php if(isset($_SESSION['user_ID'])): ?>
			<p>U bent ingelogd als <?php echo $_SESSION['user_name']; ?>. <a href="logout.php">Klik hier</a> om uit te loggen.</p>
		<?php else: ?>
			<p><a href="login.php">Inloggen</a></p>
            <p><a href="register.php">Registreren</a></p>
		<?php endif; ?>

	</body>
</html>