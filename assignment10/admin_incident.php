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
$orderBy = "ORDER BY pmkIncId";

$query  = "SELECT pmkIncId, fnkRepEmail, fnkZip, fldIncStreet, fldIncDate, fldIncidentTime, fldIncDescription, ";
$query .="fldInjuries, fldInjurySeverity, fnkPerpPlate, fnkPerpPlateState ";
$query .= "FROM tblIncident " . $orderBy;

if ($debug)
    print "<p>sql " . $query;

$incident = $thisDatabase->select($query);

if ($debug) {
    print "<pre>";
    print_r($incident);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results

print"<h1> Admin Prefrences - Edit or delete records </h1>";
print"<h2> Incident Table </h2>";


print"<h2> In order to maintain data integrity please only add incident reports throguh the main form found <a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/report_a_buzzer.php'> here </a></h2>";
print"<br>";

print "<ul>\n";

foreach ($incident as $incident) {

    print "<li>";
    if ($admin) {
        print '<a href="admin_incident_form.php?id=' . $incident["pmkIncId"] . '">[Edit]</a> ';
    }
    print $incident['fnkRepEmail'] . " - " . $incident['fldIncStreet'] . " " . $incident['fnkZip'] . "</li>\n";
}
print "</ul>\n";
print "</article>";
include "footer.php";
?>