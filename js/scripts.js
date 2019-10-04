// Makes White Space in a table
function spaces(number) {
  document.write("<td>")
  for( let i = 0 ; i < number ; i ++ ) {
    document.write("&nbsp");
  }
  document.write("</td>")
}

//  Enviroment Dropdown
function env_dropdown() {
  let message = "<select class='drop' id='enviroment' name='enviroment' required>";

  message += "<option selected disabled>Select Enviroment</option>";
  message += "<option value='production'>Production</option>";
  message += "<option value='sandbox'>Sandbox</option>";
  message += "</select>";

  document.write( message );
}

//opens JSON view
function json_view( php_var ) {
  let message = '';

  message += "<form action='json_view-test.php' method='post' target=_blank>";
  message += "<input type='hidden' name='json' value='<?php echo $" + php_var + "; ?>' >";
  message += "<input type='submit' class='button' value='View JSON'>";
  message += "</form>";

  document.write( message );
}

// jQuery function
$(document).ready( function () {

  //Accodion view for Right Menu
  $( function() {
    var icons = {
      header: "ui-icon-circle-plus",
      activeHeader: "ui-icon-circle-minus"
    };

    $( "#accordion" ).accordion( {
      active : false,
      collapsible : true,
      heightStyle : "content",
      icons : icons
    } );
  } );

  // When clicking into an input field clear the value
  $('input').on( 'click', function(e) {
    if ( e.target.type !== 'submit' && e.target.type !== 'number' ) {
      e.target.value = '';
      e.target.placeholder = '';
    };
  } );

  // When clicking into an texarea clear the value
  $('textarea').on('click', function(e) {
    if( e.target.id === 'copy' ) {

    } else {
      e.target.value = '';
    }
  } );

  // Progress Bar
  $( function() {
    let progressbar = $( "#progressbar" );
    let progressLabel = $( ".progress-label" );
    
    progressbar.progressbar( { 
      value: false,
      change: function () { 
        progressLabel.text( progressbar.progressbar( 'value' ) + '%' );
      },
      complete: function() {
        progressLabel.text( 'Upload Complete! ... Redirecting' );
        $( 'body' ).css( 'background', 'transparent' );
        $( 'body' ).css( 'background-image', 'radial-gradient(circle, #C0C0C0, #003D6B, #000000)' );   
        setTimeout(  function() { window.location.replace( "./" ) }, 1000 );
      }
    } );

    function progress() {
      let val = progressbar.progressbar( "value" ) || 0;

      progressbar.progressbar( 'value', val + 2 );

      if ( val < 99 ) {
        setTimeout( progress, 80 );
      }
    }
    setTimeout( progress, 2000 );
  } );

  //Button Generater Custom URL
  $('#image').on('change', function(e) {
    if( e.target.value === 'custom' ) {
      $('#input_image').append( "<td><br>Enter in your Secure URL:<td></td><td><br><input type='text' name='custom_image' class='drop'></td>" );
    } else {
      $('#input_image').html( '' );
    };
  } );

  //String Count
  $('textarea').on('keyup', function(e) {
    $('#numbers').text( e.target.value.length );
  } );

  //Write warning on page for live selection
  $('#enviroment').on('change', function(e) {
    if( e.target.value === 'live' || e.target.value === 'production' ) {
      $('#warning').append( "<center><table class='err'><tr><td><b><u>WARNING:</b></u> This selection can perform actual transactions with real money!</td></tr></table></center>" );
    } else {
      $('#warning').html( "" );
    }
  } )

  //Date picker
  $( function() {
    $( "#datepicker" ).datepicker( );
  } );

  $( function() {
    $( "#datepicker1" ).datepicker( );
  } );

  $( function() {
    $( "#datepicker2" ).datepicker( );
  } );

  $( function() {
    $( "#datepicker3" ).datepicker( );
  } );

  $( function() {
    $( "#cal_start_datepicker" ).datepicker( );
  } );

  $( function() {
    $( "#cal_end_datepicker" ).datepicker( );
  } );

  $( function() {
    $( "#cave_start_datepicker" ).datepicker( );
  } );

  $( function() {
    $( "#cave_end_datepicker" ).datepicker( );
  } );


  $( function() {
    $( "#tl_start_datepicker" ).datepicker( );
  } );

  $( function() {
    $( "#tl_end_datepicker" ).datepicker( );
  } );


  //Open Multiple Admin Tabs
  $( '#admin_button' ).on( 'click', function() {
    let url  = '';
    if ( $('#sandbox').prop('checked') ) {
      url += 'https://admin.sandbox.paypal.com';
    } else {
      url += 'https://admin.paypal.com';
    }

    if ( $('#acct_number').val() == '' ) {
      window.open( url + '/cgi-bin/admin' );

    } else {
      let acct_number = $('#acct_number').val();
      

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#service').prop('checked') ) {
        window.open( url + '/cgi-bin/admin?node=service_log_display_account&account_number=' + acct_number );
        $('#service').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#products').prop('checked') ) {
        window.open( url + '/cgi-bin/admin?node=loaduserpage_products&account_number=' + acct_number );
        $('#products').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#transaction').prop('checked') ) {
        window.open( url + '/cgi-bin/admin?node=transactionlog_flow&account_number=' + acct_number );
        $('#transaction').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#activity').prop('checked') ) {
        window.open( url + '/cgi-bin/admin?node=activitylog_flow&account_number=' + acct_number );
        $('#activity').prop('checked', false)
      }

      // If checkbox is checked, opens windows and clears checkbox
      if (  $('#home').prop('checked') ) {
        window.open( url + '/cgi-bin/admin?node=loaduserpage_home&account_number=' + acct_number );
        $('#home').prop('checked', false)
      }
    }

    //Clears the all checkbox
    $('#all').prop('checked', false);
    $('#sandbox').prop('checked', false);

    //Clears the account number and resets the placeholder
    $('#acct_number').val("");
    $('#acct_number').attr('placeholder', '  Enter Account Identifier');
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

    if ( $( '#jira_ticket').val() == '' ) {

    } else {
      let jira_ticket = $( '#jira_ticket').val();
      window.open( 'https://engineering.paypalcorp.com/jira/browse/' + jira_ticket );
      window.open( 'https://engineering.paypalcorp.com/sisp/issues/' + jira_ticket );
    }

    $('#jira_ticket').val("");
    $('#jira_ticket').attr('placeholder', '  Enter Ticket Number' );

  } )

  //Open Sherlock in new page
  $( '#game_is_afoot' ).on( 'click', function(e) {
    
    if ( $( '#sherlock' ).val() == '' ) {

    } else {
      let env = 'paypal'
      if ( $('#cal_sb').prop('checked') ) {
        env = 'sandbox';
      }

      let query = $( '#sherlock' ).val();

      let fr_date = $ ('#cal_start_datepicker').val();
      fr_date = fr_date.split("/");
      let fr_yyyy = fr_date[2];
      let fr_mm = fr_date[0];
      let fr_dd = fr_date[1]

      let to_date = $ ('#cal_end_datepicker').val();
      to_date = to_date.split("/");
      let to_yyyy = to_date[2];
      let to_mm = to_date[0];
      let to_dd = to_date[1];
      
      let string = query + ";" + fr_yyyy + "/" + fr_mm + "/" + fr_dd + " 00:00-" + to_yyyy + "/" + to_mm + "/" + to_dd + " 23:59";
      let url = encodeURI( string );

      window.open( 'https://engineering.paypalcorp.com/cal/idsearch/#/environment/' + env + '/id/' + url  );
    }

    $('#sherlock' ).val("");
    $('#cal_start_datepicker' ).val("");
    $('#cal_end_datepicker' ).val("");
    $('#cal_sb').prop('checked', false);
    $('#sherlock' ).attr('placeholder', '  Enter Query' );
    $('#cal_start_datepicker' ).attr('placeholder', '  01/01/2000' );
    $('#cal_end_datepicker' ).attr('placeholder', '  01/01/2000' );
  } )

  //Open Splunk in new page
  $( '#cave_dive' ).on( 'click', function(e) {
    if ( $('#splunk').val() == '' ) {

    } else {
      let env = '';
      if ( $('#cave_app').val() == 'search' ) {
        
      } else {
        env += '-'; 
        env += $('#cave_app').val();
        console.log( env );
      }
  
      let q = "search " + $('#splunk').val();

      let fr_date = $('#cave_start_datepicker').val() + " 02:00";
      let start = moment( fr_date, "M/D/YYYY H:mm").unix();
    
      let to_date = $('#cave_end_datepicker').val();
      to_date = to_date.split("/");
      let to_yyyy = to_date[2];
      let to_mm = to_date[0];
      let to_dd = Math.floor( to_date[1] ) + 1;

      let end_date = to_mm + "/" + to_dd + "/" + to_yyyy + " 02:00";

      let end = moment( end_date, "M/D/YYYY H:mm").unix();
    
      let search = 'https://internal.paypalinc.com/splunkgp/en-US/app/search' + env + '/search?earliest=' + start + '&latest=' + end + '&q=' + q;
      window.open( search );
    }

    $('#splunk' ).val("");
    $('#cave_start_datepicker' ).val("");
    $('#cave_end_datepicker' ).val("");
    $('#cave_app').val("dis");
    $('#splunk' ).attr('placeholder', '  Enter Query' );
    $('#cave_start_datepicker' ).attr('placeholder', '  01/01/2000' );
    $('#cave_end_datepicker' ).attr('placeholder', '  01/01/2000' );
  } )

  //Open Tealeaf in new Page
  $( '#make_tea' ).on( 'click', function(e) {
    
    if ( $( '#tealeaf' ).val() == '' ) {

    } else {
      let query = $( '#tealeaf' ).val();
      query = query.replace(/\s/g,'');

      query = encodeURI( query );
      
      let url = 'https://tealeaf.paypalcorp.com/Portal/SessionSearch.aspx?';

      url += 'archivequery=' + query;
    
      let fr_date = $ ('#tl_start_datepicker').val();
      fr_date = fr_date.split("/");
      let fr_yyyy = fr_date[2];
      let fr_mm = fr_date[0];
      let fr_dd = fr_date[1]

      url += '&startdate=' + fr_yyyy + "-" + fr_mm + "-" + fr_dd;

      let to_date = $ ('#tl_end_datepicker').val();
      to_date = to_date.split("/");
      let to_yyyy = to_date[2];
      let to_mm = to_date[0];
      let to_dd = to_date[1]

      url += '&enddate=' + to_yyyy + "-" + to_mm + "-" + to_dd;

      window.open( url  );
    }

    $('#tealeaf' ).val("");
    $('#tl_start_datepicker' ).val("");
    $('#tl_end_datepicker' ).val("");
    $('#tealeaf' ).attr('placeholder', '  Enter Query' );
    $('#tl_start_datepicker' ).attr('placeholder', '  01/01/2000' );
    $('#tl_end_datepicker' ).attr('placeholder', '  01/01/2000' );
  } )

} ); // end jQuery
