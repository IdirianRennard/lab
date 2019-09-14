$(document).ready( function( ) {
  //Open Multiple Admin Tabs
  $( '#open_admin' ).on( 'click', function() {

    let old_admin = $("#admin_tile").html();
    let new_admin = '';

    new_admin += "<table class='nav_table'>";
    new_admin += "<tr><td>";
    new_admin += "Admin Account:<br><br><input type='text' size='20' id='acct_number' placeholder='  Enter Account Number'>";
    new_admin += "</tr></td>";
    new_admin += "<tr><td align='center'>";
    new_admin += "<table>";
    new_admin += "<tr><td><input type='checkbox' class='checkbox' id='home'><font color='#003D6B'>Home</td>";
    new_admin += "<td><input type='checkbox' class='checkbox' id='activity'><font color='#003D6B'>Activity</td>";
    new_admin += "<td><input type='checkbox' class='checkbox' id='transaction'><font color='#003D6B'>Txn</td></tr>";
    new_admin += "<tr><td><input type='checkbox' class='checkbox' id='products'><font color='#003D6B'>Prod</td>";
    new_admin += "<td><input type='checkbox' class='checkbox' id='service'><font color='#003D6B'>Service</td>";
    new_admin += "<td><input type='checkbox' class='checkbox' id='all'><font color='#003D6B'>All</td></tr></font></table>";
    new_admin += "</td></tr>";
    new_admin += "<tr><td align='right'><input type='submit' class='button' id='admin_button' value='OPEN'></td></tr></table><br><br>";

    new_admin += "<tr><td colspan='42'><hr></td></tr>";

    new_admin += "<tr><td colspan'42' align='center'><input type='button' class='button' id='close_admin' value=' Close Admin '></td></tr>";
    new_admin += "</table>";

    $( "#admin_tile" ).html( new_admin );

    console.log( new_admin );

    if ( $('#acct_number').val() == '' ) {
      window.open( 'https://admin.paypal.com/cgi-bin/admin' );

    } else {
      let acct_number = $('#acct_number').val();

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#service').prop('checked') ) {
        window.open('https://admin.paypal.com/cgi-bin/admin?node=service_log_display_account&account_number=' + acct_number );
        $('#service').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#products').prop('checked') ) {
        window.open('https://admin.paypal.com/cgi-bin/admin?node=loaduserpage_products&account_number=' + acct_number );
        $('#products').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#transaction').prop('checked') ) {
        window.open('https://admin.paypal.com/cgi-bin/admin?node=transactionlog_flow&account_number=' + acct_number );
        $('#transaction').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#activity').prop('checked') ) {
        window.open('https://admin.paypal.com/cgi-bin/admin?node=activitylog_flow&account_number=' + acct_number );
        $('#activity').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#home').prop('checked') ) {
        window.open('https://admin.paypal.com/cgi-bin/admin?node=loaduserpage_home&account_number=' + acct_number );
        $('#home').prop('checked', false)
      }
    }

    //Clears the all checkbox
    $('#all').prop('checked', false);

    //Clears the account number and resets the placeholder
    $('#acct_number').val("");
    $('#acct_number').attr('placeholder', '  Enter Account Number');
  } );

  //Check all on Admin Account tile to check all boxes within it
  $( '#all' ).on('click', function(){
    let ids = [ 'home', 'activity', 'transaction', 'products', 'service' ];

    if ( $('#all').prop( 'checked' ) ) {
      ids.forEach( function(e) {
        $( '#' + e ).prop('checked', true );
      } );
    } else {
      ids.forEach( function(e) {
        $( '#' + e ).prop('checked', false );
      } );
    }
  } );

  //Checks when a Checkbox is unchecked, also uncheck 'All'
  $( '.checkbox' ).on('click', function(e) {
    if ( $( '#home' ).prop( 'checked' ) && $( '#activity' ).prop( 'checked' ) && $( '#transaction' ).prop( 'checked' ) && $( '#products' ).prop( 'checked' ) && $( '#service' ).prop( 'checked' ) ) {
      $( '#all' ).prop( 'checked', true );

    } else {
      $( '#all' ).prop( 'checked', false );
    }


  } );

  //Open JIRA Ticket in new page
  $( '#jira_button').on( 'click', function(e) {
    //echo "</div><br><br>";
    //echo "<table class='nav_table'>";
    //echo "<tr><td>";
    //echo "JIRA Ticket:<br><br><input type='text' size='20' id='jira_ticket' placeholder='  Enter Ticket Number' required>";
    //echo "</tr></td>";
    //echo "<tr><td align='right'><input type='submit' class='button' id='jira_button' value='open'></td></tr>";
    //echo "</table><br><br>";

    if ( $( '#jira_ticket').val() == '' ) {

    } else {
      let jira_ticket = $( '#jira_ticket').val();
      window.open( 'https://engineering.paypalcorp.com/jira/browse/' + jira_ticket );
      window.open( 'https://sispprod.paypalcorp.com/sisp/issues/' + jira_ticket );
    }

    $('#jira_ticket').val("");
    $('#jira_ticket').attr('placeholder', '  Enter Ticket Number' );

  } )

  //UI Setting Pannel
  $("#open_ui").on( 'click', function(e) {

    let old_ui = $("#ui_tile").html();
    let new_ui = '';

    new_ui += "<form action='upload.php' method='post' enctype='multipart/form-data'>";
    new_ui += "<table class='nav_table'>";
    new_ui += "<tr><td align='center'>Wallpaper Change:<br><br></td></tr><tr><td align='center'>";
    new_ui += "<input type='file' name='fileToUpload' id='fileToUpload' class='upload'>";
    new_ui += "<tr><td align='right'><input type='submit' class='button' id='upload_button' value='update'></td></tr>";
    new_ui += "</form>";

    new_ui += "<tr><td colspan='42'><hr></td></tr>";

    new_ui += "<tr><td colspan'42' align='center'><input type='button' class='button' id='close_ui' value=' Close UI Settings '></td></tr>";
    new_ui += "</table>";

    $("#ui_tile").html( new_ui );

    $("#close_ui").on( 'click', function(e) {
      $("#ui_tile").html( old_ui );
    } )
  } )

  $('#ui_tile').bind( "DOMSubtreeModified", function() {
    $("#open_ui").on( 'click', function(e) {

      let old_ui = $("#ui_tile").html();
      let new_ui = '';

      new_ui += "<form action='upload.php' method='post' enctype='multipart/form-data'>";
      new_ui += "<table class='nav_table'>";
      new_ui += "<tr><td align='center'>Wallpaper Change:<br><br></td></tr><tr><td align='center'>";
      new_ui += "<input type='file' name='fileToUpload' id='fileToUpload' class='upload'>";
      new_ui += "<tr><td align='right'><input type='submit' class='button' id='upload_button' value='update'></td></tr>";
      new_ui += "</form>";

      new_ui += "<tr><td colspan='42'><hr></td></tr>";

      new_ui += "<tr><td colspan'42' align='center'><input type='button' class='button' id='close_ui' value=' Close UI Settings '></td></tr>";
      new_ui += "</table>";

      $("#ui_tile").html( new_ui );

      $("#close_ui").on( 'click', function(e) {
        $("#ui_tile").html( old_ui );
      } );
    } );
  } );

} )
