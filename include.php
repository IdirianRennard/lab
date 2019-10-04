<?php
session_start();
include "include/credentials.php";
include "include/menu_options.php";
include "include/rest_functions.php";
include "include/browser_detection.php";

$browser = new Wolfcast\BrowserDetection();
echo "<script>console.log( 'BROWSER : " . $browser->getName() ."' )</script>";

if ( $browser->getName() == 'Chrome' ) {
  $switch_class = 'chr_switch';
  $nav_table = 'chr_nav_table';
  $right_nav= 'chr_right_nav';
} else {
  $switch_class = 'switch';
  $nav_table = 'nav_table';
  $right_nav= 'right_nav';
}

$splunk_dropdown = [
  'paypal'    =>  'PayPal',
  'payflow'   =>  'Payflow',
  'mts'       =>  'MTS',
  'search'    =>  'Search & Reporting',
  'globalops' =>  'Global Ops',
];

asort( $splunk_dropdown );

if ( isset( $_GET['dt'] ) ) {
  $dt = $_GET['dt'];

  $dt = urldecode( base64_decode( $dt ) );
  
  parse_str( $dt, $dt );
  
  ksort( $dt );
  console( $dt );
}

$return_file_path = 'https://localhost' . rtrim(  $_SERVER['PHP_SELF'], basename( $_SERVER['PHP_SELF'] ) ) ;

$date = new DateTime('today');
$date_holder = "  " . $date->format( 'm/d/Y' );

?>

<title>Idirian's Lab</title>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/ui_mod.css">
<script> let accord = new Array (); </script>

<table class='titlebar'>
  <tr>
    <td colspan='42' align='center'><a href='reset.php'>Idirian's Lab</a></td>
  </tr>
  <tr><td><font size='4em'><br></font></td><tr>
  <tr>
    <?php
      $width = 100 / ( count ( $menu_options ) );

      foreach ( $menu_options as $k => $v ) {
        echo "<td align='center' width='" . $width . "%'><table><tr><td>";

        $vis_k = str_replace( "_" , " " , $k );

        echo "<td class='nav_menu' id='$k' align='center'>$vis_k</td><td><i class='arrow down'></i></td></tr>";
        echo "<tr><td><div id='$k-drop' class='hover-content'>";

        if ( $k == 'Helpful_Links' ) {
          foreach ( $v as $page => $page_name ) {
            echo "<a class='menu_link' href='$page' target='_blank'>$page_name</a>";
          }
        } else {
          foreach ( $v as $page => $page_name ) {
            echo "<a class='menu_link' href='$page.php'>$page_name</a>";
          }
        }

        echo "</div></td></tr></table></td>";
      }
    ?>
  </tr>
</table>
<?php
echo "<div class='$right_nav' id='accordion'>";
  
  foreach ( $help_options as $k => $v ) {
    
    switch ( $k ) {

      case 'background' : 
        echo "<h3>  $v</h3>";
        echo "<div>";
          echo "<p align='center'>";
            echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
              echo "<table>";
                echo "<tr>";
                  echo "<td align='center'>Wallpaper Change:<br><br></td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<td align='center'><input type='file' name='fileToUpload' id='fileToUpload' class='upload'>";
                echo "</tr>";
                echo "<tr>";
                  echo "<td align='right'><input type='submit' class='button' id='upload_button' value='update'></td>";
                echo "</tr>";
              echo "</table>";
            echo "</form>";
          echo "</p>";
        echo "</div>";
      break;

      case 'admin' :
        echo "<h3>  $v</h3>";
        echo "<div>";
          echo "<p align='center'>";
            echo "Admin Account:<br><br><input type='text' size='20' id='acct_number' placeholder='  Enter Acct Identifier'><br><br>";
          echo "</p>";
          echo "<p align='center'>";
            echo "<table>";
              echo "<tr>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='home'><span class='slider round'></span></label><font color='#003D6B'>Home</td>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='activity'><span class='slider round'></span></label><font color='#003D6B'>Activity</td>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='transaction'><span class='slider round'></span></label><font color='#003D6B' >Txn</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='products'><span class='slider round'></span></label><font color='#003D6B' >Prod</td>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='service'><span class='slider round'></span></label><font color='#003D6B' >Service</td>";
                echo "<td align='left' width='25%'><label class='$switch_class'><input type='checkbox' id='all'><span class='slider round'></span></label><font color='#003D6B' >All</td>";
              echo "</tr>"; 
            echo "</table>";
            echo "<hr>";
          echo "</p>";
          echo "<p align='center'>";
            echo "<table>";
              echo "<tr>";
                echo "<td><label class='$switch_class'><input type='checkbox' id='sandbox'><span class='slider round'</span></label><font color='#003D6B' >Sandbox</td>";
                echo "<script>spaces(30)</script>";
                echo "<td colspan='42' align='right'><input type='submit' class='button' id='admin_button' value='open'></td>";
              echo "</tr>";
            echo "</table>";
          echo "</p>";
        echo "</div>";
      break;

      case 'JIRA' :
        echo "<h3>  $v</h3>";
        echo "<div>";
          echo "<p align='center'>";
            echo "JIRA Ticket:<br><br><input type='text' size='20' id='jira_ticket' placeholder='  Enter Ticket Number' required>";
            echo "<hr>";
          echo "</p>";
          echo "<p align='right'>";
            echo "<input type='submit' class='button' id='jira_button' value='open'>";
          echo "</p>";
        echo "</div>";
      break;

      case 'splunk' :
        echo "<h3>  $v</h3>";
        echo "<div>";
          echo "<p align='center'>";
            echo "Splunk Query:";
            echo "<br><br>";
            echo "<input type='text' size='20' id='splunk' placeholder='  Enter Query' required>";
            echo "<br><br>";
            echo "<select class='drop' id='cave_app'>";
              echo "<option value='dis' disabled selected>Select Search App</option>";
              foreach ( $splunk_dropdown as $k => $v ) {
                echo "<option value='$k'>$v</option>";
              }
            echo "</select>";
            echo "<br><br>";
            echo "<table>";
              echo "<tr><td>Start Time: </td><td><input type='text' id='cave_start_datepicker' name='cave_start_date' placeholder='$date_holder' required></td></tr>";
              echo "<tr><td>End Time: </td><td><input type='text' id='cave_end_datepicker' name='cave_end_date' placeholder='$date_holder' required></td></tr>";
            echo "</table>";  
            echo "<hr>";
          echo "</p>";
          echo "<p align='right'>";
            echo "<input type='submit' class='button' id='cave_dive' value='open'>";
          echo "</p>";
        echo "</div>";
      break;

      case 'sherlock' :
        echo "<h3>  $v</h3>";;
        echo "<div>";
          echo "<p align='center'>";
            echo "Sherlock Query:";
            echo "<br><br>";
            echo "<input type='text' size='20' id='sherlock' placeholder='  Enter Query' required>";
            echo "<br><br>";
            echo "<table>";
              echo "<tr><td>Start Time: </td><td><input type='text' id='cal_start_datepicker' name='cal_start_date' placeholder='$date_holder' required></td></tr>";
              echo "<tr><td>End Time: </td><td><input type='text' id='cal_end_datepicker' name='cal_end_date' placeholder='$date_holder' required></td></tr>";
            echo "</table>";
            echo "<hr>";
          echo "</p>";
          echo "<p align='right'>";
            echo "<input type='submit' class='button' id='game_is_afoot' value='open'>";
          echo "</p>";
        echo "</div>";
      break;

      case 'tealeaf' :
        echo "<h3>  $v</h3>";
        echo "<div>";
          echo "<p align='center'>";
            echo "Tealeaf Query:";
            echo "<br><br>";
            echo "<input type='text' size='20' id='tealeaf' placeholder='  Enter Query' required>";
            echo "<br><br>";
            echo "<table>";
              echo "<tr><td>Start Time: </td><td><input type='text' id='tl_start_datepicker' name='tl_start_date' placeholder='$date_holder' required></td></tr>";
              echo "<tr><td>End Time: </td><td><input type='text' id='tl_end_datepicker' name='tl_end_date' placeholder='$date_holder' required></td></tr>";    
            echo "</table>";
            echo "<hr>";
          echo "</p>";
          echo "<p align='right'>";
            echo "<input type='submit' class='button' id='make_tea' value='open'>";
          echo "</p>";
        echo "</div>";
      break;

      default:
      break;
    }
  }
echo "</div>";

foreach ($help_options as $k => $v) {
  echo "<script>accord.push('$v')</script>";
}
?>
</table>
<div id='warning'></div>

<script>;
  $(document).ready( function () {;
    accord.forEach( e => {
      for ( let i = 0 ; i < $( 'font' ).length ; i++ ) {
        if ( e == $( 'font' )[i].innerHTML ) {
          $( 'font' )[i].replaceWith( e );
        }
      }
    } );
  } );
</script>
