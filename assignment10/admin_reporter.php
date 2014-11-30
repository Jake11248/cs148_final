<?php

/* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
 * the purpose of this page is to display a list of reporters sorted 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: November 20, 2014
 * 
 * Revosedf by Jacob Warshaw 11/30/14
 */
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
$admin = true;
include "top.php";

print "<article>";
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// prepare the sql statement
$orderBy = "ORDER BY fldRepLName";

$query  = "SELECT pmkRepEmail, fldRepFName, fldRepLName, fnkRepZip ";
$query .= "FROM tblReporter " . $orderBy;

if ($debug)
    print "<p>sql " . $query;

$reporter = $thisDatabase->select($query);

if ($debug) {
    print "<pre>";
    print_r($reporter);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results

print"<h1> Admin Prefrences - Add, edit or delete records </h1>";
print"<h2> Reporter Table </h2>";

print"<br>";

print"<h2> To add a new Reporter, please add an entire incident in the form found <a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/report_a_buzzer.php'> here </a></h2>";


print "<ul>\n";

foreach ($reporter as $reporter) {

    print "<li>";
    if ($admin) {
        print '<a href="admin_reporter_form.php?id=' . $reporter["pmkRepEmail"] . '">[Edit]</a> ';
    }
    print $reporter['fldRepFName'] . " " . $reporter['fldRepLName'] . "  -  " . $reporter['pmkRepEmail'] . "</li>\n";
}
print "</ul>\n";
print "</article>";
include "footer.php";
?>