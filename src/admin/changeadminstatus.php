<?php

require '../include/db.php';
require '../include/config.php';

session_start();

//Check if user is admin. If not, give a 404 error.
if(!isset($_SESSION['user_ID']) || !userIsAdmin($_SESSION['user_ID']))
{
    //User is not admin.
    HttpNotFound();
}

//Checks if post data is valid. "status" must be 0 or 1, and "userID" must be numeric.
if(isset($_POST['status']) && ($_POST['status'] == 0 || $_POST['status'] == 1) && (isset($_POST['userID']) && is_numeric($_POST['userID'])))
{
    $stmt = $db->prepare('UPDATE users SET is_admin = :status WHERE ID = :userid');
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':userid', $_POST['userID']);
    if(!$stmt->execute())
    {
        //The update failed for some reason, so return an error to let the user know.
        header('HTTP/1.0 500 Internal Server Error');
        exit();
    }
}
else
{
    //Post data was not valid.
    HttpNotFound();
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

/**
 * Gives a 404 error to the client, and optionally stops the script.
 * @param bool $exit whether or not to stop the script after giving the error. Defaults to true.
 */
function HttpNotFound($exit = true)
{
    header('HTTP/1.0 404 Not Found');
    header('Location: '.Config::$root_url.'errors/404.php');
    if($exit == true)
    {
        exit();
    }
}