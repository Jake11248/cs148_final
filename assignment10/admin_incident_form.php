<?php
/* 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: November 20, 2014
 * 
 * Edited by Jacob Warshaw 11/30/14
 */
include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
$debug = false;
if (isset($_GET["debug"])) { // create a debugging environment
    $debug = false;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";
//
// SECTION: 1 Initialize variables
$update = false;
$deleteRecord = false;
$delete= "";

// SECTION: 1a.
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
if ($debug)
    print"intialalize variable step";
if (isset($_GET["id"])) {
    $pmkIncId = htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");
    $query = 'SELECT fnkZip, fldIncStreet, fldIncDate, fldIncidentTime,  ';
    $query .= 'fldIncDescription, fldInjuries, fldInjurySeverity ';
    $query .= 'FROM tblIncident WHERE pmkIncId = ?';
    
    $results = $thisDatabase->select($query, array($pmkIncId));
    
    $IncZip = $results[0]["fnkZip"];
    $IncStreet = $results[0]["fldIncStreet"];
    $IncDate = $results[0]["fldIncDate"];
    $IncTime = $results[0]["fldIncidentTime"];
    $InjDesc = $results[0]["fldIncDescription"];
    $IncInj = $results[0]["fldInjuries"];
    $IncInjSev = $results[0]["fldInjurySeverity"];
    
} else {
    $IncZip = "";
    $IncStreet = "";
    $IncDate = "";
    $IncTime = "";
    $IncDesc = "";
    $IncInj = "";
    $IncInjSev = "";
}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$IncZipERROR = false;
$IncStreetERROR = false;
$IncDateERROR = false;
$IncTimeERROR = false;
$IncDescERROR = false;
$IncInjERROR = false;
$IncInjSevERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
$data = array();
$data1 = array();
$dataEntered = false;
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    /*    if (!securityCheck(true)) {
      $msg = "<p>Sorry you cannot access this page. ";
      $msg.= "Security breach detected and reported</p>";
      die($msg);
      }
     */
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
 
    $delete = htmlentities($_POST["chkDelete"], ENT_QUOTES, "UTF-8");
    if ($delete != "") {
        $deleteRecord = true;
    } 
    
    $pmkIncId = htmlentities($_POST["hidIncId"], ENT_QUOTES, "UTF-8");
    if ($pmkIncId > 0) {
        $update = true;
    }
    
    
    // I am not putting the ID in the $data array at this time
    $IncZip = htmlentities($_POST["txtIncZip"], ENT_QUOTES, "UTF-8");
    $data[] = $IncZip;
    
    $IncStreet = htmlentities($_POST["txtIncStreet"], ENT_QUOTES, "UTF-8");
    $data[] = $IncStreet;
    
    $IncDate = htmlentities($_POST["txtIncDate"], ENT_QUOTES, "UTF-8");
    $data[] = $IncDate;
    
    $IncTime = htmlentities($_POST["lstIncTime"], ENT_QUOTES, "UTF-8");
    $data[] = $IncTime;
        

    $IncDesc = htmlentities($_POST["txtIncDesc"], ENT_QUOTES, "UTF-8");
    //    $data[] = $IncDesc;
    
    
    $IncInj = htmlentities($_POST["radInj"], ENT_QUOTES, "UTF-8");
    //$data[] = $IncInj;
    

    $IncInjSev = htmlentities($_POST["lstIncInjSev"], ENT_QUOTES, "UTF-8");
      //  $data[] = $IncInjSev;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//
    if ($IncZip == "") {
    } elseif (!verifyAlphaNum($IncZip)) {
        $errorMsg[] = "The incident zip code appears to be incorrect.";
        $IncZipERROR = true;
    }
    
    
    if ($IncStreet == "") {
        $errorMsg[] = "Please enter the street the buzzing took place on";
        $IncStreetERROR = true;
    } elseif (!verifyAlphaNum($IncStreet)) {
        $errorMsg[] = "The street the buzzing took place on appears to be incorrect.";
        $IncStreetERROR = true;
    }
    
    
    if ($IncDate == "") {
        $errorMsg[] = "Please enter the date when the inncident occured";
        $IncDateERROR = true;
    } elseif (!verifyAlphaNum($IncDate)) {
        $errorMsg[] = "The incident date seems to be incorrect.";
        $IncDateERROR = true;
    }
    
   
    if ($IncDesc == "") {
    } elseif (!verifyAlphaNum($IncDesc)) {
        $errorMsg[] = "The description of the incident appears to be incorrect.";
        $IncDescERROR = true;
    }
    
    
    if ($IncInj == "") {
        $errorMsg[] = "Please enter if there were any injuries associated with the incident";
        $IncInjERROR = true;
    } elseif (!verifyAlphaNum($IncInj)) {
        $errorMsg[] = "The injuries appears to be incorrect.";
        $IncInjERROR = true;
    }
    

    if ($IncTime == "") {
        $errorMsg[] = "Please enter the time the buzzing took place";
        $IncTimeERROR = true;
    } elseif (!verifyTime($IncTime)) {
        $errorMsg[] = "The incident time appears to be incorrect.";
        $IncTimeERROR = true;
    }
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid</p>";
        }
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2e Save Data
//
        $dataEntered = false;
        
        if($deleteRecord) {
            $thisDatabase->db->beginTransaction();
            $query = 'DELETE FROM tblIncident WHERE pmkIncId = ? ';
            $data1[] = $pmkIncId;
            $results = $thisDatabase->update($query, $data1);
            $dataEntered = $thisDatabase->db->commit();
            
            if ($debug){    
                print "<p>SQL: " .$query;
                print "<p><pre>";
                print_r($data1);
                print"</pre></p>";  
                print "<p>transaction complete ";
                print $deleteRecord;
            }

        }
        
       
            try {
                $thisDatabase->db->beginTransaction();
                
                if ($update) {
                    $query = 'UPDATE tblIncident SET ';
                } else {
                    $query = 'INSERT INTO tblIncident SET ';
                }
                $query .= 'fnkZip = ?, ';
                $query .= 'fldIncStreet = ?, ';
                $query .= 'fldIncDate = ?, ';
                $query .= 'fldIncidentTime = ?, ';
                
                if ($IncDesc !=""){ 
                    $query .= 'fldIncDescription = ?, ';
                    $data[] = $IncDesc;
                }
                                
                if ($IncInj !=""){
                    $query .= 'fldInjuries = ?, ';
                    $data[] = $IncInj;
                }
                
                if($IncInjSev != ""){
                    $query .= 'fldInjurySeverity = ? ';
                    $data [] = $IncInjSev;
                }
     
                if ($update) {
                    $query .= 'WHERE pmkIncId = ?';
                    $data[] = $pmkIncId;

                    $results = $thisDatabase->update($query, $data);
                    
                } else {
                    $results = $thisDatabase->insert($query, $data);
                    
                    $primaryKey = $thisDatabase->lastInsert();
                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
                }
            // all sql statements are done so lets commit to our changes
            $dataEntered = $thisDatabase->db->commit();
            
            if ($debug){    
                print "<p>SQL: " .$query;
                print "<p><pre>";
                print_r($data);
                print"</pre></p>";  
                print "<p>transaction complete ";
                print $deleteRecord;
            }
               
        } catch (PDOExecption $e) {
            $thisDatabase->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
        
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if ($dataEntered) { // closing of if marked with: end body submit
        print "<h1>Record Saved</h1> ";
        print"<ul>";
        print"<p><a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/admin_incident.php'> Edit Another Incident Record </a></p>";
        print"<p><a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/admin_index.php'> Return to Admin Index Page </a></p>";
        print"<p><a href='https://jwarshaw.w3.uvm.edu/cs148/assignment10/home.php'> Return Home </a></p>";
        print"</ul>";
        
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>
    
    <p> Make sure to have all required fields - Zip, Street, date, time, if there
        were injuries - populated before submitting any changes. </p>
    
    <p> Currently this form is not properly updating the fields - It is for 
        deleting current records only. The query works correctly but it will not
    properly submit to the database </p>
    
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
            <!-- Info about the Incident -->
                     <fieldset class="wrapper"> 
                        <legend>Information About The Incident</legend>
                        
                        <input type="hidden" id="hidIncId" name="hidIncId"
                       value="<?php print $pmkIncId; ?>"
                       >
                        
                        <!--Incident Zip --> 
                        <label for="txtIncZip" class="required">Zip Code Where Incident Occurred 
                            <input type="text" id="txtIncZip" name="txtIncZip"
                                   value="<?php print $IncZip; ?>"
                                   tabindex="300" maxlength="30" placeholder="Enter The Zip Code of the Incident"
                                   <?php if ($IncZipERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Incident Street  -->
                        <label for="txtIncStreet" class="required">Street Where Incident Occurred 
                            <input type="text" id="txtIncStreet" name="txtIncStreet"
                                   value="<?php print $IncStreet; ?>"
                                   tabindex="305" maxlength="30" placeholder="Enter The Street of the Incident"
                                   <?php if ($IncStreetERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        
                        <!--Incident Date --> 
                        <label for="txtIncDate" class="required">Date When The Incident Occurred (Exactly YYYY-MM-DD)
                            <input type="text" id="txtIncDate" name="txtIncDate"
                                   value="<?php print $IncDate; ?>"
                                   tabindex="310" maxlength="30" placeholder="format - YYYY-MM-DD"
                                   <?php if ($IncDateERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Incident Time -->
                        <label id="lstIncTime"> Time of Incident to the nearest Half Hour
                        <select id="listIncTime" 
                                name="lstIncTime" 
                                tabindex="315" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkTime FROM tblTime ';
                            $query .= 'where pmkTime not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($IncTime == $row["pmkTime"]) ;
                                print "$row[pmkTime]</option>";
                            }
                            ?>

                         </select>
                      </label>
                        
                        <!--Incident Description --> 
                        <label for="txtIncDesc" class="required">Short Description of The Incident 
                            <input type="text" id="txtIncDesc" name="txtIncDesc"
                                   value="<?php print $IncDesc; ?>"
                                   tabindex="320" maxlength="150" placeholder="Enter a Description of the Incident"
                                   <?php if ($IncDescERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Injuries Yes/No? -->

                                  <label id="radInj"> Where There any Injuries?  </label>
                                        <input 
                                            type="radio" 
                                            id="radYesInj" 
                                            name="radInj" 
                <?php if ($IncInj == "Yes") echo 'checked = "checked" '; ?>
                                            value="Yes" 
                                            tabindex="330" 
                                            >Yes 
                                   
                              
                                        <input 
                                            type="radio" 
                                            id="radNoInj" 
                                            name="radInj"
                <?php if ($IncInj == "No") echo 'checked = "checked" '; ?>
                                            value="No" 
                                            tabindex="340"
                                            >No
                                    


                       <!--Injuries severity 1 -10  -->
                       
                       <label id="lstIncInjSev"> Severity of Injuries
                        <select id="lstIncInjSeverity" 
                                name="lstIncInjSev" 
                                tabindex="350" 
                                size="1"> 
                        
                            <option>  </option>
                     <?php
                    //write the query that will generate the list box 
                    $query = 'SELECT DISTINCT fldSeverity FROM tblSeverity ';
                    $query .= 'where fldSeverity not LIKE ""';

                   if($debug){
                   print "<p>SQL: " .$query;
                   print "<p><pre>";

                   var_dump($resuts);
                   }


                    //get eash row of the query and generate a list box element for it
                     $results = $thisDatabase->select($query);

                    foreach($results as $row){
                        print'<option> '; 
                        if($IncSeverity == $row["fldSeverity"]);
                        print "$row[fldSeverity]</option>";
                    }
                ?>   
                </select>
              </label>
                       
      <!--Delete Record?-->
            <label><input type="checkbox" 
                                  id="chkDelete" 
                                   name="chkDelete" 
            <?php if ($delete) echo ' checked="checked" '; ?>
                                   value="Delete Record" 
                                   tabindex="200" 
                                   > Delete Record? </label>   
                        
                    </fieldset> <!-- ends information about the incident -->
            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->

        </form>
        <?php
    } // end body submit
    ?>
</article>

<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>
<!-- </article> -->
</body>
</html>