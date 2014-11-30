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
$orderBy = "ORDER BY pmkPerpPlate";

$query  = "SELECT pmkPerpPlate, pmkPerPlateState, fldPerpCarMake, fldPerpCarColor ";
$query .= "FROM tblPerpetrator " . $orderBy;

if ($debug)
    print "<p>sql " . $query;

$buzzer = $thisDatabase->select($query);

if ($debug) {
    print "<pre>";
    print_r($buzzer);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results

print"<h1> Admin Prefrences - Add, edit or delete records </h1>";
print"<h2> Reporter Table </h2>";


print"<h2> When adding a new Reporter please consider adding an entire incident in the form found <a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/report_a_buzzer.php'> here </a></h2>";
print"<br>";

print "<ul>\n";

foreach ($buzzer as $buzzer) {

    print "<li>";
    if ($admin) {
        print '<a href="admin_reporter_form.php?id=' . $buzzer["pmkPerpPlate"] . $buzzer["pmkPerpPlateState"] . '">[Edit]</a> ';
    }
    print $buzzer['pmkPerpPlate'] . " " . $buzzer['pmkPerpPlateState'] . "  -  " . $buzzer['fldPerpCarColor'] . $buzzer['fldPerpCarMake'] . "</li>\n";
}
print "</ul>\n";
print "</article>";
include "footer.php";
?>