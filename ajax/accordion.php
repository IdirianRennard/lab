<?php
class data {
    public  $name;
    public  $p = array ();
}

class p {
    public  $align;
    public  $value;
}

$acccordion = array();

$date = new DateTime('today');
$date_holder = "  " . $date->format( 'm/d/Y' );

$sherlock = new data ();
    $sherlock->name = "Sherlock";

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "Sherlock Query:
        <br><br>
        <input type='text' size='20' id='sherlock' class='nav_input' placeholder='  Enter Query' required>
        <br><br>
        <table>
          <tr>
            <td>Start Time: </td>
            <td><input type='text' id='cal_start_datepicker' name='start_date' class='nav_input' placeholder='$date_holder' required></td>
          </tr>
          <tr>
            <td>End Time: </td>
            <td><input type='text' id='cal_end_datepicker' name='end_date' class='nav_input' placeholder='$date_holder' required></td>
          </tr>
        </table>
        <hr>";
    $sherlock->p[] = $p;

        $p = new p ();
        $p->align = 'right';
        $p->value = "<input type='submit' class='button' id='game_is_afoot' value='open'>";
    
    $sherlock->p[] = $p;

$accordion['sherlock'] = $sherlock;

$splunk = new data ();
    $splunk->name = "Splunk";

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "Splunk Query:
        <br><br>
        <input type='text' size='20' id='splunk' class='nav_input' class='nav_input' placeholder='  Enter Query' required>
        <br><br>
        <select class='nav_input' id='cave_app'>
          <option value='dis' disabled selected>Select Search App</option>
        </select>
        <br><br>
        <table>
          <tr><td>Start Time: </td><td><input type='text' id='cave_start_datepicker' name='start_date' class='nav_input' placeholder='$date_holder' required></td></tr>
          <tr><td>End Time: </td><td><input type='text' id='cave_end_datepicker' name='end_date' class='nav_input' placeholder='$date_holder' required></td></tr>
        </table>
        <hr>";

    $splunk->p[] = $p;

        $p = new p ();
        $p->align = 'right';
        $p->value = "<input type='submit' class='button' id='cave_dive' value='open'>";
    
    $splunk->p[] = $p;

$accordion['splunk'] = $splunk;

$tealeaf = new data ();
    $tealeaf->name = "Tealeaf";

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "Tealeaf Query:
        <br><br>
        <input type='text' size='20' id='tealeaf' class='nav_input' placeholder='  Enter Query' required>
        <br><br>
        <table>
            <tr>
                <td>Start Time: </td>
                <td><input type='text' id='tl_start_datepicker' name='start_date' class='nav_input' placeholder='$date_holder' required></td>
            </tr>
            <tr>
                <td>End Time: </td>
                <td><input type='text' id='tl_end_datepicker' name='end_date' class='nav_input' placeholder='$date_holder' required></td>
            </tr>
        </table>
        <hr>";

    $tealeaf->p[] = $p;

        $p = new p ();
        $p->align = 'right';
        $p->value = "<input type='submit' class='button' id='make_tea' value='open'>";

    $tealeaf->p[] = $p;

$accordion['tealeaf'] = $tealeaf;

$jira = new data ();
    $jira->name = "JIRA";

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "JIRA Ticket:
        <br><br>
        <input type='text' size='20' id='jira_ticket' class='nav_input' placeholder='  Enter Ticket Number' required>
        <hr>";

    $jira->p[] = $p;

        $p = new p ();
        $p->align = 'right';
        $p->value = "<input type='submit' class='button' id='jira_button' value='open'>";

    $jira->p[] = $p;

$accordion['jira'] = $jira;

$admin = new data ();
    $admin->name = "Admin";

        $p = new p ();
        $p->align = 'center';
        $p->value = "Admin Account:<br><br><input type='text' size='20' id='acct_number' class='nav_input' placeholder='  Enter Acct Identifier'><br><br>";

    $admin->p[] = $p;

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "<table>
            <tr>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='home'><span class='slider round'></span></label><font color='#003D6B'>Home</td>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='activity'><span class='slider round'></span></label><font color='#003D6B'>Activity</td>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='transaction'><span class='slider round'></span></label><font color='#003D6B' >Txn</td>
            </tr>
            <tr>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='products'><span class='slider round'></span></label><font color='#003D6B' >Prod</td>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='service'><span class='slider round'></span></label><font color='#003D6B' >Service</td>
                <td align='left' width='25%'><label class='switch'><input type='checkbox' id='all'><span class='slider round'></span></label><font color='#003D6B' >All</td>
            </tr>
        </table>
        <hr>";

    $admin->p[] = $p;

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "<table>
            <tr>
                <td><label class='switch'><input type='checkbox' id='sandbox'><span class='slider round'></span></label><font color='#003D6B' >Sandbox</td>
                <td id='admin-spaces'>30</td>
                <td colspan='42' align='right'><input type='submit' class='button' id='admin_button' value='open'></td>
            </tr>
        </table>";
    
    $admin->p[] = $p;

$accordion['admin'] = $admin;

ksort( $accordion );

$background = new data ();
    $background->name = "Background Settings";

        $p = new p ();
        $p->align = 'center';
        $p->value = 
        "<form action='upload.php' method='post' enctype='multipart/form-data'>
            <table>
            <tr>
                <td align='center'>Wallpaper Change:<br><br></td>
            </tr>
            <tr>
                <td align='center'><input type='file' name='fileToUpload' id='fileToUpload' class='nav_input' required>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td align='right'><input type='submit' class='button' id='upload_button' value='update'></td>
            </tr>
            </table>
        </form>";

    $background->p[] = $p;

$accordion = array( 'background' => $background ) + $accordion;

header('Content-Type: application/json');

echo json_encode( $accordion );
?>