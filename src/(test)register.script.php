
<?php

// Make sure no one is logged in.
session_start();
session_destroy();

require('include/db.php');        //Get database
require('include/config.php');    //Get config

$registered = false;

if(isset($_POST['email']))
{
    require('phpmailer/PHPMailerAutoload.php');   //Get PHPMailer
    require('include/mailconfig.php');            //Get mail config

    $user = findUser($_POST['email']);

    if (isRegistered($user)) {
        $token = createEditToken();
        sendAlreadyRegisteredMail($user, $token);
    }
    else {
        $token = createSignUpToken();
        sendRegistrationMail($user, $token);
    }

    $registered = true;
}

/* -------------------------------------------------------------------------- */

function findUser($email) {
    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function isRegistered($user) {
    return $user != false;
}

function createEditToken($user) {
    $token = hash('SHA512', uniqid('mt_rand', true), false);

    //Delete all old registrations
    $stmt = $db->prepare("DELETE FROM registrations WHERE user_ID = :id");
    $stmt->bindParam(':id', $user->ID);
    $stmt->execute();

    //Insert registration into database, mark as existing
    $stmt = $db->prepare("INSERT INTO registrations (token, user_ID, expiration_date, type, email) VALUES (:token, :user_ID, :expiration_date, 2, :email)");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':user_ID', $user->ID);
    $stmt->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 600)); //Expiration date is 10 minutes into the future
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();

    return $token;
}

function createSignUpToken($user) {
    $token = hash('SHA512', uniqid('mt_rand', true), false);

    $stmt = $db->prepare("INSERT INTO registrations (token, expiration_date, type, email) VALUES (:token, :expiration_date, 1, :email)");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 600)); //Expiration date is 10 minutes into the future
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();

    return $token;
}

function sendAlreadyRegisteredMail($user, $token) {
    $mail = initializeMail();
    $mail->addAddress($user->email);
    $mail->Subject = Mailconfig::$subject_register;
    $mail->Body = '<p>U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen:</p><p><a href="'. Config::$root_url .'"editregistration.php?token='.$token.'"></a></p>';
    $mail->AltBody = 'U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen: '.Config::$root_url.'editregistration.php?token='.$token;
    $mail->send();
}

function sendRegistrationMail($user) {
    $mail = initializeMail();
    $mail->addAddress($user->email);
    $mail->Subject = Mailconfig::$subject_register;
    $mail->Body = '<p>U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen:</p><p><a href="'. Config::$root_url .'"editregistration.php?token='.$token.'"></a></p>';
    $mail->AltBody = 'U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen: '.Config::$root_url.'editregistration.php?token='.$token;
    $mail->send();
}
