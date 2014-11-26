
 
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

$Make = "";
$Color = "";
$State = "";
$Injuries = "";
$InjSever = "";
$Distinct = "";

if ($debug)
    print "<p>step 2</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$MakeERROR = false;
$ColorERROR = false;
$StateERROR = false;
$InjuriesERROR = false;
$InjSeverERROR = false;
$DistintERROR = false;

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

    $Make = htmlentities($_POST["lstMake"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Make;
    
    $Color = htmlentities($_POST["lstColor"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Color;

    $State = htmlentities($_POST["lstState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $State;
  
    $Injuries = htmlentities($_POST["radInjuries"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Injuries;
    
    $InjSever = htmlentities($_POST["lstInjSever"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $InjSever;

    $Distinct = htmlentities($_POST["chkDistinct"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Distinct;
    
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
    if ($Make == "") {
    }
        elseif (!verifyAlphaNum($Make)) {
        $errorMsg[] = "The car make  appears to have unrecognized characters";
        $MakeERROR = true;
    }
    
     if ($Color == "") {
    } elseif (!verifyAlphaNum($Color)) {
        $errorMsg[] = "The car color appears to have unrecognized characters.";
        $ColorERROR = true;
    }
    
    
    if ($State == "") {
    }
        elseif (!verifyAlphaNum($State)) {
        $errorMsg[] = "The State appears to have unrecognized characters";
        $StateERROR = true;
    }
    
    
     if ($InjSever == "") {
    }
        elseif (!verifyAlphaNum($InjSever)) {
        $errorMsg[] = "The injury Severity selection appears to not be working";
        $InjSeverERROR = true;
    }
    
     if ($Distinct == "") {
    }
        elseif (!verifyAlphaNum($Distinct)) {
        $errorMsg[] = "You entered somethign worng into the distinct question";
        $DistinctERROR = true;
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
       <aside id="searchCarText"> 
        <h3>
            Want to play with the Numbers?
        </h3>

        <p>
          Want to figure out if your pre-conceive notion come true? Do Jersey drivers
          "Buzz" more than Kentucky drivers? Is the term "Masshole" legitimate?
          Should we be more careful when we see a black car coming up behind us
          or is white the dangerous color? Is a Hummer more dangerous then a Toyota?
          These are all things that you can learn with the information available
          to you in the form below. 
        </p>
        
        <p>
            Play with the numbers and see what you can find. Remember to always
            report your incidents of buzzing. The more we know the more you can 
            learn!
        </p>

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
        $query = 'SELECT  fldPerpCarMake AS Make, fldPerpCarColor AS Color, '; 
        $query .= 'pmkPerpPlateState AS State';
             if ($Distinct == ''){
                 $query .= ', fldInjuries AS Injuries, ';
                 $query .= 'fldInjurySeverity AS "Injury Severity" ';
             }
        $query .= ' FROM tblPerpetrator JOIN tblIncident ';
        $query .= 'ON tblPerpetrator.pmkPerpPlate = tblIncident.fnkPerpPlate ';
        $query .= 'AND tblPerpetrator.pmkPerpPlateState = tblIncident.fnkPerpPlateState ';
        
        //Zip Code
        $query .= 'WHERE fldPerpCarMake LIKE ? '; 
        $data[] = $Make . "%";

   //======If statements============
        //street
   if ($Color != ''){
       $query .= 'AND fldPerpCarColor LIKE ? ';
       $data[] = $Color . "%";
   }
   
   //Time
   if ($State != ''){
       $query .= 'AND pmkPerpPlateState LIKE ? ';
       $data[] = $State;
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
   
   //Distinct cars 
   if ($Distinct != ''){
       $query .= 'GROUP BY pmkPerpPlate, pmkPerpPlateState';
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
    print "<br>";
    
    if ($Distinct != ''){
       print "<h1 id='numBuzzTimes'>There are ". $numberRecords . " unique vehicles reported with these parameters</h1>"; 
    }
    
    else{
        print "<h1 id='numBuzzTimes'>There are ". $numberRecords . " occurances of buzzing with these paramters</h1>";
    }
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
                        
            <!-- Make Code  --> 
                         <label id="lstMake"> Car Make
                        <select id="listMake" 
                                name="lstMake" 
                                tabindex="100" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkMake FROM tblMake ';
                            $query .= 'where pmkMake not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($Make == $row["pmkMake"]);
                                print "$row[pmkMake]</option>";
                            }
                            ?>

                         </select>
                        </label>
                        
            <!-- Color -->
                        <label id="lstColor"> Car Color
                        <select id="listColor" 
                                name="lstColor" 
                                tabindex="110" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkColor FROM tblColor ';
                            $query .= 'where pmkColor not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($Color == $row["pmkColor"]);
                                print "$row[pmkColor]</option>";
                            }
                            ?>
                   
                         </select>
                        </label>
                        
            <!-- License Plate State -->
                       <label id="lstState"> License Plate State 
                        <select id="listState" 
                                name="lstState" 
                                tabindex="120" 
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
                                if($State == $row["pmkStateName"]);
                                print "$row[pmkStateName]</option>";
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
            
          <!--Distinct cars? -->
                        <label><input type="checkbox" 
                                      id="chkDisitnctSelect" 
                                      name="chkDistinct" 
            <?php if ($Distinct) echo ' checked="checked" '; ?>
                                      value="See only Distinct Vehicles" 
                                      tabindex="200" 
                                      > See only distinct vehicles? </label>
                    
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