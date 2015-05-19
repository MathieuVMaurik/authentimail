<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 12-5-2015
 * Time: 11:32
 */

require('include/db.php');

session_start();

$errors = array();

if(isset($_POST['email']))
{
    require('phpmailer/PHPMailerAutoload.php');
    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = 'john@localhost';
    $mail->Password = 'secret';
    $mail->Port = 587;
    $mail->addAddress('derp@localhost');

    if($user)
    {
        //User found
        $token = hash('SHA512', uniqid('mt_rand', true), false);

        $stmt = $db->prepare("INSERT INTO authentications (token, user_ID, expiration_date) VALUES (:token, :user_ID, :expiration_date)");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_ID', $user->ID);
        $stmt->bindParam(':expiration_date', date('Y-m-d H:i:s', time() + 1800));
        /*
        var_dump($stmt);
        echo '<br />'.$token;
        echo '<br />'.$user->ID;
        echo '<br />'.date('Y-m-d H:i:s', time() + 1800).'<br />';
        */

        $stmt->execute();

        $mail->Body = '<p>Your login URL: <a href="http://localhost/authentimail/authenticate.php?token='.$token.'">Click, ya dingus</a></p>';
        $mail->AltBody = 'Your login url: http://localhost/authentimail/authenticate.php?token='.$token;

    }
    else
    {
        //User not found
        $mail->Body = 'User not found';
        $mail->AltBody = 'User not found';
    }
    if($mail->send())
    {
        echo "Mail sent.";
    }
    else
    {
        echo "Mail not sent!";
    }
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Inloggen</title>
    </head>
    <body>
        <h1>Inloggen</h1>

        <form method="post">
            <p>
                <label for="email">Email</label>
                <input name="email" type="text" />
            </p>
            <p>
                <input name="submit" value="Login" type="submit" />
            </p>
        </form>

    </body>
</html>