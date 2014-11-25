
 
<?php
include "top.php";
include "nav.php";

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

$licensePlate = "";
$state = "";

if ($debug)
    print "<p>step 2</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$licensePlateERROR = false;
$stateERROR = false;

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

  $licensePlate = htmlentities($_POST["txtlicensePlate"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $licensePlate;
    
   $state = htmlentities($_POST["lstState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $state;

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
    if ($licensePlate == "") {
        $errorMsg[] = "Please enter the license plate you are searching for";
        $licensePlateERROR = true;
    }
        elseif (!verifyAlphaNum($licensePlate)) {
        $errorMsg[] = "The license plate appears to have unrecognized characters";
        $licensePlateERROR = true;
    }
    
    if ($state == "") {
        $errorMsg[] = "Please enter the state of the license plate you are searching for";
        $stateERROR = true;
    }
        elseif (!verifyAlphaNum($state)) {
        $errorMsg[] = "The state appears to have unrecognized characters";
        $stateERROR = true;
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
        $query = 'SELECT  pmkIncId '; 
        $query .= 'FROM tblIncident ';
        $query .= 'WHERE fnkPerpPlate LIKE ? AND fnkPerpPlateState LIKE ?'; 
        $data[] = $licensePlate;
        $data[] = $state;


//pritn out the query and the array if debug is turned on 
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

    
    print "<h2 id='numBuzzTimes'>This license plate has been recorded ". $numberRecords . " times</h2>";
    print"<h3> Search for another buzzer below </h3>";
    
    
    //if debug is turned on print the query out again 
    if ($debug){
         print "<h3>SQL: " . $query . "</h3>";
    }
    

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
    }

        ?>
   <aside id="searchBuzzerText"> 
        <h3>
            Curious to see if your buzzer is a repeat offender?
        </h3>

        <p>
           Maybe the person who buzzed you is a repeat offender. Or maybe you want to 
           see if anyone you know has been reported as a buzzer. Maybe <strong>YOU</strong>
           have been reported as a buzzer. There is only one way to find out. Simply 
           put in the license plate number and state of the license plate you are looking 
           for and <strong>WHOOOOOSH</strong> all the information you are looking for 
           suddenly appears before your eyes. 
        </p>
   </aside>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmClassSearch">

            <fieldset class="wrapper">
                <legend>Search for Buzzer:</legend>

                <fieldset class="wrapperTwo">
                    <legend>Enter a buzzer's license plate</legend>
                    <fieldset class="contact">
                        <legend></legend>
                        
                        <!-- search for license plate  --> 
                         <label for="txtlicensePlate" class="required">License Plate Number
                            <input type="text" id="txtsubject" name="txtlicensePlate"
                                   value="<?php print $licensePlate; ?>"
                                   tabindex="100" maxlength="45" placeholder="format - ell033 (no spaces)"
                                   <?php if ($licensePlateERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
         
                   
                        <label id="lstState"> License Plate State 
                        <select id="listState" 
                                name="lstState" 
                                tabindex="220" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkStateName FROM tblState ';
                            $query .= 'where pmkStateName not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($State == $row["pmkStateName"]) print ' selected = "selected" ';
                                print "$row[pmkStateName]</option>";
                            }
                            ?>

                         </select>
                            
                     </fieldset> <!-- ends contact -->
                    
                </fieldset> <!-- ends wrapper Two -->
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search Buzzer" tabindex="3000" class="button">
                </fieldset> <!-- ends buttons -->
                
            </fieldset> <!-- Ends Wrapper -->
        </form>



</article>



<?php
include "footer.php";
?>

</body>
</html>