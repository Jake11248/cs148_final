
 
<?php
include "top.php";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;

if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}

if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

if ($debug)
    print "<p>step 1</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$data = array();

$Zip = "";
$Street = "";
$Time = "";
$Injuries = "";
$InjSever = "";

if ($debug)
    print "<p>step 2</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$ZipERROR = false;
$StreetERROR = false;
$TimeERROR = false;
$InjuriesERROR = false;
$InjSeverERROR = false;

if ($debug)
    print "<p>step 3</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

if ($debug)
    print "<p>step 4</p>";

// array used to hold form values that will be written to a CSV file
//$dataRecord = array();

//$mailed=false; // have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
    
    if ($debug)
    print "<p>step 5</p>";
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    $Zip = htmlentities($_POST["txtZip"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Zip;
    
    $Street = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Street;

    $Time = htmlentities($_POST["lstTime"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Time;
  
    $Injuries = htmlentities($_POST["radInjuries"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Injuries;
    
    $InjSever = htmlentities($_POST["lstInjSever"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $InjSever;

    
    if ($debug)
    print "<p>step 6/p>";
   

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

    
    //verify License Plate Number 
    if ($Zip == "") {
    }
        elseif (!verifyAlphaNum($Zip)) {
        $errorMsg[] = "The zip code  appears to have unrecognized characters";
        $ZipERROR = true;
    }
    
     if ($Street == "") {
    } elseif (!verifyAlphaNum($Street)) {
        $errorMsg[] = "The street appears to have unrecognized characters.";
        $StreetERROR = true;
    }
    
    
    if ($Time == "") {
    }
        elseif (!verifyTime($Time)) {
        $errorMsg[] = "The Time appears to have unrecognized characters";
        $TimeERROR = true;
    }
    
    
     if ($InjSever == "") {
    }
        elseif (!verifyAlphaNum($InjSever)) {
        $errorMsg[] = "The injury Severity selection appears to not be working";
        $InjSeverERROR = true;
    }

    if ($debug)
    print "<p>step 7</p>";

     //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";


        
        
    } // end form is valid
    
} // ends if form was submitted.
   
    
    


//#############################################################################
//
// SECTION 3 Display Form
//

?>
 

<article id="main">
       <aside id="searchLocationText"> 
        <h3>
            Want to play with the Numbers?
        </h3>

        <p>
           So now you are thinking, should I ride on that road. Well here is a 
           way to figure it out. You can search by any or all of the criteria below.
        </p>
        
        <p>
            Play with the numbers. See what roads around you are safe and which
            are not. Figure out which roads you want to ride when. Decide if that 
            5:00 ride is worth it or should you just go out tomorrow morning.
        </p>
        <h3>
            Simply put here are the statistics that allow you to make an educated
            decision about when and where you are going to ride. 
        </h3>
   </aside>
    
    

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
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
       
    if ($debug){
    print_r($errorMsg);
    }
    
    //BEGIN  ADDITION FOR SQL 
    /* open up the database, create the SQL statment, and querry the database. */

    /* ##### Step one 
     * 
     * create your database object using the appropriate database username

    */
    
    if ($debug)
    print "<p>step 8 </p>";
    
    //build the Query  
        $query = 'SELECT  fnkZip AS Zip, fldIncStreet AS Street, fldIncDate AS "Incident Date", '; 
        $query .= 'fldIncidentTime AS Time, fldInjuries AS Injuries, ';
        $query .= 'fldInjurySeverity AS "Injury Severity"';
        $query .= 'FROM tblIncident ';
        
        //Zip Code
        $query .= 'WHERE fldIncidentTime LIKE ? '; 
        $data[] = $Time . "%";

   //======If statements============
        //street
   if ($Street != ''){
       $query .= 'AND fldIncStreet LIKE ? ';
       $data[] = $Street . "%";
   }
   
   //Time
   if ($Zip != ''){
       $query .= 'AND fnkZip LIKE ? ';
       $data[] = $Zip;
   }
   
   //Injuries
   if ($Injuries != ''){
       $query .= 'AND fldInjuries LIKE ? ';
       $data[] = $Injuries;
   }
   
   //Injury Severity 
   if ($InjSever != ''){
       $query .= 'AND fldInjurySeverity LIKE ? ';
       $data[] = $InjSever;
   }
   
   
        
//printing out the query and the array if debug is turned on 
if ($debug){    
    print "<p>SQL: " .$query;
    print "<p><pre>";
    print_r($data);
    print"</pre></p>";  
    }
    
     /* ##### Step three
     * Execute the query */

     
    $results = $thisDatabase->select($query, $data);

    
     /* ##### Step four
     * prepare output and loop through array
 
     */
   //count numebr of records 

    $numberRecords = count($results); 

    print"<br>";
    
    print "<h1 id='numBuzzTimes'>There are ". $numberRecords . " occurances of buzzing with these paramters</h1>";
    print"<h3> Refine your search below </h3>";
    
    
    //if debug is turned on print the query out again 
    if ($debug){
         print "<h3>SQL: " . $query . "</h3>";
    }
    

        print "<table>";

         $firstTime = true;

         /* since it is associative array display the field names */
         foreach ($results as $row) {
             if ($firstTime) {
                 print "<thead><tr>";
                 $keys = array_keys($row);
                 foreach ($keys as $key) {
                     if (!is_int($key)) {
                         print "<th>" . $key . "</th>";
                     }
                 }
                 print "</tr>";
                 $firstTime = false;
             }

             /* display the data, the array is both associative and index so we are
              *  skipping the index otherwise records are doubled up */
             print "<tr>";
             foreach ($row as $field => $value) {
                 if (!is_int($field)) {
                     print "<td>" . $value . "</td>";
                 }
             }
             print "</tr>";
         }
         print "</table>";



         }
         else {
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
    }

        ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmLocationSearch">

            <fieldset class="wrapper">

                <fieldset class="wrapperTwo">
                    <legend>Fill in any or all of the following fields:</legend>
                    <fieldset class="form">
                        
            <!-- Zip Code  --> 
                         <label for="txtZip" class="required">Zip Code 
                            <input type="text" id="txtZip" name="txtZip"
                                   value="<?php print $Zip; ?>"
                                   tabindex="100" maxlength="30" placeholder="Zip Code"
                                   <?php if ($ZipERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                         </label>
                        
            <!-- Street -->
                        <label for="txtStreet" class="required">Street  
                            <input type="text" id="txtStreet" name="txtStreet"
                                   value="<?php print $Street; ?>"
                                   tabindex="110" maxlength="30" placeholder="Enter The Street"
                                   <?php if ($StreetERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
            <!-- Time -->
                       <label id="lstTime"> Time of Incident to the nearest Half Hour
                       <select id="listTime" 
                               name="lstTime" 
                               tabindex="120" 
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
                               if($IncTime == $row["pmkTime"]);
                               print "$row[pmkTime]</option>";
                           }
                           ?>

                        </select>
                     </label>
            
                   <!--Injuries Yes/No? -->

                   <label id="radInjuries"> Injuries? </label>
                                        <input 
                                            type="radio" 
                                            id="radYesInj" 
                                            name="radInjuries" 
                        <?php if ($Injuries == "Yes") echo 'checked = "checked" '; ?>
                                            value="Yes" 
                                            tabindex="140" 
                                            >Yes
                                        
                                        <input 
                                            type="radio" 
                                            id="radNoInj" 
                                            name="radInjuries"
                        <?php if ($Injuries == "No") echo 'checked = "checked" '; ?>
                                            value="No" 
                                            tabindex="150"
                                            >No
                      
                            
                <!--Injuries severity 1 -10  -->

                    <label id="lstInjSever"> Severity of Injuries
                         <select id="lstInjurySever" 
                                 name="lstInjSever" 
                                 tabindex="160" 
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
                         if($InjSever == $row["fldSeverity"]);
                         print "$row[fldSeverity]</option>";
                     }
                 ?>   
                </select>
              </label>
                   
                     </fieldset> <!-- ends contact -->
                    
                </fieldset> <!-- ends wrapper Two -->
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search Stats" tabindex="3000" class="button">
                </fieldset> <!-- ends buttons -->
                
            </fieldset> <!-- Ends Wrapper -->
        </form>



</article>



<?php
include "footer.php";
?>

</body>
</html>