<?php
include 'include.php';

$submitter = [
    'krgrimes' => 'Kevin',
    'nsheridan' => 'Nate',
    'bschweinsburg' => 'Brad',
];

asort( $submitter );

$browsers = [
    'safari',
    'firefox',
    'chrome',
    'internet explorer',
    'edge',
    'opera',
];

asort( $browsers );

echo "<script> let browsers = []; </script>";
foreach( $browsers as $k => $v ) {
    echo "<script> browsers.push('" . ucwords( $v ) . "'); </script>";
}
echo "<script>console.log( browsers );</script>";
?>
<form action='jiracheck-submit.php' method='post' target='_blank'>
<table class='table'>
    <tr>
        <td>Submitter:</td>
        <td align='left'>
            <select name='agent' class='drop' required>
                <option disabled selected>Who are you?</option>
                <?php 
                    foreach( $submitter as $k => $v ) {
                        echo "<option value='$k'>$v</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Salesforce Ticket:</td>
        <td><input type='text' name='ticket_no' class='drop' placeholder='  [ 00000000 ]' required></td>
    </tr>
    <tr>
        <td>Payflow VID:</td>
        <td><input type='text' name='pf_vid' class='drop' placeholder='  00000000000' required></td>
    </tr>
    <tr>
        <td>PayPal Account #:</td>
        <td><input type='text' name='acct_no' class='drop' placeholder='  00000000000' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Did you check the following?</b></u></td>
    </tr>
    <tr>
        <td><input type='checkbox' class='drop' name='devdocs' required>Developer Docs</td>
        <td><input type='checkbox' class='drop' name='confluence' required>Confluence</td>
        <td><input type='checkbox' class='drop' name='infocenter' required>Info Center</td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Has the issue been reported?</b></u></td>
    </tr>
    <tr>
        <td><input type='checkbox' class='drop' name='sisp' required>SISP</td>
        <td><input type='checkbox' class='drop' name='csts' required>CSTS Dashboard</td>
        <td><input id='jira' type='checkbox' class='drop' name='jira' required>JIRA</td>
        <td id='jiracheck'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Has this been asked in Slack?</b></u></td>
    </tr>
    <tr>
        <td>caples-mts:</td>
        <td><input type="text" id="datepicker1" name="caples_date" placeholder=" 01/01/2000" required></td>
        <td>Hour:<input name="caples_hours" type="number" min="0" max="24" placeholder="  23" size="4" required></td>
        <td>Minutes:<input name="caples_minutes" type="number" min="0" max="59" placeholder="  59" size="4" required></td>
        <td>Time Zone:
        <select class='drop' name='caples_timezone' required>
          <option value='Zone' selected disabled>Zone</option>
          <?php

          $timezone_list = timezone_identifiers_list( 2047 );
          $tzarray = [];

          foreach ($timezone_list as $k => $v) {
            $dateTime = new DateTime( );
            $dateTime->setTimeZone(new DateTimeZone( "$v" ));
            $tzarray[$dateTime->format('T')] = NULL;
          }

          foreach ($tzarray as $k => $v) {
            echo "<option value='$k'>$k</option>";
          }
          ?>
        </select>
    </tr>
    <tr>
        <td>na_mts:</td>
        <td><input type="text" id="datepicker2" name="na_date" placeholder=" 01/01/2000" required></td>
        <td>Hour:<input name="na_hours" type="number" min="0" max="24" placeholder="  23" size="4" required></td>
        <td>Minutes:<input name="na_minutes" type="number" min="0" max="59" placeholder="  59" size="4" required></td>
        <td>Time Zone:
        <select class='drop' name='na_timezone' required>
          <option value='Zone' selected disabled>Zone</option>
          <?php

          $timezone_list = timezone_identifiers_list( 2047 );
          $tzarray = [];

          foreach ($timezone_list as $k => $v) {
            $dateTime = new DateTime( );
            $dateTime->setTimeZone(new DateTimeZone( "$v" ));
            $tzarray[$dateTime->format('T')] = NULL;
          }

          foreach ($tzarray as $k => $v) {
            echo "<option value='$k'>$k</option>";
          }
          ?>
        </select>
    </tr>
    <tr>
        <td><input type='text' id='other_channel' name='other_channel' placeholder='  Other channel'></td>
        <td><input type="text" id="datepicker3" name="other_date" placeholder=" 01/01/2000" ></td>
        <td>Hour:<input name="other_hours" type="number" min="0" max="24" placeholder="  23" size="4" ></td>
        <td>Minutes:<input name="other_minutes" type="number" min="0" max="59" placeholder="  59" size="4" ></td>
        <td>Time Zone:
        <select class='drop' name='other_timezone' >
          <option value='Zone' selected disabled>Zone</option>
          <?php

          $timezone_list = timezone_identifiers_list( 2047 );
          $tzarray = [];

          foreach ($timezone_list as $k => $v) {
            $dateTime = new DateTime( );
            $dateTime->setTimeZone(new DateTimeZone( "$v" ));
            $tzarray[$dateTime->format('T')] = NULL;
          }

          foreach ($tzarray as $k => $v) {
            echo "<option value='$k'>$k</option>";
          }
          ?>
        </select>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Have you reached out to PD by email?</b></u></td>
    </tr>
    <tr>
        <td>Subject line:</td>
        <td><input type='text' name='pd_email' placeholder=' MTS [ 00000000 ]'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td><b><u>Can you replicate?</b></u></td>
        <td><select name='replicate' required>
          <option selected disabled>Yes/No</option>
          <option value='yes'>Yes</option>
          <option value='no'>No</option>
          </select>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Screenshots:</b></u></td>
    </tr>
    <tr>
        <td><input type='file' name='screenshot'></td>
    </tr
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Sourcecode:</b></u></td>
    </tr>
    <tr>
        <td><input type='file' name='sourcecode'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Browser:</b></u></td>
    </tr>
    <tr>
        <td>How many?</td>
        <td>
            <select id='browser_no'>
                <option disabled selected>#</option>
                <?php
                    for ( $i = 1 ; $i <= count( $browsers ) ; $i++ ) {
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr><td id='browser_lists'><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Examples:</b></u></td>
    </tr>
    <tr>
        <td colspan='142'><textarea class='drop' name='examples' cols='72' rows='3' required>Included TL session, CAL searches, Transaction IDs, and/or RLog IDs</textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan='42'><b><u>Explain the issue:</b></u></td>
    </tr>
    <tr>
        <td colspan='142'><textarea class='drop' name='story' cols='72' rows='3'></textarea></td>
    </tr>
    <tr><td colspan='999'><hr></td></tr>
    <tr><td colspan='999' align='right'><input type='submit' class='button' value='submit'></td></tr>
</table>
</form>

<script>
$(document).ready( function () {

    $('#jira').on('click', function(e) {
        if (  $('#jira').prop('checked') ) {
            let message = "<table>";
            message += "<tr><td>Recent Bug for the same/similar issue?</td></tr>";
            message += "<tr><td><input type='text' name='recent_bug' value='N/A'></td><tr>";
            message += "</table>";

            $('#jiracheck').html( message );
        } else {
            $('#jiracheck').html( '' );
        }
    } )

    $('#other_channel').on('change', function(e) {
       if ( e.target.value.length ) {
        $('other_date').prop('required', true);
        $('other_hours').prop('required', true);
        $('other_minutes').prop('required', true);
        $('other_timezone').prop('required', true);
       };
    } )

    $('#browser_no').on( 'change', function(e) {
        let message = '';

        if ( e.target.value == '#' ) {
            message += '<br>';
        } else {
            for ( i = 1 ; i <= e.target.value ; i++ ) {
                message += "<select name='browser_" + i + "'>";
                message += "<option selected disabled>Select a Browser</option>";
                browsers.forEach ( function( e ) {
                    message += "<option value='" + e + "'>" + e + "</option>";
                } )
                message += "</select><br><br>";
            }
        }
        console.log( message );
        $('#browser_lists').html( message );
    } )

} );
</script>