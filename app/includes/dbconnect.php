<?php


const DBHOST = 'database';
const DBNAME = 'blog';
const DBUSER = 'admin';
const DBPASS = 'admin7791';


try {
    $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
    $pdo = new PDO($dsn, DBUSER, DBPASS);

    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $connected =  '<p>connected</p>';
} catch (PDOException $exception) {
    die($failed = 'Message : ' . $exception->getMessage());
}
