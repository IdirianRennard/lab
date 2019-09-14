<?php
include 'include.php';

$string = $_POST['get_url'];

$string = ltrim( $string, 'https://www.paypal.com/cgi-bin/webscr' );

$string = str_replace( "¤" , "&curren" , $string );
$string = str_replace( "¬" , "&not" , $string );

$string = urldecode( $string );

parse_str( $string, $string );

$ctr = 0;

foreach ( $string as $k => $v ) {
  if ( is_array( $v ) ) {
    $ctr++;
  }
}

if ( $ctr > 0 ) {
  $string = $_POST['get_url'];

  $string = urldecode( $string );

  $explode_1 = explode( '&', $string );

  $string = array();

  foreach ( $explode_1 as $k => $v ) {
    $explode_2 = explode( '=', $v );
    $string[ $explode_2[0] ] = $explode_2[1];
  };
}

ksort( $string );

?>
<table class='table'>
  <?php
    foreach ( $string as $k => $v ) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
  ?>
</table>
