<?php

require 'include/db.php';

session_start();

if(isset($_GET['token']))
{
    $stmt = $db->prepare('SELECT * FROM authentications WHERE token = :token');
    $stmt->bindParam(':token', $_GET['token']);
    $stmt->execute();

    $authentication = $stmt->fetch(PDO::FETCH_OBJ);

    if($authentication)
    {
        //User authenticated
        $stmt = $db->prepare('SELECT * FROM users WHERE ID = :id');
        $stmt->bindParam(':id', $authentication->user_ID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $_SESSION['user_ID'] = $user->ID;
        $_SESSION['user_name'] = $user->username;
        echo '<p>Success!</p>';
        echo '<p><a href="index.php">Terug</a></p>';
    }
    else
    {
        //User not authenticated
        echo 'Invalid token!';
    }
}
else
{
    header('HTTP/1.0 404 Not Found');
    echo '404, $_GET["REKT"]';
}