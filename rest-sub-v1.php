<?php
include 'include.php';

$cycle = [
  'DAY' => 'Day',
  'WEEK' => 'Week',
  'MONTH' => 'Month',
  'YEAR' => 'Year'
]

?>

<form action='rest-sub-v1-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>Client ID:</td>
      <script>spaces(4)</script>
      <td colspan='42'><textarea name='ClientID'cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Secret:</td>
      <td></td>
      <td colspan='42'><textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Setup Fee:</td>
      <td></td>
      <td><input type='number' name='setup' min='0.00' max='100' class='drop' placeholder='$0.00' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Cycle:</td>
      <td></td>
      <td><select name='cycle' class='drop'>
        <option selected disabled>Select Cycle</option>
        <?php
        foreach ( $cycle as $k => $v ) {
          echo "<option value='$k'>$v</option>";
        }
        ?>
        </select>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Frequency:</td>
      <td></td>
      <td><input type='number' name='frequency' max='5' class='drop' placeholder='  Freq' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td># of Cycles:</td>
      <td></td>
      <td><input type='number' name='no_cycles' min='1' max='12' class='drop' placeholder='  Cycles' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Amount:</td>
      <td></td>
      <td><input type='number' name='amount' max='100' class='drop' placeholder='$0.00' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Currency:</td>
      <td></td>
      <td><?php echo currency_dropdown(); ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Trial Period:</td>
      <td></td>
      <td colspan='42'>
        <table>
          <tr>
            <td>
              <label class="switch">
                <input id='trial_check' type='checkbox' name='trial'>
                <span class="slider round"></span>
              </label>
            </td>
            <td>
              <div id='trial' required></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Enviroment:</td>
      <td></td>
      <td><script> env_dropdown()</script></td>
    <tr>
      <td colspan="42"><hr></td>
    </tr>
    <tr>
      <td colspan='42' align='right'><input type='submit' class='button' value=' SUBMIT '></td>
    </tr>
  </table>
</form>
<script>
$(document).ready( function () {

  $('#trial_check').on( 'change', function (e) {
    let message = "<table>";
    message += "<tr><td><font color='#003D6B'>Amount:</td><td><input type='number' name='tr_amount' max='5' class='drop' placeholder='$0.00' required></td>";
    message += "<tr><td><font color='#003D6B'>Frequency:</td><td><input type='number' name='tr_frequency' max='5' class='drop' placeholder='  Freq' required></td>";
    message += "<tr><td><font color='#003D6B'>Cycle:</td><td><select name='tr_cycle' class='drop' required><option selected disabled>Select Cycle</option>";
    message += "<?php foreach ( $cycle as $k => $v ) { echo "<option value='$k'>$v</option>"; } ?>";
    message += "</select>";

    if ( e.target.checked ) {
      $('#trial').append( message );
    } else {
      $('#trial').html( '' );
    }

  } )

} )
</script>
