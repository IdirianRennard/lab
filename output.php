
  <table class='table'>
    <?php
      echo "<tr><td colspan='42' align='left'>RESPONSE:</td></tr>";
      echo "<tr><td><br></td></tr>";
      foreach ($output as $key => $value) {
        echo "<tr><td>[ $key ]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$value</td></tr>";
      }
    ?>
    </tr>
  </table>
