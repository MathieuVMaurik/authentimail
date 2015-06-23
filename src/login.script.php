<?php

require('include/db.php');

//Get config
require 'include/config.php';

session_start();

$errors = array();

if(isset($_POST['email']))
{
    //Get PHPMailer
    require('phpmailer/PHPMailerAutoload.php');
    //Get mail config
    require('include/mailconfig.php');

    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email AND active = 1');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);

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
    $mail->Subject = Mailconfig::$subject_login;

    if($user)
    {
        //User found

        //Delete all old authentications
        $stmt = $db->prepare("DELETE FROM authentications WHERE user_ID = :id");
        $stmt->bindParam(':id', $user->ID);
        $stmt->execute();

        $token = hash('SHA512', uniqid('mt_rand', true), false);

        $stmt = $db->prepare("INSERT INTO authentications (token, user_ID, expiration_date) VALUES (:token, :user_ID, :expiration_date)");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_ID', $user->ID);
        $stmt->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 600));
        /*
        var_dump($stmt);
        echo '<br />'.$token;
        echo '<br />'.$user->ID;
        echo '<br />'.date('Y-m-d H:i:s', time() + 1800).'<br />';
        */

        $stmt->execute();

        $mail->Body = '<p>Your login URL: <a href="'. Config::$root_url .'authenticate.php?token='.$token.'">Click here to login.</a></p>';
        $mail->AltBody = 'Your login url: '. Config::$root_url .'authenticate.php?token='.$token;

        $mail->send();
    }
}