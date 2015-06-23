<?php

require 'include/db.php';

session_start();
$errors = array();
$registered = null;
$recoveries = null;

if(isset($_GET['token']))
{
    $stmt = $db->prepare('SELECT * FROM registrations WHERE token = :token');
    $stmt->bindParam(':token', $_GET['token']);
    $stmt->execute();

    $registration = $stmt->fetch(PDO::FETCH_OBJ);

    if(isset($_GET["Recover"]))
    {
        $stmt = $db->prepare('SELECT * FROM recoveries WHERE token = :token');
        $stmt->bindParam(':token', $_GET['token']);
        $stmt->execute();

        $recoveries = $stmt->fetch(PDO::FETCH_OBJ);
    }

    if($registration && $registration->type == 2 || isset($_GET["Recover"]))
    {
        if(strtotime(!empty($registration->expiration_date)) > time() || strtotime(!empty($recoveries->expiration_date)) > time())
        {
            if(isset($_POST['username']))
            {
                //Edit user
                if(isset($_GET["Recover"]))
                {
                    $stmt = $db->prepare('UPDATE users SET username=:username alt_email=:AltEmail WHERE user_ID = :id');
                    $stmt->bindParam(':email', $_POST['Email']);
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':AltEmail', $_POST['AltEmail']);
                    $stmt->bindParam(':id', $registration->user_ID);
                    $stmt->execute();

                    $_SESSION['user_ID'] = $registration->user_ID;
                    $_SESSION['user_name'] = $_POST['username'];
                }
                else
                {
                    $stmt = $db->prepare('UPDATE users SET username=:username alt_email=:AltEmail WHERE user_ID = :id');
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':AltEmail', $_POST['AltEmail']);
                    $stmt->bindParam(':id', $registration->user_ID);
                    $stmt->execute();

                    $_SESSION['user_ID'] = $registration->user_ID;
                    $_SESSION['user_name'] = $_POST['username'];
                    $registered = true;
                }
                //Delete all pending registrations
                $stmt = $db->prepare("DELETE FROM registrations WHERE token = :token");
                $stmt->bindParam(':token', $_GET['token']);
                $stmt->execute();

                //Redirect user to index
                header('Location: index.php?registered=2');
                echo '<p>Uw registratie is succesvol gewijzigd.</p>';
                echo '<p><a href="index.php">Terug</a></p>';
                exit();
            }
        }
        else
        {
            $errors[] = "Deze link is niet meer geldig. Probeer opnieuw te registreren.";
        }
    }
    else
    {
        header('HTTP/1.0 404 Not Found');
        echo '404 :|';
        exit();
    }
}
else
{
    header('HTTP/1.0 404 Not Found');
    echo '404';
    exit();
}