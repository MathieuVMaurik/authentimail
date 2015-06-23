<?php

require 'include/db.php';

session_start();

$errors = array();
$registered = false;

if(isset($_GET['token']))
{
    $stmt = $db->prepare('SELECT * FROM registrations WHERE token = :token');
    $stmt->bindParam(':token', $_GET['token']);
    $stmt->execute();

    $registration = $stmt->fetch(PDO::FETCH_OBJ);

    if($registration)
    {
        if(strtotime($registration->expiration_date) > time())
        {
            if(isset($_POST['username']))
            {
                //Register user
                $stmt = $db->prepare('INSERT INTO users (username, email) VALUES (:username, :email)');
                $stmt->bindParam(':username', $_POST['username']);
                $stmt->bindParam(':email', $registration->email);
                $stmt->execute();

                $_SESSION['user_ID'] = $db->lastInsertId();
                foreach($_POST['AltEmail'] as $AltEmail)
                {
                    $Altstmt = $db->prepare('INSERT INTO alt_emails (user_ID, email) VALUES (:userID,:altmail)');
                    $Altstmt->bindParam(':userID', $_SESSION['user_ID']);
                    $Altstmt->bindParam('altmail', $AltEmail);
                    $Altstmt->execute();
                }


                $_SESSION['user_name'] = $_POST['username'];
                $registered = true;


                //Delete all pending registrations
                $stmt = $db->prepare("DELETE FROM registrations WHERE token = :token");
                $stmt->bindParam(':token', $_GET['token']);
                $stmt->execute();

                //Redirect user to index
                header('Location: index.php?registered=1');
                echo '<p>U bent succesvol geregistreerd.</p>';
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
        header('Location: errors/404.php');
        exit();
    }
}
else
{
    header('Location: errors/404.php');
    echo '404';
    exit();
}