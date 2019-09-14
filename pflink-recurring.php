<?php
include 'include.php';
?>
<form action='pflink-recurring-test.php' method='post'>
  <table class='table'>
    <tr><td>Partner:</td><script>spaces(4)</script><td><input class='drop' type="text" name="PARTNER" value="<?php echo $credentials['PF_PARTNER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Vendor:</td><td></td><td><input type="text" class='drop' name="VENDOR" value="<?php echo $credentials['PF_VENDOR']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>User:</td><td></td><td><input type="text" name="USER" class='drop' value="<?php echo $credentials['PF_USER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Password:</td><td></td><td><input type="password" name="PWD" class='drop' value="<?php echo $credentials['PF_PWD']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Enviroment:</td><td></td><td>
      <select id='enviroment' name="env" class='drop' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
    </select></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Template:</td><td></td><td>
      <select name="TEMPLATE" class='drop' required>
        <option selected disabled>Select Template</option>
        <option value="TEMPLATEA">Template A</option>
        <option value="TEMPLATEB">Template B</option>
        <option value="TEMPLATEC">Template C</option>
        <option value="MOBILE">Mobile</option>
    </select></td></tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr>
      <td>
        <input type="hidden" name="ACCT" value="4024007139580582">
        <input type="hidden" name="EXPDATE" value=<?php echo date( 'm' ) . ( date( 'y' ) + 3 ); ?>>
        <input type="hidden" name="DISABLERECEIPT" value="true">
        <input type="hidden" name="BILLTOFIRSTNAME" value="John">
        <input type="hidden" name="BILLTOLASTNAME" value="Smith">
        <input type="hidden" name="BILLTOSTREET" value="123 Fake St">
        <input type="hidden" name="BILLTOCITY" value="SCHENECTADY">
        <input type="hidden" name="TRXTYPE" value="R">
        <input type="hidden" name="TENDER" value="C">
        <input type="hidden" name="AMT" value="1.00">
        <input type="hidden" name="CURRENCY" value="840">
        <input type="hidden" name="STATE" value="NY">
        <input type="hidden" name="STREET" value="123 Fake St">
        <input type="hidden" name="CITY" value="SCHENECTADY">
        <input type="hidden" name="ZIP" value="12345">
        <input type="hidden" name="VERBOSITY" value="high">
        <input type="hidden" name="COMMENT1" value="Nate's Test">
        <input type="hidden" name="NOTIFY_URL" value="https://houserennard.online/idirian/ipn/ipn.php">
        <input type="hidden" name="CANCELURL" value="<?php echo $return_file_path . 'test.php?cancel=true'; ?>">
        <input type="hidden" name="ERRORURL" value="<?php echo $return_file_path . 'test.php?error=true'; ?>">
        <input type="hidden" name="RETURNURL" value="<?php echo $return_file_path . 'test.php?return=true'; ?>">
        <input type='hidden' name='ACTION' value='A'>
        <input type='hidden' name='START' value='<?php echo date( 'm') . ( date( 'd' ) + 1 ) . date( 'Y' ); ?>'>
        <input type='hidden' name='PROFILENAME' value='John Smith'>
        <input type='hidden' name='MAXFAILEDPAYMENTS' value='0'>
        <input type='hidden' name='PAYPERIOD' value='MONT'>
        <input type='hidden' name='TERM' value='0'>
        <input type='hidden' name='OPTIONALTRX' value='S'>
        <input type='hidden' name='OPTIONALTRXAMT' value='0.01'>
      </td>
    </tr>
    <tr><td colspan='3' align='right'><input type="submit" class='button' value="SUBMIT"></td></tr>
  </table>
</form>
