<?php
    /** 
     * db.php
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
     * Using RedBean framework in file rb.php.
     */
    require "rb.php";

    R::setup( 'mysql:host=localhost;dbname=paklopav','paklopav', 'webove aplikace' ); 

    /**
     * Start session.
     */
    session_start();
?>