<?php

require 'include/db.php';

session_start();

if(isset($_SESSION['user_ID']))
{
    $is_admin = userIsAdmin($_SESSION['user_ID']);
}
else
{
    $is_admin = false;
}

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