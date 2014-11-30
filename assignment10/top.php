<!DOCTYPE html>
<html lang="en">
    <head>
        <title>BuzzKiller</title>
        <meta charset="utf-8">
        <meta name="author" content="Jake Warshaw">
        <meta name="description" content="Buzzkiller - Creating safer roads for cyclist and cars">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="style.css" type="text/css" media="screen">

        <?php
        $debug = false;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;

        $domain = "http://";
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS']) {
                $domain = "https://";
            }
        }

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries
//

        require_once('../lib/security.php');
   
        if ($debug) {
            print"<p>security ran</p>";
        }
        
       if ($path_parts['filename'] == "index") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename index ran</p>";
        }
        
        if ($path_parts['filename'] == "home") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename home ran</p>";
        }
        
         if ($path_parts['filename'] == "bicyle_safety") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename bicycle safety ran</p>";
        }
        
         if ($path_parts['filename'] == "report_a_buzzer") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename Report_a_buzzer ran</p>";
        }
        
         if ($path_parts['filename'] == "search_statistics_locations") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
         if ($path_parts['filename'] == "search_statistics_cars") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename search_statistics ran</p>";
        }
        
        if ($path_parts['filename'] == "search_buzzer") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename search_buzzer ran</p>";
        }
          
        
        if ($path_parts['filename'] == "bicycle_safety") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename bicycle safety ran</p>";
        }
        
        if ($path_parts['filename'] == "admin_index") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
       if ($debug) {
            print"<p>filename admin_index ran</p>";
        }
        
         if ($path_parts['filename'] == "admin_reporter") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_reporter ran</p>";
        }
        
        if ($path_parts['filename'] == "admin_reporter_form") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_reporter_form ran</p>";
        }
        
          if ($path_parts['filename'] == "admin_buzzer") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_buzzer ran</p>";
        }
        
        if ($path_parts['filename'] == "admin_buzzer_form") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_buzzer_form ran</p>";
        }
        
          if ($path_parts['filename'] == "admin_incident") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_incident ran</p>";
        }
        
        if ($path_parts['filename'] == "admin_incident_form") {
            include "../lib/validation-functions.php";
            include "../lib/mail-message.php";
            require('../bin/myDatabase.php');
        }
        
        if ($debug) {
            print"<p>filename admin_incident_form ran</p>";
        }
        
        
         if ($debug) {
            print"<p>security ran</p>";
        }
        ?>	

    </head>
    <!-- ################ body section ######################### -->

<?php
    //Access the Database 
    $dbUserName = get_current_user() . '_admin';
    $whichPass = "a"; //flag for which one to use.
    $dbName = strtoupper(get_current_user()) . '_buzzKiller';

    $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);

    /* ##### html setup */
    
    
    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
    $path_parts = pathinfo($phpSelf);
    
    print '<body id="' . $path_parts['filename'] . '">';
        
    include "header.php";
    ?>
