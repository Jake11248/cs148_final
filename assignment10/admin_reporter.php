<?php


/* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
 * the purpose of this page is to display a list of poets sorted 
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
print "<ol>\n";

foreach ($reporter as $reporter) {

    print "<li>";
    if ($admin) {
        print '<a href="form.php?id=' . $reporter["pmkRepEmail"] . '">[Edit]</a> ';
    }
    print $reporter['fldRepFName'] . " " . $reporter['fldRepLName'] . "  -  " . $reporter['pmkRepEmail'] . "</li>\n";
}
print "</ol>\n";
print "</article>";
include "footer.php";
?>