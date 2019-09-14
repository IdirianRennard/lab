<?php
include 'include.php';

$string = $_POST['xclick'];
unset( $_POST['xclick']);

if ( $_POST['enviroment'] == 'production' ) {
  $url = 'https://www.paypal.com/cgi-bin/webscr';
} else {
  $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

$string = base64_decode( $string );

$string = urldecode( $string );

parse_str( $string, $string );

ksort( $string );

$message = "<form action='$url' method='post' target='_blank'>\n";
$message .= "<input type=hidden name='cmd' value='" . $_POST['cmd'] . "'>\n";
foreach ( $string as $k => $v ) {
  $message .= "<input type='hidden' name='$k' value='$v'>\n";
}
$message .= "<input type='submit' class='button' value='submit'>\n";
$message .= "</form>";
?>

<table class='table'>
  <tr>
    <td><textarea cols='100' rows='70' id='copy'><?php echo $message; ?></textarea></td>
    <script>spaces(4)</script>
    <td><hr width="1" size="300"></td>
    <script>spaces(4)</script>
    <td class='container' align='center' id='button'><div id='message'><?php echo $message; ?></div></td>
  </tr>
  <tr><td colspan='842'><hr></td></tr>
  <tr><td><input type='submit' class='button' value='update' id='update'></ts></tr>
</table>
<script>
  $(document).ready( function () {

    $('#update').on('click', function(e) {
      let message = $('#copy').val();
      
      $('#message').html( message );

    } )

  } )
</script>