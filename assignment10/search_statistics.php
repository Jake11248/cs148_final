
 
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


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$data = array();

$licensePlate = "";
$number = "";
$building = ""; 
$startTime = "";
$professor = "";



//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$licensePlateERROR = false;
$numberERROR = false;
$buildingERROR = false;
$professorERROR = false;
$startTimeERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

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
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

  $licensePlate = htmlentities($_POST["txtlicensePlate"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $licensePlate;
    
    $number = htmlentities($_POST["txtnumber"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $number;

    $building = htmlentities($_POST["lstbuilding"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $building;
    
    $professor = htmlentities($_POST["txtprofessor"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $professor;
    
    $startTime = htmlentities($_POST["txtstartTime"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $startTime;

   

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

 /*  if ($startTime == "") {
    }
        elseif (!verifyAlphaNum($startTime)) {
        $errorMsg[] = "The Start Time appears to have extra character.";
        $startTimeERROR = true;
    }
  
  */
    
    //verify subject
    if ($licensePlate == "") {
    }
        elseif (!verifySubjecct($licensePlate)) {
        $errorMsg[] = "The Subject appears to have extra character.";
        $startTimeERROR = true;
    }
    
    //verify  Course Number 
     if ($number == "") {
    }
        elseif (!verifyCourse($number)) {
        $errorMsg[] = "The Course Number appears to have extra character.";
        $startTimeERROR = true;
    }
    
    //verify start time 
     if ($startTime == "") {
    }
        elseif (!verifyTime($startTime)) {
        $errorMsg[] = "The Start Time appears to have extra character.";
        $startTimeERROR = true;
    }
    
    //verify professor
     if ($professor == "") {
    }
        elseif (!verifyProfessor($professor)) {
        $errorMsg[] = "The Professor appears to have extra character.";
        $startTimeERROR = true;
    }
    

     //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        
        /*
         * ALL IS NONT NEEDED FOR THIS ASIGNMENT (5.0)
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.

        $fileExt = ".csv";

        $myFileName = "data/registration";

        $filename = $myFileName . $fileExt;

        if ($debug)
            print "\n\n<p>filename is " . $filename;

        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Your information.</h2>';

        foreach ($_POST as $key => $value) {

            $message .= "<p>";

            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
         */
        
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
    //unneede in this assignemnt - commented out 
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
       
    //BEGIN  ADDITION FOR SQL 
    /* open up the database, create the SQL statment, and querry the database. */

    /* ##### Step one 
     * 
     * create your database object using the appropriate database username

    */
    

 
    

    
    
    //build the Query  
    $query = 'SELECT CONCAT (fldDepartment," ", fldCourseNumber) AS Course, '; 
        $query .= 'fldCRN AS CRN, ';
        $query .= 'CONCAT(fldFirstName, "", fldLastName) AS Professor, '; 
        $query .= '(fldMaxStudents - fldNumStudents) AS "Seats Available", ';  
        $query .= 'fldSection AS Section, ';
        $query .= 'fldType AS Type, ';
        $query .= 'fldStart AS Start, ';
        $query .= 'fldStop AS Stop, ';
        $query .= 'fldDays AS Days, ';
        $query .= 'fldBuilding AS Building, ';
        $query .= 'fldRoom AS Room ';
    $query .= 'FROM tblCourses JOIN tblSections ON tblCourses.pmkCourseId = tblSections.fnkCourseId ';
        $query .= 'JOIN tblTeachers ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId ';
        
            //start Time
        $query .= 'WHERE fldStart LIKE ? '; 
        $data[] = $startTime . "%";

//======= if statements ========
            //subject
    if ($licensePlate != '' ){
    $query .= 'AND fldDepartment LIKE ? ';
    $data[] = $licensePlate ;
    }
        //course number
    if ($number != '' ){
    $query .= 'AND fldCRN LIKE ? ';
    $data[] = $number . "%";
    }
    
        //Buidling
    if ($building != '' ){
    $query .= 'AND fldBuilding LIKE ? ';
    $data[] = $building . "%";
    }
    
         //Professor Last name 
    if ($professor != '' ){
    $query .= 'AND fldLastName LIKE ? ';
    $data[] = "%" . $professor . "%";
    }
    
    

  
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
   //count numebr of records if debug is truend on (uncomment when run live site) 
 if ($debug){
    $numberRecords = count($results); 
}
    
    print "<h2>Total Records: " . $numberRecords . "</h2>";
    
    //print query so I can see what is happeneing 
    //DELETE BEFORE SUBMITTING 
   
    
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

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmClassSearch">

            <fieldset class="wrapper">
                <legend>Search for Buzzer:</legend>
                <p>Search for a buzzer using any of the following Criteria</p>

                <fieldset class="wrapperTwo">
                    <legend>Enter as many or as few as you would like.</legend>
                    <fieldset class="contact">
                        <legend></legend>
                        
                        <!-- search for Subject  --> 
                         <label for="txtsubject" class="required">Subject
                            <input type="text" id="txtsubject" name="txtlicensePlate"
                                   value="<?php print $licensePlate; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter the license Plate Number"
                                   <?php if ($licensePlateERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        
                        <!-- search for Course Number  -->
                         <label for="txtnumber" class="required">Course Number
                            <input type="text" id="txtnumber" name="txtnumber"
                                   value="<?php print $number; ?>"
                                   tabindex="200" maxlength="45" placeholder="Enter the course number (CRN)"
                                   <?php if ($numberERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        
                       
                         <label id="lsbuilding"> Building
                        <select id="lstbuilding" 
                                name="lstbuilding" 
                                tabindex="300" 
                                size="1"> 
                        
                            <option>  </option>
                            <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT fldBuilding FROM tblSections ';
                            $query .= 'where fldBuilding not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($building == $row["fldBuilding"]) print ' selected = "selected" ';
                                print "$row[fldBuilding]</option>";
                            }
                            ?>

                            
                        </select>
                        </label>
                            
                         
                          <!-- search for Professor -->
                         <label for="txtprofessor" class="required">Professor
                            <input type="text" id="txtprofessor" name="txtprofessor"
                                   value="<?php print $professor; ?>"
                                   tabindex="400" maxlength="45" placeholder="Enter the Professor's last name "
                                   <?php if ($numberERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        
                        <!-- search for Start Time  --> 
                        <label for="txtstartTime" class="required">Start Time
                            <input type="text" id="txtstartTime" name="txtstartTime"
                                   value="<?php print $startTime; ?>"
                                   tabindex="500" maxlength="45" placeholder="Enter the Time in Military time ex. 08"
                                   <?php if ($startTimeERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        

         
                    </fieldset> <!-- ends contact -->
                    
                </fieldset> <!-- ends wrapper Two -->
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Find a Class" tabindex="3000" class="button">
                </fieldset> <!-- ends buttons -->
                
            </fieldset> <!-- Ends Wrapper -->
        </form>



</article>



<?php
include "footer.php";
?>

</body>
</html>