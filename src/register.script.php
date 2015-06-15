<?php

//Destroy session
session_start();
session_destroy();

//Get database
require('include/db.php');

//Get config
require 'include/config.php';

$registered = false;

if(isset($_POST['email']))
{
    //Get PHPMailer
    require('phpmailer/PHPMailerAutoload.php');
    //Get mail config
    require('include/mailconfig.php');

    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if($user)
    {
        $user_exists = true;
    }
    else
    {
        $user_exists = false;
    }

    $mail = new PHPMailer();

    if(Mailconfig::$SMTPAuth == true)
    {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    }
    $mail->Username = Mailconfig::$username;
    $mail->Password = Mailconfig::$password;
    $mail->Port = Mailconfig::$port;
    $mail->addAddress($_POST['email']);
    $mail->Subject = Mailconfig::$subject_register;

    $token = randomString();

    if($user_exists == true)
    {
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

        $mail->Body = '<p>U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen:</p><p><a href="'. Config::$root_url .'"editregistration.php?token='.$token.'"></a></p>';
        $mail->AltBody = 'U heeft al een account bij ons. U kunt uw account met de volgende link aanpassen: '.Config::$root_url.'editregistration.php?token='.$token;
    }
    else
    {
        //Insert registration into database, mark as not existing
        $stmt = $db->prepare("INSERT INTO registrations (token, expiration_date, type, email) VALUES (:token, :expiration_date, 1, :email)");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 600)); //Expiration date is 10 minutes into the future
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();

        $mail->Body = '<p>U kunt uzelf registreren met de volgende link:</p><p><a href="'. Config::$root_url .'"authregistration.php?token='.$token.'"></a></p>';
        $mail->AltBody = 'U kunt uzelf registreren met de volgende link: '.Config::$root_url.'authregistration.php?token='.$token;
    }
    $mail->send();
    $registered = true;
}

/**
 * Generates a random string and hashes it with SHA256.
 * @return string A random string
 */
function randomString()
{
    return hash('sha256', uniqid('mt_rand', true), false);
}