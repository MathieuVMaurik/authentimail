<?php

$params = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'username' => 'root',
    'password' => '',
    'dbname'=>'authentimail',
);

global $db;
$db = new PDO("mysql:host={$params['host']};port={$params['port']};dbname={$params['dbname']};", $params['username'], $params['password'], array());

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);