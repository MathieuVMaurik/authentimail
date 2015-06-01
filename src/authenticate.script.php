<?php

require 'include/db.php';

session_start();

$errors = array();
$authenticated = false;

if(isset($_GET['token']))
{
    $stmt = $db->prepare('SELECT * FROM authentications WHERE token = :token');
    $stmt->bindParam(':token', $_GET['token']);
    $stmt->execute();

    $authentication = $stmt->fetch(PDO::FETCH_OBJ);

    if($authentication)
    {
        if(strtotime($authentication->expiration_date) > time())
        {
            //User authenticated
            $stmt = $db->prepare('SELECT * FROM users WHERE ID = :id');
            $stmt->bindParam(':id', $authentication->user_ID);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            $_SESSION['user_ID'] = $user->ID;
            $_SESSION['user_name'] = $user->username;
            $authenticated = true;

            //Delete all pending authentications
            $stmt = $db->prepare("DELETE FROM authentications WHERE user_ID = :id");
            $stmt->bindParam(':id', $user->ID);
            $stmt->execute();
        }
        else
        {
            $errors[] = "Deze link is niet meer geldig. Probeer opnieuw in te loggen.";
        }
    }
    else
    {
        //User not authenticated
        header('HTTP/1.0 404 Not Found');
        echo '404';
        exit();
    }
}
else
{
    header('HTTP/1.0 404 Not Found');
    echo '404';
    exit();
}