<?php
    /** 
     * logout.php
     * @author Pavel Paklonski
     * 
     */
    
    /**
     * Showing errors.
     */
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    /**
     * Database connection.
     */
    require 'db.php';

    /**
     * Unsets logged in user's session.
     */
    unset($_SESSION['logged_user']);
    
    header('Location: index.php');
?>