<?php
include './include.php';

$hosted_button_id = $_POST['hosted_button_id'];
unset( $_POST['hosted_button_id'] );

$button_image = "https://www.paypalobjects.com/en_US/i/btn/";

switch ( $_POST['image'] ) {

  case 'custom':
    $button_image = $_POST['custom_image'];
    unset( $_POST['custom_image'] );
    break;

  case 'buy_now':
    $button_image .= "btn_buynow_LG.gif";
    break;

  case 'sm_buy_now':
    $button_image .= "btn_buynow_SM.gif";
    break;

  case 'buy_now_cc_logo':
    $button_image .= "btn_buynowCC_LG.gif";
    break;

  case 'pay_now':
    $button_image .= "btn_paynow_LG.gif";
    break;

  case 'sm_pay_now':
    $button_image .= "btn_paynow_SM.gif";
    break;

  case 'pay_now_cc_logo':
    $button_image .= "btn_paynowCC_LG.gif";
    break;

  case 'shopping_cart':
    $button_image .= "btn_cart_LG.gif";
    break;

  case 'sm_shopping_cart':
    $button_image .= "btn_cart_SM.gif";
    break;

  case 'donate':
    $button_image .= "btn_donate_LG.gif";
    break;

  case 'sm_donate':
    $button_image .= "btn_donate_SM.gif";
    break;

  case 'donate_cc_logo':
    $button_image .= "btn_donateCC_LG.gif";
    break;

  case 'subscribe':
    $button_image .= "btn_subscribe_LG.gif";
    break;

  case 'sm_subscribe':
    $button_image .= "btn_subscribe_SM.gif";
    break;

  case 'subscribe_cc_logo':
    $button_image .= "btn_subscribeCC_LG.gif";
    break;

  case 'installment':
    $button_image .= "";
    break;

  case 'auto_bill':
    $button_image .= "";
    break;

  case 'email_link':
    $button_image .= "";
    break;

  default:
    $button_image = 'https://www.shareicon.net/download/2016/08/01/640385_face_512x512.png';
    break;
}

if ( $_POST['image'] == 'email_link' ) {
  $button_code = "\n\nhttps://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=$hosted_button_id";

} else {
  $button_code = "<!-- Begin Button Code !-->\n";
  $button_code .= "<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=$hosted_button_id' target='_blank'>\n";
  $button_code .= "<img src='$button_image' alt='PayPal - The safer, easier way to pay online!'>\n";
  $button_code .= "</a>\n";
  $button_code .= "<!-- End Button Code !-->";
}


?>
<table class='table'>
  <tr>
    <td><textarea name="button_code" class='drop' cols="100" rows="7" id='copy' ><?php echo $button_code; ?></textarea></td>
    <script>spaces(4)</script>
    <td><hr width="1" size="250"></td>
    <script>spaces(4)</script>
    <td class='container' align='center'><?php echo $button_code; ?></td>
  </tr>
</table>
