<?php

require '../include/db.php';
require '../include/config.php';

session_start();

//Check if user is admin. If not, redirect to 404.
if(!isset($_SESSION['user_ID']) || !userIsAdmin($_SESSION['user_ID']))
{
    header('Location: '.Config::$root_url.'errors/404.php');
    exit();
}

$offset = 0; //Temporary offset variable, will be used for multiple pages

$stmt = $db->prepare('SELECT * FROM users LIMIT 10 OFFSET :offset');
$stmt->bindParam(':offset', $offset);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_OBJ);

/**
 * Checks if the user is an admin.
 * @param int $user_ID The user ID to check for admin access.
 * @return bool
 */
function userIsAdmin($user_ID)
{
    global $db;

    $stmt = $db->prepare('SELECT * FROM users WHERE ID = :id AND is_admin = 1');
    $stmt->bindParam(':id', $user_ID);
    $stmt->execute();

    if($stmt->fetch(PDO::FETCH_OBJ))
    {
        return true;
    }
    else
    {
        return false;
    }
}