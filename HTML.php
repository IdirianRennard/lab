<?php
include 'include.php';
?>
<table class='table'>
  <tr>
    <td valign='top' align='right'><textarea class='drop' cols="50" rows="15" id='story'>Enter your HTML here</textarea><br><br><input type='submit' class='button' value='SUBMIT'></td>
    <script>spaces(4)</script>
    <td><hr width="1" size="300"></td>
    <script>spaces(4)</script>
    <td class='container' align='center' id='copy'>Your HTML Appears Here!</td>
  </tr>
  <tr>
    <td align='right'></td>
  </tr>
</table>
<script>
//On clicking Submit, HTML Code Appears in the Box ID Copy
$( document ).ready(function() {
  $('.button').on('click', function() {
    let message = $('#story').val();

    $('#copy').html( message );
  } );
} );
</script>
