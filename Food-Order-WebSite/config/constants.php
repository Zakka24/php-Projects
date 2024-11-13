<?php
    // Start a session
    session_start();

    ini_set('display_errors',1);
    error_reporting(E_ALL);


    define('SITEURL', 'http://localhost/php-projects/Food-Order-WebSite/');
    
    // Costants to connect to the DB
    define('LOCALHOST', 'localhost');
    define('DB_USER', 'root');
    define('PASSWORD', '');
    define('DB_NAME', 'food-order');

    // Connection to MySQL and database
    $conn = mysqli_connect(LOCALHOST, DB_USER, PASSWORD);
    if(!$conn){
        die("Errore di connessione a MySQL: ". mysqli_connect_error());
    }
    $db_select = mysqli_select_db($conn, DB_NAME);
    if(!$db_select){
        die("Errore di connessione al database food-order: " . mysqli_error($conn));
    }
?>