<?php

/*return array(
    'SMTPAuth' => true,
    'username' => 'john@localhost',
    'password' => 'secret',
    'port' => 587,
    'subject_login' => 'Authentimail login',
    'subject_register' => 'Authentimail registratie',
);*/

class Mailconfig
{
    public static $SMTPAuth = true;
    public static $username = 'john@localhost';
    public static $password = 'secret';
    public static $port = 587;
    public static $subject_login = 'Authentimail login';
    public static $subject_register = 'Authentimail registratie';
}