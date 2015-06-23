<?php
//Get database
require('include/db.php');

//Get config
require 'include/config.php';



    //Get PHPMailer
    require('phpmailer/PHPMailerAutoload.php');
    //Get mail config
    require('include/mailconfig.php');

$GetUserInfo = null;
$usernameRequest = null;

    $mail = new PHPMailer();

    if(Mailconfig::$SMTPAuth == true)
    {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    }
    $mail->Username = Mailconfig::$username;
    $mail->Password = Mailconfig::$password;
    $mail->Port = Mailconfig::$port;

    $mail->Subject = Mailconfig::$subject_register;

    $token = hash('SHA512', uniqid('mt_rand', true), false);
if(isset($_POST['usernameReq']))
{
    $GetUserInfo = $db->prepare('select * from users where username = :username');
    $GetUserInfo->bindParam(':username', $_POST["usernameReq"]);
    $GetUserInfo->execute();
    $usernameRequest = $GetUserInfo->fetch(PDO::FETCH_OBJ);

    if ($usernameRequest != null)
    {
        $InsertRec = $db->prepare('INSERT INTO recoveries (token, user_ID, expiration_date) VALUES (:Token,:user_ID,:expiration_date)');
        $InsertRec->bindParam(':Token', $token);
        $InsertRec->bindParam(':user_ID', $usernameRequest->ID);
        $InsertRec->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 600));
        $InsertRec->execute();


        $stmt = $db->prepare('SELECT alt_email FROM users WHERE username = :username');
        $stmt->bindParam(':username', $_POST['usernameReq']);
        $stmt->execute();
        $email = $stmt->fetch(PDO::FETCH_OBJ);
        //var_dump($email);
        $mail->Body = '<p>u kunt hier een nieuw email invoeren:</p><p><a href="' . Config::$root_url . '"editregistration.php?Recover&token=' . $token . '"></a></p>';
        $mail->AltBody = 'u kunt hier een nieuw email invoeren: ' . Config::$root_url . 'editregistration.php?Recover&token=' . $token;
        $mail->addAddress($email->alt_email);
        $mail->send();
    }
    else
    {
        echo "Account is niet bij ons bekend";
    }
}