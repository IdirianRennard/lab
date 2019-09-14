<?php
session_start();
include "include/credentials.php";
include "include/menu_options.php";
include "include/functions.php";
include "include/rest_functions.php";
include "include/browser_detection.php";

$browser = new Wolfcast\BrowserDetection();
echo "<script>console.log( 'BROWSER : " . $browser->getName() ."' )</script>";

$r_m_c_width = '1%';

if ( $browser->getName() == 'Chrome' ) {
  $switch_class = 'chr_switch';
} else {
  $switch_class = 'switch';
}



$return_file_path = 'https://localhost' . rtrim(  $_SERVER['PHP_SELF'], basename( $_SERVER['PHP_SELF'] ) ) ;

?>

<script>
let delay = 600000;
let redirect_url = 'reset.php';

setTimeout(function(){ window.location = redirect_url; }, delay);
</script>

<title>Idirian's Lab</title>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/ui_mod.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="js/scripts.js"></script>

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
<table class='right_nav'>
  <?php
  foreach ($help_options as $k => $v) {
    echo "<tr><td align='right'>";

    switch ( $k ) {
      case 'admin':
        echo "<table class='nav_table'>";

          echo "<tr><td>";
          echo "Admin Account:<br><br><input type='text' size='20' id='acct_number' placeholder='  Enter Acct Identifier'><br><br>";
          echo "</tr></td>";
        
          echo "<tr><td>";
            echo "<table align='center'>";

              echo "<tr>";
                echo "<td width='$r_m_c_width' ></td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='home'><span class='slider round'</span></label><font color='#003D6B'>Home</td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='activity'><span class='slider round'</span></label><font color='#003D6B'>Activity</td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='transaction'><span class='slider round'</span></label><font color='#003D6B'>Txn</td>";
              echo "</tr>";

              echo "<tr>";
                echo "<td width='$r_m_c_width' ></td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='products'><span class='slider round'</span></label><font color='#003D6B'>Prod</td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='service'><span class='slider round'</span></label><font color='#003D6B'>Service</td>";
                echo "<td width='$r_m_c_width' ><label class='$switch_class'><input type='checkbox' id='all'><span class='slider round'</span></label><font color='#003D6B'>All</td>";
              echo "</tr>";

            echo "</table>";
          echo "</td></tr>";
        echo "<tr><td colspan='42'><hr></td></tr>";
        echo "<tr><td align='right'><input type='submit' class='button' id='admin_button' value='OPEN'></td></tr></table><br><br>";
        break;

      case 'JIRA' :
        echo "<table class='nav_table'>";
        echo "<tr><td>";
        echo "JIRA Ticket:<br><br><input type='text' size='20' id='jira_ticket' placeholder='  Enter Ticket Number' required>";
        echo "</tr></td>";
        echo "<tr><td colspan='999'><hr></td></tr>";
        echo "<tr><td align='right'><input type='submit' class='button' id='jira_button' value='open'></td></tr>";
        echo "</table><br><br>";
        break;

      case 'splunk' :
        echo "<table class='nav_table'>";
        echo "<tr><td colspan='42' align='center'>Splunk Query:</td></tr>";
        echo "<tr><td><br></td></tr><tr><td colspan='42' align='center'><input type='text' size='20' id='splunk' placeholder='  Enter Query' required>";
        echo "<tr><td><br></td></tr>";
        echo "<tr><td colspan='42' align='center'><label class='$switch_class'><input type='checkbox' id='cave_pf'><span class='slider round'</span></label>Payflow</tr></td>";
        echo "<tr><td><br></td></tr>";
        echo "<tr><td>Start Time: </td><td><input type='text' id='cave_start_datepicker' name='cave_start_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td>End Time: </td><td><input type='text' id='cave_end_datepicker' name='cave_end_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td colspan='999'><hr></td></tr>";
        echo "<tr><td colspan='42'align='right'><input type='submit' class='button' id='cave_dive' value='open'></td></tr>";
        echo "</table><br><br>";
        break;

      case 'ui_settings' :
        echo "<div id='ui_tile'>";
        echo "<button type='button' id='open_ui' class='nav_table_button'><img src='settings.png' height='25px'></button>";
        echo "</div><br><br>";
        break;

      case 'cal' :
        echo "<table class='nav_table'>";
        echo "<tr><td colspan='42' align='center'>Sherlock Query:</td></tr>";
        echo "<tr><td><br></td></tr><tr><td colspan='42'><input type='text' size='20' id='sherlock' placeholder='  Enter Query' required></td></tr>";
        echo "<tr><td><br></td></tr>";
        echo "<tr><td colspan='42' align='center'><label class='$switch_class'><input type='checkbox' id='cal_sb'><span class='slider round'</span></label>Sandbox";
        echo "<tr><td><br></td></tr>";
        echo "<tr><td>Start Time: </td><td><input type='text' id='cal_start_datepicker' name='cal_start_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td>End Time: </td><td><input type='text' id='cal_end_datepicker' name='cal_end_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td colspan='999'><hr></td></tr>";
        echo "<tr><td colspan='42'align='right'><input type='submit' class='button' id='game_is_afoot' value='open'></td></tr>";
        echo "</table><br><br>";
        break;

      case 'tealeaf' :
        echo "<table class='nav_table'>";
        echo "<tr><td colspan='42' align='center'>";
        echo "Tealeaf Query:<br><br><input type='text' size='20' id='tealeaf' placeholder='  Enter Query' required>";
        echo "</tr></td>";
        echo "<tr><td><br></td></tr>";
        echo "<tr><td>Start Time: </td><td><input type='text' id='tl_start_datepicker' name='tl_start_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td>End Time: </td><td><input type='text' id='tl_end_datepicker' name='tl_end_date' placeholder=' 01/01/2000' required></td></tr>";
        echo "<tr><td colspan='999'><hr></td></tr>";
        echo "<tr><td colspan='42'align='right'><input type='submit' class='button' id='make_tea' value='open'></td></tr>";
        echo "</table><br><br>";
        break;

      default:
        echo "<form action ='$k' target='_blank'><input type='submit' class='nav' value='$v'></form></td></tr><tr><td><br>";
        break;
    }
    echo "</td></tr>";
  }
  ?>
</table>
<div id='warning'></div>
